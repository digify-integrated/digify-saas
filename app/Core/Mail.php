<?php

namespace App\Core;

class Mail
{
    public static function send($to, $subject, $message, $headers = '')
    {
        // Simple wrapper around mail() for now
        return mail($to, $subject, $message, $headers);
    }
}
