<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class PromoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'owner_id' => ['required', 'integer', 'exists:'.User::class.',id'],
            'role_id'  => ['required', 'integer', 'exists:'.Role::class.',id']
        ];
    }
}
