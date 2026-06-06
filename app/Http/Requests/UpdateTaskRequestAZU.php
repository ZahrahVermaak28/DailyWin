<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;

class UpdateTaskRequestAZU extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization will be handled by policies, so return true here.
        // The policy will check if the user can update the specific task.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['required', Rule::enum(TaskPriorityEnum::class)],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'due_date.after_or_equal' => 'The due date must be today or a future date.',
            'assigned_to.exists' => 'The selected assignee does not exist.',
            'categories.*.exists' => 'One or more selected categories do not exist.',
        ];
    }
}
