<?php

if (! function_exists('lineNotify')) {
    function lineNotify($departmentId, $message)
    {
        if($departmentId == 2) {
            exec("curl -X POST -H 'Authorization: Bearer " . config('line_notify.token.civil') . "' -F 'message=" . $message . "' https://notify-api.line.me/api/notify");
        }
    }
}
