<?php

return [
    'registration' => [
        'registered_successfully' => 'We sent the login code to your email. Check spam folder also.',
        'registration_email_code_subject' => 'Login code for '.config('app.name'),
        'registration_email_body_hey' => 'Hey :username,',
        'registration_email_body_login_code' => 'Here is your login code: :code',
        'registration_email_body_footer' => 'Good luck! Hope it works.',
    ],
    'login' => [
        'user_not_found' => 'User with that username not found.',
        'invalid_login_code' => 'Invalid login code. Request another one.',
    ],
    'request_login_code' => [
        'login_code_sent' => 'Login code has been sent to your email. Check the spam folder also.',
        'login_code_email_code_subject' => 'Login code for '.config('app.name'),
    ]
];
