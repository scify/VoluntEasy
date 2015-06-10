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
			'name' => 'required',
            'email' => 'required|email'
		];
	}


}
