<?php

namespace App\Http\Requests\Issue;

use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;

class IssueUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', $this->issue);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Issue::validationRules();
    }
}
