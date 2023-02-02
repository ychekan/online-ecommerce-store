<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'not_valid_credentials' => 'The provided credentials do not match our records.',
    'not_valid_password' => 'The provided password do not match our records.',
    'not_email_verified_at' => 'Email is not verified.',
    'cant_find_token' => 'Can\'t find token.',
    'cant_find_token_for_user' => 'Can\'t find token for this user.',
    'you_cant_refresh_this_token' => 'You can\'t refresh this token',

    'verify_email' => [
        'failed' => 'Can\'t verify email.',
        'success' => 'Email is verified.',
        'token_not_validate' => 'Token is not validate.',
        'verify_before' => 'Token is verified before.',
    ],

    'reset_password' => [
        'invalid_token' => 'Invalid token',
        'user_not_found' => 'User not found',
        'expired_token' => 'Token is expired.',
    ],

];
