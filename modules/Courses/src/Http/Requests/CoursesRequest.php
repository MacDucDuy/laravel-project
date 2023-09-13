<?php

namespace Modules\Courses\src\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route()->course;

        $uniqueRule = 'unique:courses,code';

        if ($id) {
            $uniqueRule.=','.$id;
        }

        $rules = [
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'detail' => 'required',
            'teacher_id' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ($value==0) {
                    $fail(__('courses::validation.select'));
                }
            }],
            'thumbnail' => 'required|max:255',
            'code' => 'required|max:255|'.$uniqueRule,
            'is_document' => 'required|integer',
            'supports' => 'required',
            'status' => 'required|integer',
            'categories' => 'required'
        ];

        return $rules;

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => __('user::validation.required'),
            'email' => __('user::validation.email'),
            'unique' => __('user::validation.unique'),
            'min' => __('user::validation.min'),
            'integer' => __('user::validation.integer')
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('user::validation.attributes.name'),
            'email' => __('user::validation.attributes.email'),
            'password' => __('user::validation.attributes.password'),
            'group_id' => __('user::validation.attributes.group_id'),
        ];
    }
}