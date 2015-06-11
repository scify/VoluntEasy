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
            'addr' => 'required|max:255',
            'tel' => 'required|max:50',
		];
	}


    /**
     * Custom error messages that override those defined in validation.php file.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'Το email χρησιμοποιείται ήδη.',
            'password.min' => 'Ο κωδικός πρέπει να έχει μήκος πάνω από 6 χαρακτήρες.',
            'password.confirmed' => 'Οι κωδικοί δεν είναι ίδιοι.',
        ];
    }

}
