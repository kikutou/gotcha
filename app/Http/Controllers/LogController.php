<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * ログ一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $logs = Log::query()->orderBy('created_at', 'desc')->paginate(10);
        return view('log.index',
	        [
	        	'logs' => $logs,
		        "title" => "ログ一覧"
	        ]
        );
    }
}
