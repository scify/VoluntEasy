<?php namespace App\Http\Requests;


class CollaborationRequest extends Request
{

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y',
            'type_id' => 'not_in:"0"',
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
            'end_date.after' => 'Η ημερομηνία λήξης πρέπει να είναι μετά την ημερομηνία έναρξης.',
            'type_id.not_in' => 'Παρακαλώ επιλέξτε τύπο φορέα.',
        ];
    }
}