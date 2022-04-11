<?php

if (! function_exists('lineNotify')) {
    function lineNotify($departmentId, $message)
    {
        $lineUrl = "https://notify-api.line.me/api/notify";

        if($departmentId == 2) {
            exec("curl -X POST -H 'Authorization: Bearer " . config('line_notify.token.civil') . "' -F 'message=" . $message . "' " . $lineUrl);
        }

        if($departmentId == 3 || $departmentId == 4) {
            exec("curl -X POST -H 'Authorization: Bearer " . config('line_notify.token.architecture') . "' -F 'message=" . $message . "' " . $lineUrl);
        }
    }
}
