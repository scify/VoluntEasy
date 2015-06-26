<?php namespace App\Http\Requests;


class ActionRequest extends Request
{


    /**
     * Get the validation rules that apply to the request.
     * If the id is null, return the validation rules for the create form,
     * else return the validation rules for the edit form.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:255',
            'comments' => 'required|max:255',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y|after:start_date',
            'unit_id' => 'required'
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
            'unit_id.required' => 'Παρακαλώ επιλέξτε Οργανωτική Μονάδα.',
        ];
    }

}
