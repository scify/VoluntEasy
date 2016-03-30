<?php namespace App\Http\Requests;


class UserRequest extends Request {


    /**
     * Get the validation rules that apply to the request.
     * If the id is null, return the validation rules for the create form,
     * else return the validation rules for the edit form.
     *
     * @return array
     */
    public function rules() {

        if (Request::get('id') == null)
            return [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:8|regex:#[0-9]+#',
                'tel' => 'required|max:50',
                'image' => 'image'
            ];
        else
            return [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'confirmed|min:8',
                'tel' => 'required|max:50',
                'image' => 'image'
            ];
    }


    /**
     * Custom error messages that override those defined in validation.php file.
     *
     * @return array
     */
    public function messages() {
        return [
        ];
    }

}
