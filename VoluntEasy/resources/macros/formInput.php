<?php

/**
 *  Form macros extend the Form facade with additional functionality.
 *  Macro 'formInput' is responsible for constructing the label+input+errors
 * for a form.
 *
 */

Form::macro('formInput', function ($field, $label, $errors, array $attributes) {
    //creating the html for the label tag
    $label_html = Form::label($field, $label);

    //creating the html for the input tag
    //if the input is f type password, create a password input
    if (array_key_exists('type', $attributes) && $attributes['type'] == 'password') {
        //useless, remove from attributes array
        unset($attributes['type']);
        $text_html = Form::password($field, $attributes);
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