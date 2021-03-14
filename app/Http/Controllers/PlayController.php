<?php

namespace App\Http\Controllers;

use App\Models\Gotcha;
use App\Models\GotchaPrize;
use App\Models\Prize;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlayController extends Controller
{
    public function index(Request $request)
    {
		$target_prize_id = '';
		$gotcha_id = '';
		$result_gotcha = '';
		$prize = '';
		$result = $request->session()->get('play');
		if(isset($result)){
			$target_prize_id = $result['target_prize_id'];
			$gotcha_id = $result['gotcha_id'];
			$result_gotcha = Gotcha::find($gotcha_id);
			$prize = Prize::find($target_prize_id);
		}
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

	    $gotchas = Gotcha::with('prizes')->get();

    	return view("play.index", [
    		"gotchas" => $gotchas,
		    "tickets" => $tickets,
		    "sid" => $sid,
			"gotcha_id" => $gotcha_id,
			"target_prize_id" => $target_prize_id,
			"result_gotcha" => $result_gotcha,
	    	"prize" => $prize
	    ]);
    }

    public function list(Request $request, $id)
    {

	    $sid = $request->get("sid");
	    if (!$sid) {
		    throw new NotFoundHttpException();
	    }


    	$gotcha = Gotcha::find($id);


    	return view("play.list", [
    		"gotcha" => $gotcha
	    ]);
    }

    public function result(Request $request, $id)
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
    	$gotcha = Gotcha::find($id);

	    if($tickets < $gotcha->cost_value) {
	    	throw new NotFoundHttpException();
	    }

	    $records = [];
	    $gotcha_prize = GotchaPrize::query()->where("gotcha_id", $id)->get()->toArray();


	    $sum = 0;
	    for($i=0; $i < count($gotcha_prize); $i++) {
		    $sum += $gotcha_prize[$i]["frequency"];
	    }

	    $start = 1;
	    for($i=0; $i < count($gotcha_prize); $i++) {
		    $one_record = array();
		    $one_record["prize_id"] = $gotcha_prize[$i]["prize_id"];
		    $one_record["start"] = $start;
		    $one_record["end"] = $start + $gotcha_prize[$i]["frequency"] - 1;

		    $start = $start + $gotcha_prize[$i]["frequency"];

		    $records[] = $one_record;
	    }

	    $result = rand(1, $sum);

	    $target_prize_id = null;

	    foreach ($records as $record) {
	    	if ($result >= $record["start"] and $result <= $record["end"]) {
	    		$target_prize_id = $record["prize_id"];
	    		break;
		    }
	    }

	    $prize = Prize::find($target_prize_id);

	    $user_ticket = new UserTicket();
	    $user_ticket->sid = $sid;
	    $user_ticket->api_token = $sid;
	    $user_ticket->tickets = $gotcha->cost_value;
	    $user_ticket->type = 2;
	    $user_ticket->save();

		
    	$sid = $request->get("sid");
    	if (!$sid) {
    		throw new NotFoundHttpException();
	    }

		return redirect()->back()->with('play',[
		    "sid" => $sid,
			"target_prize_id" => $target_prize_id,
			"gotcha_id" => $id,
		]);
	}
}
