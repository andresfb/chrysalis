<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectForceDeleteRequest
 * 
 * @package App\Http\Requests\Project
 */
class ProjectForceDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('forceDelete', $this->project);
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
