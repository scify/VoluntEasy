<?php namespace App\Http\Requests;


class ActionRequest extends Request
{

    public function rules()
    {
        return [
            'description' => 'required|max:255',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y',
            'unit_id' => 'required',
            'email' => 'email',
            'volunteer_sum' => 'numeric'
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
            'unit_id.required' => trans('entities/actions.unitIdRequired'),
            'end_date.after' => trans('entities/actions.endDateAfter'),
            'volunteer_sum.numeric' => trans('entities/actions.volunteerSumNumeric'),
        ];
    }
}
