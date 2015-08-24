<?php namespace App\Http\Requests;


class ActionRequest extends Request
{

    public function rules()
    {
        return [
            'description' => 'required|max:255',
            'comments' => 'required|max:255',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y',
            'unit_id' => 'required',
            'email' => 'email',
            'questionnaire_action_link' => 'active_url',
            'questionnaire_volunteers_link' => 'active_url'
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
            'end_date.after' => 'Η ημερομηνία λήξης πρέπει να είναι μετά την ημερομηνία έναρξης.',
            'questionnaire_action_link.active_url' => 'Ο σύνδεσμος δεν είναι έγκυρος.',
            'questionnaire_volunteers_link.active_url' => 'Ο σύνδεσμος δεν είναι έγκυρος.',
        ];
    }
}
