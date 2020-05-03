<?php

namespace App\Http\Requests\Issue;

use App\Models\Issue;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IssueStoreRequest
 *
 * @package App\Http\Requests\Issue
 */
class IssueStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Issue::class);
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
