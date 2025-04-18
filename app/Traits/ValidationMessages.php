<?php

namespace App\Traits;

trait ValidationMessages
{
    
    public function nameMessages()
    {
        return [
            'name.required' => 'Please provide your full name.',
        ];
    }

    public function emailMessages()
    {
        return [
            'email.required' => 'We need your email address to register.',
            'email.regex' => 'Please provide a valid email address.',
        ];
    }

    public function phoneMessages()
    {
        return [
            'phone.required' => 'Please provide your phone number.',
        ];
    }

    public function passwordMessages()
    {
        return [
            'password.required' => 'Password is required.',
            'password.regex' => 'Password must be at least 6 characters, and include uppercase, lowercase, a number, and a special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    public function newPasswordMessages()
    {
        return [
            'new_password.required' => 'New password is required.',
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password.regex' => 'Password must be at least 6 characters, and include uppercase, lowercase, a number, and a special character.',
        ];
    }
}
