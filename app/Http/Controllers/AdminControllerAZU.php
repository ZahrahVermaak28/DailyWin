<?php

namespace App\Http\Controllers;

use App\Models\CategoryAZU;
use App\Models\TaskAZU;
use App\Models\UserAZU;
use Illuminate\View\View;

class AdminControllerAZU extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'tasks' => TaskAZU::with(['creator', 'assignee', 'categories'])->latest()->limit(8)->get(),
            'users' => UserAZU::query()->latest()->limit(8)->get(),
            'categories' => CategoryAZU::withCount('tasks')->orderBy('name')->get(),
            'taskCount' => TaskAZU::count(),
            'userCount' => UserAZU::count(),
            'categoryCount' => CategoryAZU::count(),
        ]);
    }
}
