<?php namespace App\Http\Requests;


class TaskRequest extends Request
{

    public function rules()
    {
        return [
            'name' => 'required|max:255',
        ];
    }


    /**
     * Custom error messages that override those defined in validation.php file.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
