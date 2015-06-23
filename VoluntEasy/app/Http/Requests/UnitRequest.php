<?php namespace App\Http\Requests;


class UnitRequest extends Request {


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        if(Request::get('type')=='root')
            return [
                'description' => 'required|max:300',
                'comments' => 'required|max:300',
            ];
        else
            return [
                'description' => 'required|max:300',
                'comments' => 'required|max:300'
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
