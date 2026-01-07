<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // filters
        $status = $request->query('status', 'all'); // all|unread|read
        $actor = $request->query('actor');
        $action = $request->query('action');
        $subtest = $request->query('subtest');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $perPage = intval($request->query('per_page', 20));
        $onlyMe = $request->query('only_me', false);
        if ($perPage <= 0 || $perPage > 200) $perPage = 20;

        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($status === 'unread') {
            $query->whereNull('read_at');
        } elseif ($status === 'read') {
            $query->whereNotNull('read_at');
        }

        if ($actor) {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.actor')) LIKE ?", ["%{$actor}%"]);
        }

        if ($action) {
            // action is expected to be exact (menambahkan/mengedit/menghapus)
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.action')) = ?", [$action]);
        }

        if ($subtest) {
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.subtest')) LIKE ?", ["%{$subtest}%"]);
        }

        if ($onlyMe) {
            $actorId = $user->account_id ?? '';
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.actor_id')) = ?", [$actorId]);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $notifications = $query->paginate($perPage)->withQueryString();

        $role = $user->role ?? '';

        // If AJAX request, return JSON with HTML
        if ($request->ajax()) {
            $listHtml = view('notifications.partials.list', compact('notifications'))->render();
            $paginationHtml = $notifications->links('components.pagination')->render();
            
            return response()->json([
                'success' => true,
                'listHtml' => $listHtml,
                'paginationHtml' => $paginationHtml,
                'firstItem' => $notifications->firstItem() ?? 0,
                'lastItem' => $notifications->lastItem() ?? 0,
                'total' => $notifications->total(),
            ]);
        }

        return view('notifications.index', [
            'notifications' => $notifications,
            'role' => $role,
            'filters' => [
                'status' => $status,
                'actor' => $actor,
                'action' => $action,
                'subtest' => $subtest,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'per_page' => $perPage,
                'only_me' => $onlyMe,
            ],
        ]);
    }

    public function markAllRead(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    public function markRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification && is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        // If AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }
}
