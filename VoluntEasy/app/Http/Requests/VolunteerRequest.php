<?php namespace App\Http\Requests;

/**
 * This FormRequest is used to validate the object send from the volunteer forms (create, edit...)
 *
 * @package App\Http\Requests
 */
class VolunteerRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        /* if(Request::has('files[]') && Request::get('files[]')!=null)
             VolunteerService::storeFiles(Request::get('files[]'));
        */
        if (Request::get('id') == null)
            return [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'gender_id' => 'required',
                'email' => 'required|email|unique:volunteers',
                'education_level_id' => 'required',
                'work_status_id' => 'required',
                'participation_reason' => 'required',
            ];
        else
            return [
                'name' => 'required',
                'last_name' => 'required',
                'birth_date' => 'required',
                'gender_id' => 'required',
                'email' => 'required|email',
                'education_level_id' => 'required',
                'work_status_id' => 'required',
                'participation_reason' => 'required',
                'files[]' => 'required|max:10000'
            ];
    }

    /**
     * Custom messages in Greek
     *
     * @return array
     */
    public function messages() {
        return [
            'files[].mimes' => 'Το αρχείο πρέπει να έχει κατάληξη .doc, .docx, .pdf.',
            'files[].max' => 'Το αρχείο δεν πρέπει να ξεπερνά σε μέγεθος τα 10mb.',
            'files[].required' => 'paparakia',
        ];
    }

}
