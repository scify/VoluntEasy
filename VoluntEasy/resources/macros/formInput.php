<?php

/**
 * Form macros extend the Form facade with additional functionality.
 * Macro 'formInput' is responsible for constructing the label+input+errors
 * for a form.
 *
 * To create a custom form input, use the following syntax:
 *
 * --Plain input field
 * {!! Form::formInput('field_id/name', 'Field Label:', $errors, ['class' => 'form-control']) !!}
 *
 * --Textarea
 * {!! Form::formInput('field_id/name', 'Field label', $errors, ['class' => 'form-control', 'type' => 'textarea']) !!}
 *
 * --Date
 * {!! Form::formInput('field_id/name', 'Field Label:', $errors, ['class' => 'form-control', 'id' => 'field_id']) !!}
 * (we also set the field id in order to initialize the datepicker widget)
 *
 * --Select
 * {!! Form::formInput('field_id/name', 'Field Label:', $errors, ['class' => 'form-control', 'type' => 'select', 'value' => $arrayWithValues, 'checked' => 'true/false']) !!}
 *
 * --Checkbox
 * {!! Form::formInput('field_id/name', 'Field Label:', $errors, ['class' => 'form-control', 'type' => 'checkbox', 'value' => 'whatever', 'checked' => 'true/false']) !!}
 *
 * --Radio
 * {!! Form::formInput('field_id/name', '', $errors, ['class' => 'form-control', 'type' => 'radio', 'value' => $key]) !!}
 *
 * --Required input
 * {!! Form::formInput('field_id/name', 'Field Label:', $errors, ['class' => 'form-control', 'required' => 'true']) !!}
 *
 */

Form::macro('formInput', function ($field, $label, $errors, array $attributes) {
    //creating the html for the label tag
    if ($label != null)
        $label_html = Form::label($field, $label);
    else
        $label_html = '';

    //if the field is required, then add a star to indicate that the user must fill it
    if (array_key_exists('required', $attributes) && $attributes['required'] == 'true') {
        $label_html = $label_html . ' <span class="star">*</span>';
        unset($attributes['required']);
    }

    $type = '';

    //creating the html for the input tag according to its type
    if (array_key_exists('type', $attributes)) {
        if (array_key_exists('value', $attributes)) {
            $value = $attributes['value'];
            unset($attributes['value']);
        } else
            $value = null;
        switch ($attributes['type']) {
            case "password":
                $text_html = Form::password($field, $attributes);
                break;
            case "textarea":
                $text_html = Form::textarea($field, $value, $attributes);
                break;
            case "select":
                if (array_key_exists('key', $attributes)) {
                    $key = $attributes['key'];
                    unset($attributes['key']);
                    $text_html = Form::select($field, $value, $key, $attributes);
                } else
                    $text_html = Form::select($field, $value, '', $attributes);
                break;
            case "checkbox":
                $checked = $attributes['checked'] == 'true' ? true : false;
                unset($attributes['checked']);
                $text_html = Form::checkbox($field, $value, $checked);
                $type = 'checkbox';
                break;
            case "radio":
                $checked = $attributes['checked'] == 'true' ? true : false;
                unset($attributes['checked']);
                $text_html = Form::radio($field, $value, $checked, $attributes);
                break;
            case "date":
                $text_html = Form::input('date', $field);
                break;
            case "hidden":
                $text_html = Form::hidden($field, null, $attributes);
                break;
            case "file":
                $text_html = Form::file($field, null, $attributes);
                break;
            default:
                $text_html = Form::text($field, null, $attributes);
        }
        unset($attributes['type']);
    } else {
        $text_html = Form::text($field, null, $attributes);
    }

    if (array_key_exists('required', $attributes)) {
        $label_html = $label_html . ' <span class="star">*</span>';
        unset($attributes['required']);
    }


    $msg_html = '';

    if ($errors->has($field)) {
        //create the html for the p tag that will hold the error message
        $msg_html .= '<p class="help-block">';
        $msg_html .= $errors->first($field);
        $msg_html .= '</p>';

        //wrap the label, input and error msg into an error div
        if ($type == 'checkbox')
            return '<div class="has-error">' . $text_html . $label_html . $msg_html . '</div>';

        return '<div class="has-error">' . $label_html . $text_html . $msg_html . '</div>';
    } else {
        if ($type == 'checkbox')
            return $text_html . $label_html . $msg_html;

        return $label_html . $text_html . $msg_html;
    }
});
