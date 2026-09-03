<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "full_name" => "required",
            "address" => "required",
            "phone_number" => "required",
            "job" => "required",
            "husband_name" => "required",
            "husband_occupation" => "required",
            "photo" => "nullable",
            "regency_id" => "required",
            "username" => "required",
            "member_role_id" => "required",
            "member_type_id" => "required"
        ];
    }
}
