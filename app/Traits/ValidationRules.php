<?php

namespace App\Traits;

trait ValidationRules
{
    public function emailRules()
    {
        return ['required', 'regex:/^[\w\.\-]+@([\w\-]+\.)+[a-zA-Z]{2,}$/', 'unique:users,email'];
    }

    public function phoneRules()
    {
        return ['required', 'regex:/^[0-9]{10,15}$/'];
    }

    public function passwordRules($required = true)
    {
        $rules = ['confirmed', 'min:6', 'regex:/^.*(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).*$/'];
        return $required ? array_merge(['required'], $rules) : $rules;
    }

}
