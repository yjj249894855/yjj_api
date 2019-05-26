<?php

namespace App\Modules\UserAdmin\Http\Requests;


use App\Common\Utils\CommonUtil;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

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
        if (CommonUtil::getCurrentAction() == 'update') {
            $rules = [
                'name' => 'required' //name不为空
            ];
        }
        if (CommonUtil::getCurrentAction() == 'store') {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ];
        }
        return $rules;
    }
}
