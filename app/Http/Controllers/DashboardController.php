<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): Factory|View|RedirectResponse
    {
        $user = auth()->user();
        $role = strtolower($user->role ?? '');

        if ($role == 'staff' || $role == 'admin') {
            $total_acc = DB::table('AccountSummary')->get();
            
            // Get monthly subtest statistics for the current year
            $monthlyStats = $this->getMonthlySubtestStats();
            
            // Get available years for filter dropdown
            $availableYears = $this->getAvailableYears();

            // Calculate Recap Statistics (UMPB vs Bank Soal)
            // UMPB: subtest_id is NULL
            $recap1 = DB::table('scores')
                ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
                ->where('accounts.role', 'PARTICIPANT')
                ->whereNull('scores.subtest_id')
                ->count();

            // Bank Soal: subtest_id is NOT NULL
            $recap2 = DB::table('scores')
                ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
                ->where('accounts.role', 'PARTICIPANT')
                ->whereNotNull('scores.subtest_id')
                ->count();
            
            return view("dashboard/$role", [
                'total_acc' => $total_acc,
                'monthlyStatsLabels' => $monthlyStats['labels'],
                'monthlyStatsLabelsWithYear' => $monthlyStats['labelsWithYear'],
                'monthlyStatsData' => $monthlyStats['data'],
                'availableYears' => $availableYears,
                'currentYear' => now()->year,
                'recap1' => $recap1,
                'recap2' => $recap2
            ]);
        } else {
            return view('page-error-400');
        }
    }
    
    /**
     * Get monthly subtest statistics (participant count per month)
     * Returns data for specified year
     */
    private function getMonthlySubtestStats($year = null): array
    {
        // Use current year if not specified
        $year = $year ?? now()->year;
        
        $stats = DB::table('scores')
            ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
            ->select(
                DB::raw('DATE_FORMAT(scores.recorded_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as subtest_count')
            )
            ->whereYear('scores.recorded_at', $year)
            ->where('accounts.role', '=', 'PARTICIPANT')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        // Create array for all 12 months (January to December)
        $months = [];
        $monthsWithYear = [];
        $data = [];
        
        for ($i = 1; $i <= 12; $i++) {
            // Use createFromDate to avoid day overflow issues (e.g. 31st of month -> Feb)
            $date = \Carbon\Carbon::createFromDate((int)$year, $i, 1);
            $monthKey = $date->format('Y-m');
            $monthLabel = $date->translatedFormat('F'); // Full Indonesian month name (Januari, Februari, etc)
            $monthLabelWithYear = $date->translatedFormat('F Y'); // Full label with year for tooltip
            
            $months[] = $monthLabel;
            $monthsWithYear[] = $monthLabelWithYear;
            
            // Find count for this month
            $found = $stats->firstWhere('month', $monthKey);
            $data[] = $found ? $found->subtest_count : 0;
        }
        
        return [
            'labels' => $months,
            'labelsWithYear' => $monthsWithYear,
            'data' => $data
        ];
    }
    
    /**
     * API endpoint to get chart data for a specific year
     */
    public function getChartData($year)
    {
        $stats = $this->getMonthlySubtestStats($year);
        
        return response()->json([
            'labels' => $stats['labels'],
            'labelsWithYear' => $stats['labelsWithYear'],
            'data' => $stats['data']
        ]);
    }
    
    /**
     * Get available years from scores table
     * Returns a continuous range from earliest year to current year
     */
    public function getAvailableYears()
    {
        // Get the earliest year with data
        $minYear = DB::table('scores')
            ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
            ->where('accounts.role', '=', 'PARTICIPANT')
            ->selectRaw('MIN(YEAR(scores.recorded_at)) as min_year')
            ->value('min_year');
        
        // If no data exists, return current year only
        if (!$minYear) {
            return [now()->year];
        }
        
        $currentYear = now()->year;
        
        // Generate continuous range from min year to current year
        $years = [];
        for ($year = $currentYear; $year >= $minYear; $year--) {
            $years[] = $year;
        }
        
        return $years;
    }

    /**
     * Get recap statistics filtered by date
     */
    public function getRecapStats(\Illuminate\Http\Request $request)
    {
        $filterType = $request->input('type', 'yearly'); // daily, monthly, yearly
        $filterValue = $request->input('value', now()->year);

        // Base query for UMPB (subtest_id IS NULL)
        $query1 = DB::table('scores')
            ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
            ->where('accounts.role', 'PARTICIPANT')
            ->whereNull('scores.subtest_id');

        // Base query for Bank Soal (subtest_id IS NOT NULL)
        $query2 = DB::table('scores')
            ->join('accounts', 'scores.account_id', '=', 'accounts.account_id')
            ->where('accounts.role', 'PARTICIPANT')
            ->whereNotNull('scores.subtest_id');

        // Apply filters
        if ($filterType == 'daily') {
            // value format: YYYY-MM-DD
            $query1->whereDate('scores.recorded_at', $filterValue);
            $query2->whereDate('scores.recorded_at', $filterValue);
        } elseif ($filterType == 'monthly') {
            // value format: YYYY-MM
            $parts = explode('-', $filterValue);
            if (count($parts) == 2) {
                $query1->whereYear('scores.recorded_at', $parts[0])->whereMonth('scores.recorded_at', $parts[1]);
                $query2->whereYear('scores.recorded_at', $parts[0])->whereMonth('scores.recorded_at', $parts[1]);
            }
        } else {
            // yearly (default) - value format: YYYY
            $query1->whereYear('scores.recorded_at', $filterValue);
        }

        // --- Details Breakdown (Subtests) ---
        // We want ALL subtests, and count matching scores
        // Select subtest_name, count(scores.id)
        $details = DB::table('subtests')
            ->select('subtests.subtest_name', 'subtests.subtest_image_name', DB::raw('COUNT(scores.score_id) as count'))
            // Join scores for stats
            ->leftJoin('scores', function($join) use ($filterType, $filterValue) {
                $join->on('subtests.subtest_id', '=', 'scores.subtest_id');
                
                // Apply date filters ON THE JOIN to ensure we keep subtests with 0 count
                if ($filterType == 'daily') {
                    $join->whereDate('scores.recorded_at', $filterValue);
                } elseif ($filterType == 'monthly') {
                    $parts = explode('-', $filterValue);
                    if (count($parts) == 2) {
                        $join->whereYear('scores.recorded_at', $parts[0])->whereMonth('scores.recorded_at', $parts[1]);
                    }
                } else {
                    $join->whereYear('scores.recorded_at', $filterValue);
                }
            })
            // Join accounts to ensure participant role (optional but safer)
            ->leftJoin('accounts', function($join) {
                 $join->on('scores.account_id', '=', 'accounts.account_id')
                      ->where('accounts.role', 'PARTICIPANT');
            })
            ->groupBy('subtests.subtest_id', 'subtests.subtest_name', 'subtests.subtest_image_name')
            ->get();


        return response()->json([
            'recap1' => $query1->count(),
            'recap2' => $query2->count(),
            'details' => $details
        ]);
    }
}
