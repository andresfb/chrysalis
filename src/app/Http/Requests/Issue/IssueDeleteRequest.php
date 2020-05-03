<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IssueDeleteRequest
 *
 * @package App\Http\Requests\Issue
 */
class IssueDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('delete', $this->issue);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
