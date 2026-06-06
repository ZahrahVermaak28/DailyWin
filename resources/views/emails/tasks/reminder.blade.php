<x-mail::message>
# Task Deadline Reminder

This is a friendly reminder that your task **{{ $task->title }}** is due on **{{ $task->formatted_due_date }}**.

**Description:**
{{ $task->description }}

**Status:** {{ $task->status->value }}
**Priority:** {{ $task->priority->value }}

<x-mail::button :url="route("tasks.show", $task)">
View Task
</x-mail::button>

Thanks,
{{ config("app.name") }}
</x-mail::message>
