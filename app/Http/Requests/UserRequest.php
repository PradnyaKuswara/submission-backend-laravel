<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::when($this->conditionalEmailUpdate(), Rule::unique(User::class)->ignore($this->route('user')->id), 'unique:users,email')],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ];
    }

    protected function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 422,
            'message' => 'Validation Error.',
            'data' => $validator->errors(),
        ], 422));
    }

    private function conditionalEmailUpdate(): bool
    {
        return $this->isMethod('patch') || $this->isMethod('put') || request()->input('_method') == 'patch' || request()->input('_method') == 'put';
    }
}
