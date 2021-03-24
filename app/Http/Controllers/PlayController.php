<?php

namespace App\Http\Controllers;

use App\Models\Gotcha;
use App\Models\GotchaPrize;
use App\Models\Log;
use App\Models\Prize;
use App\Models\Result;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlayController extends Controller
{
    public function index(Request $request)
    {
		$gotcha_list = [];
		$gotchas = [];
		$reason = "";
		$uid = $request->get("uid");
		$api_token = $request->get("api_token");

		$gotcha_id = "";
		$target_prize_id = "";
		$result_gotcha = "";
		$prize = "";
		$tickets = 0;

		//　get gotcha_list
		$client = new \GuzzleHttp\Client();
		$url = "http://18.181.193.90/api/disp_gotchas";
		$response = $client->request(
			'POST',
			$url,
			[
				'form_params' => [
					'uid' => $uid,
					'api_token' => $api_token
				]
			]
		);

		if ($response->getStatusCode() == 200) {
			$result = (array)json_decode($response->getBody(), true);

			if ($result["status"] == "ok") {
				$gotcha_list = $result["gotcha_list"];
				$reason = $result["reason"];
				$tickets = $result["tickets"];
			}
		}

		for ($i = 0; $i < count($gotcha_list); $i++) {
			
			//　get gotcha_prize_list
			$client = new \GuzzleHttp\Client();
			$url = "http://18.181.193.90/api/gotcha_detail";
			$response = $client->request(
				'POST',
				$url,
				[
					'form_params' => [
						'uid' => $uid,
						'api_token' => $api_token,
						'gotcha_id' => $gotcha_list[$i]["id"]
					]
				]
			);
			
			if ($response->getStatusCode() == 200) {
				$result = (array)json_decode($response->getBody(), true);
				if ($result["status"] == "ok") {
					$gotcha_list[$i]["prizes"] = [];
					$gotcha_list[$i]["prizes"] = $result["gotcha_prize_list"];
				}
			}
		}
    	return view("play.index", [
    		"gotchas" => $gotcha_list,
		    "tickets" => $tickets,
		    "uid" => $uid,
			"api_token" => $api_token,
			"gotcha_id" => $gotcha_id,
			"target_prize_id" => $target_prize_id,
			"result_gotcha" => $result_gotcha,
	    	"prize" => $prize
	    ]);
		// $target_prize_id = '';
		// $gotcha_id = '';
		// $result_gotcha = '';
		// $prize = '';
		// $result = $request->session()->get('play');
		// if(isset($result)){
		// 	$target_prize_id = $result['target_prize_id'];
		// 	$gotcha_id = $result['gotcha_id'];
		// 	// $result_gotcha = Gotcha::find($gotcha_id);
		// 	$result_gotcha = Gotcha::with('result_picture')->find($gotcha_id);
		// 	$prize = Prize::find($target_prize_id);
		// }

    	// if (!$uid) {
    	// 	throw new NotFoundHttpException();
	    // }

	    // $tickets = 0;

    	// $all_records = UserTicket::query()->where("uid", $uid)->get();
    	// foreach ($all_records as $record) {
    	// 	if($record->type == 1) {
    	// 		$tickets += $record->tickets;
		//     }

		//     if ($record->type == 2) {
    	// 		$tickets -= $record->tickets;
		//     }
	    // }

	    // $gotchas = Gotcha::with('prizes')->get();

    	// $log = new Log();
    	// $log->log = "ユーザーID：" . $uid . " はガチャ一覧ページにアクセスした。";
    	// $log->save();

    	// return view("play.index", [
    	// 	"gotchas" => $gotchas,
		//     "tickets" => $tickets,
		//     "uid" => $uid,
		// 	"api_token" => $api_token,
		// 	"gotcha_id" => $gotcha_id,
		// 	"target_prize_id" => $target_prize_id,
		// 	"result_gotcha" => $result_gotcha,
	    // 	"prize" => $prize
	    // ]);
    }

    public function list(Request $request, $id)
    {

	    $uid = $request->get("uid");
	    if (!$uid) {
		    throw new NotFoundHttpException();
	    }


    	$gotcha = Gotcha::find($id);


    	return view("play.list", [
    		"gotcha" => $gotcha
	    ]);
    }

    public function result(Request $request, $id)
    {

	    $uid = $request->get("uid");
	    if (!$uid) {
		    throw new NotFoundHttpException();
	    }

	    $tickets = 0;

	    $all_records = UserTicket::query()->where("uid", $uid)->get();
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
		try {
			$prize = Prize::find($target_prize_id);

			$user_ticket = new UserTicket();
			$user_ticket->uid = $uid;
			$user_ticket->api_token = $uid;
			$user_ticket->tickets = $gotcha->cost_value;
			$user_ticket->type = 2;
			$user_ticket->gotcha_result_id = $id;
			$user_ticket->save();

			$result = new Result();
			$result->gotcha_id = $id;
			$result->uid = $uid;
			$result->prize_id = $target_prize_id;
			$result->status = 1;
			$result->save();

			$gotcha->use_numbers = $gotcha->use_numbers + 1;
			$gotcha->save();

			$user_ticket->gotcha_result_id = $result->id;
			$user_ticket->save();


			$log = new Log();
			$log->log = "ユーザーID：" . $uid
				. "はガチャID：" . $id
				. "をプレーした。賞品ID：" . $target_prize_id
				. "　消費したチケット数：" . $gotcha->cost_value
				. "　チケット残高：" . ($tickets - $gotcha->cost_value);

			$log->save();
			
		} catch (Throwable $e) {
			return redirect()->back()->with('error',$e);
		}

		return redirect()->back()->with('play',[
		    "uid" => $uid,
			"target_prize_id" => $target_prize_id,
			"gotcha_id" => $id,
		]);
	}
}
