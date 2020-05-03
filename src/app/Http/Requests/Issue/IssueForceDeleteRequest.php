<?php

namespace App\Http\Requests\Issue;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IssueForceDeleteRequest
 *
 * @package App\Http\Requests\Issue
 */
class IssueForceDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('forceDelete', $this->issue);
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
