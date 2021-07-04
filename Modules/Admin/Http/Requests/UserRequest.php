<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserRequest extends FormRequest
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
        $rules = [];

        $method = $this->getMethod();

        switch ($method) {
            case 'POST':
                $rules['login'] = ['required', 'string', 'max:50', 'unique:users'];
                $rules['password'] = ['required', 'string', 'max:50'];
                $rules['telegram_id'] = ['sometimes', 'nullable', 'string', 'unique:users'];
                $rules['phone'] = ['sometimes', 'nullable', 'string', 'max:50','unique:users'];
                break;
            case 'PUT':
            case 'PATCH':
                $rules['password'] = ['sometimes', 'nullable', 'string', 'max:50'];
                $rules['telegram_id'] = ['sometimes', 'nullable', 'string', 'unique:users,telegram_id,' . $this->user->id];
                $rules['phone'] = ['sometimes', 'nullable', 'string', 'max:50','unique:users,phone,' . $this->user->id];
                break;
        }

        
        $rules['first_name'] = ['sometimes', 'nullable', 'string', 'max:50'];
        $rules['last_name'] = ['sometimes', 'nullable', 'string', 'max:50'];
        
        $rules['role'] = ['sometimes', 'nullable', $this->allowRoles()];

        return $rules;
    }

    private function allowRoles()
    {
        return Rule::in(Role::all()->pluck('name'));
    }
}
