<?php

namespace App\Http\Controllers;

use App\Models\TaskAZU;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardControllerAZU extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $baseQuery = TaskAZU::query()
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('created_by', $user->id)
                        ->orWhere('assigned_to', $user->id);
                });
            });

        return view('dashboard', [
            'totalTasks' => (clone $baseQuery)->count(),
            'completedTasks' => (clone $baseQuery)->where('status', 'completed')->count(),
            'pendingTasks' => (clone $baseQuery)->where('status', 'pending')->count(),
            'inProgressTasks' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'highPriorityPendingTasks' => (clone $baseQuery)->where('priority', 'high')->where('status', 'pending')->count(),
            'tasksDueThisWeek' => (clone $baseQuery)->whereBetween('due_date', [Carbon::today(), Carbon::today()->addWeek()])->count(),
            'recentTasks' => (clone $baseQuery)->with(['assignee', 'categories'])->latest()->limit(6)->get(),
        ]);
    }
}
