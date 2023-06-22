<?php

return [

    'suspicious_login_attempt' => [
        'subject' => 'Authorize Login Attempt.',
        'explanation_text' => 'An attempt to login to your account was made from an unknown browser, device or location. Please confirm the following details are correct',
        'time' => 'Time: :time',
        'location' => 'Location: :location',
        'ip_address' => 'IP Address: :ip_address',
        'browser' => 'Browser: :browser',
        'operating_system' => 'Operating System: :operating_system',
        'warning_text' => 'If you did not make this attempt, please change your password.',
        'action' => 'Verify',
    ],

    'email_verification' => [
        'action' => 'Verify',
        'explanation_text' => 'You are receiving this email because an account has just been created with this email addresss. We would like to verify this email address before this account can make use of our core features.',
        'no_action_text' => 'If you did not create an account, no futher action is required.',
    ],

    'reset_password' => [
        'action' => 'Reset',
        'explanation_text' => 'You are receiving this email because we received a password reset request for your account.',
        'no_action_text' => 'If you did not request a password reset, no further action is required.',
    ],

    'footer' => [
        'trouble_clicking_action' => 'Having trouble clicking the ":action" button? Copy and paste the URL below into your web browser:',
    ],

    'general_greeting' => 'Hello!',
    'general_greeting_user' => 'Hello :user!',

];
