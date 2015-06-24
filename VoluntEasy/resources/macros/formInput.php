<?php

/**
 *  Form macros extend the Form facade with additional functionality.
 *  Macro 'formInput' is responsible for constructing the label+input+errors
 * for a form.
 *
 * To create a custom form input, use the following syntax:
 *
 * {!! Form::formInput('inputName', 'Field label', $errors, ['class' => 'form-control', 'type' => 'textarea']) !!}
 *
 * Available types: password, textarea, date, text
 *
 */

Form::macro('formInput', function ($field, $label, $errors, array $attributes) {
    //creating the html for the label tag
    if ($label != null)
        $label_html = Form::label($field, $label);
    else
        $label_html='';

        //creating the html for the input tag according to its type
        if (array_key_exists('type', $attributes)) {
            switch ($attributes['type']) {
                case "password":
                    $text_html = Form::password($field, $attributes);
                    break;
                case "textarea":
                    $text_html = Form::textarea($field, null, $attributes);
                    break;
                case "date":
                    $text_html = Form::input('date', $field);
                    break;
                case "hidden":
                    $text_html = Form::hidden($field, null, $attributes);
                    break;
                default:
                    $text_html = Form::text($field, null, $attributes);
            }
            unset($attributes['type']);
        } else {
            $text_html = Form::text($field, null, $attributes);
        }


    $msg_html = '';

    if ($errors->has($field)) {
        //create the html for the p tag that will hold the error message
        $msg_html .= '<p class="help-block">';
        $msg_html .= $errors->first($field);
        $msg_html .= '</p>';

        //wrap the label, input and error msg into an error div
        return '<div class="has-error">' . $label_html . $text_html . $msg_html . '</div>';
    } else {
        return $label_html . $text_html . $msg_html;
    }
});