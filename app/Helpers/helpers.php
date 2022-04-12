<?php

if (!function_exists('lineNotify')) {
    function lineNotify($departmentId, $message)
    {
        $lineUrl = 'https://notify-api.line.me/api/notify';

        if (2 === $departmentId) {
            exec("curl -X POST -H 'Authorization: Bearer ".config('line_notify.token.civil')."' -F 'message=".$message."' ".$lineUrl);
        }

        if (3 === $departmentId || 4 === $departmentId) {
            exec("curl -X POST -H 'Authorization: Bearer ".config('line_notify.token.architecture')."' -F 'message=".$message."' ".$lineUrl);
        }
    }
}
