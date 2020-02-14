<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'fullName' => 'required|max:256',
            'photo' => 'required|max:5120|mimes:jpeg,png|dimensions:min_width=300,min_height=300',
            'position' => 'required|int',
            'salary' => 'required|numeric|between:1,500000',
            'phone' => 'required|phone:12',
            'date' => 'required|date_format:d.m.y',
            'head' => 'required|exists:employees,full_name'
        ];
    }

    public function messages()
    {
        return [
            'phone.phone' => 'Invalid phone format.'
        ];
    }
}
