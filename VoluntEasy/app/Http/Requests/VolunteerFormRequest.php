<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * This FormRequest is used to validate the object send from the volunteer forms (create, edit...)
 *
 * @package App\Http\Requests
 */
class VolunteerFormRequest extends Request {

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
	public function rules()
	{
		return [
                        /*
			 * 'name' => 'required|max:100',
			 * 'last_name' => 'required|max:100',
			 * 'fathers_name' => 'required|max:100',
			 * 'gender_id' => 'required',
			 * 'email' => 'required|email',
			 * 'education_level_id' => 'required',
			 * 'work_status_id' => 'required',
			 * 'participation_reason' => 'required|max:300',
                         */
		];
	}

    /**
     * Custom messages in Greek
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please provide a brief link description',
            'url.required' => 'Please provide a URL',
            'url.url' => 'A valid URL is required',
            'category.required' => 'Please associate this link with a category',
            'category.min' => 'Please associate this link with a category'
        ];
    }

}
