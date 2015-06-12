<?php namespace App\Http\Requests;


class UnitRequest extends Request {


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'description' => 'required|max:300',
            'comments' => 'required|max:300',
            'parent_unit_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
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
           // 'comments.required' => '//.',
        ];
    }

}
