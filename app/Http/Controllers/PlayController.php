<?php

namespace App\Http\Controllers;

use App\Models\Gotcha;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlayController extends Controller
{
    public function index(Request $request)
    {

    	$sid = $request->get("sid");
    	if (!$sid) {
    		throw new NotFoundHttpException();
	    }

	    $tickets = 0;

    	$all_records = UserTicket::query()->where("sid", $sid)->get();
    	foreach ($all_records as $record) {
    		if($record->type == 1) {
    			$tickets += $record->tickets;
		    }

		    if ($record->type == 2) {
    			$tickets -= $record->tickets;
		    }
	    }

	    $gotchas = Gotcha::all();


    	return view("play.index", [
    		"gotchas" => $gotchas,
		    "tickets" => $tickets
	    ]);
    }
}
