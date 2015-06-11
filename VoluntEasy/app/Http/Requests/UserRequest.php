<?php namespace App\Http\Requests;


class UserRequest extends Request {


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'confirmPassword' => 'same:password',
            'addr' => 'required|max:255',
            'tel' => 'required|max:50',
		];
	}


}
