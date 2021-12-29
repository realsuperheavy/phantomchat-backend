<?php

namespace App\ApiSource\Version1\AppLogs\Controllers;

use App\Models\AppLog;
use Illuminate\Http\Request;

class AppLogsController
{
    public function create(Request $request)
    {
        $info = $request->get('info');
        if (is_array($info)) {
            $info = json_encode($info);
        }

        $appLog = new AppLog();
        $appLog
            ->setInfo($info)
            ->setPlatform($request->platform);
        $appLog->save();
    }
}
