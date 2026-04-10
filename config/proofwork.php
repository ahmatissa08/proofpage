<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ProofWork Config
    |--------------------------------------------------------------------------
    */

    // Admin panel password
    'admin_password' => env('PROOFWORK_ADMIN_PASSWORD', 'changeme123'),

    // Admin notification email (your email)
    'admin_email' => env('PROOFWORK_ADMIN_EMAIL', null),

    // Telegram
    'telegram_bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
    'telegram_chat_id'   => env('TELEGRAM_CHAT_ID', ''),
];
