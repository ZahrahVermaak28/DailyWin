<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TaskAZU;
use App\Mail\TaskReminderMailableAZU;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskRemindersAZU extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders-azu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders for tasks due tomorrow.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $tasks = TaskAZU::with(['assignee', 'creator'])
                        ->whereDate('due_date', $tomorrow)
                        ->where('status', '!=', 'completed')
                        ->get();

        foreach ($tasks as $task) {
            if ($task->assignee) {
                Mail::to($task->assignee->email)->send(new TaskReminderMailableAZU($task));
                $this->info("Reminder sent for task: {$task->title} to {$task->assignee->email}");
            } else if ($task->creator) {
                Mail::to($task->creator->email)->send(new TaskReminderMailableAZU($task));
                $this->info("Reminder sent for task: {$task->title} to {$task->creator->email}");
            }
        }

        $this->info('Task due date reminders sent successfully!');
    }
}
