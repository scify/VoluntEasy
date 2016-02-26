<?php namespace App\Http\Requests;


class CTAVolunteerRequest extends Request {

    public function rules() {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'dates' => 'required'
            //'email' => 'required|email|unique:cta_volunteers',
        ];
    }


    /**
     * Custom error messages that override those defined in validation.php file.
     *
     * @return array
     */
    public function messages() {
        return [
            'dates.required' => 'fdfdf'
        ];
    }
}
