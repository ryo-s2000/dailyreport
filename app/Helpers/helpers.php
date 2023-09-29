<?php

if (!function_exists('lineNotify')) {
    function lineNotify($departmentId, $message): void
    {
        $lineUrl = 'https://notify-api.line.me/api/notify';
        $token = '';

        if (2 === $departmentId) {
            $token = config('line_notify.token.civil');
        }

        if (3 === $departmentId || 4 === $departmentId) {
            $token = config('line_notify.token.architecture');
        }

        exec("curl -X POST -H 'Authorization: Bearer ".$token."' -F 'message=".$message."' ".$lineUrl);
    }
}

if (!function_exists('GoogleChatNotify')) {
    function GoogleChatNotify($departmentId, $message): void
    {
        $url = '';

        if (1 === $departmentId) {
            $url = config('google_chat_notify.webhook_url.house');
        }

        if (2 === $departmentId) {
            $url = config('google_chat_notify.webhook_url.civil');
        }

        if (3 === $departmentId || 4 === $departmentId || 6 === $departmentId) {
            $url = config('google_chat_notify.webhook_url.architecture');
        }

        if (5 === $departmentId) {
            $url = config('google_chat_notify.webhook_url.tokyo');
        }

        exec("curl -X POST --data "."'".'{"text": "'.$message.'"}'."'"." -H 'Content-Type: application/json' "."'".$url."'");
    }
}
