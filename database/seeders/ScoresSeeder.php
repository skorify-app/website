<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('scores')->truncate(); // Truncate can fail with FKs
        DB::table('scores')->delete(); // Safer deletion


        // Get existing participant accounts
        $participants = DB::table('accounts')
            ->where('role', 'PARTICIPANT')
            ->pluck('account_id')
            ->toArray();
        
        if (empty($participants)) {
            $this->command->error('No participant accounts found. Please create participant accounts first.');
            return;
        }
        
        // Get all subtests
        $subtests = DB::table('subtests')
            ->pluck('subtest_id')
            ->toArray();
        
        if (empty($subtests)) {
            $this->command->error('No subtests found. Please seed subtests first.');
            return;
        }
        
        $this->command->info('Found ' . count($participants) . ' participants and ' . count($subtests) . ' subtests');
        
        $years = [2025, 2026];
        $totalScores = 0;
        
        foreach ($years as $year) {
            $this->command->info("Generating score records for {$year}...");
            
            // Define monthly distribution for this year
            // Determine random variations for each year so they look different
            $monthlyScoreCounts = [];
            for ($m = 1; $m <= 12; $m++) {
                // 2025 has slightly less activity than 2026
                $baseCount = ($year == 2025) ? rand(5, 25) : rand(8, 35);
                $monthlyScoreCounts[$m] = $baseCount;
            }
            
            foreach ($monthlyScoreCounts as $month => $scoreCount) {
                for ($i = 0; $i < $scoreCount; $i++) {
                    // Random participant
                    $accountId = $participants[array_rand($participants)];
                    
                    // Random subtest or NULL for UMPB (30% chance for UMPB)
                    $isUMPB = (rand(1, 100) <= 30);
                    $subtestId = $isUMPB ? null : $subtests[array_rand($subtests)];
                    
                    // Random day in the month
                    $day = rand(1, Carbon::create($year, $month, 1)->daysInMonth);
                    $recordedAt = Carbon::create($year, $month, $day)
                        ->setHour(rand(8, 20))
                        ->setMinute(rand(0, 59))
                        ->setSecond(rand(0, 59));
                    
                    try {
                        DB::table('scores')->insert([
                            'account_id' => $accountId,
                            'subtest_id' => $subtestId,
                            'score' => rand(60, 100),
                            'recorded_at' => $recordedAt
                        ]);
                        $totalScores++;
                    } catch (\Exception $e) {
                        $this->command->warn('Failed to create score (SubtestID: ' . ($subtestId ?? 'NULL') . '): ' . $e->getMessage());
                    }
                }
            }
            $this->command->info("Year {$year} completed.");
        }
        
        $this->command->info('Successfully generated ' . $totalScores . ' score records across ' . count($years) . ' years!');
        
        // Show yearly breakdown
        $this->command->info('Verifying yearly distribution...');
        $yearlyStats = DB::table('scores')
            ->select(
                DB::raw('YEAR(recorded_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();
            
        foreach ($yearlyStats as $stat) {
            $this->command->info($stat->year . ': ' . $stat->count . ' scores');
        }
    }
}
