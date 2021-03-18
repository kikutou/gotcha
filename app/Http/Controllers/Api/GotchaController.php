<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gotcha;
use App\Models\GotchaPrize;
use App\Models\Log;
use App\Models\Prize;
use App\Models\Result;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GotchaController extends Controller
{

	public function add_user_ticket(Request $request)
	{
		$uid = $request->get("uid");
		$api_token = $request->get("api_token");
		$tickets = $request->get("tickets", 1);

		if (!$uid or !$api_token or !$tickets) {
			return "parameters are not corret";
		}

		$user_ticket = new UserTicket();
		$user_ticket->uid = $uid;
		$user_ticket->api_token = $api_token;
		$user_ticket->tickets = $tickets;
		$user_ticket->type = 1;
		$user_ticket->save();

		return "ok";

	}

	public function disp_gotchas(Request $request)
	{
		$status = "";
		$reason = "";
		$gotcha_list = [];
		$tickets = 0;
		$result = "";
		$uid = $request->get("uid");
		$api_token = $request->get("api_token");
		//　ログインユーザー確認
		if (!$uid or !$api_token) {
			$status = 'no';
			$reason = "parameters are not corret";
			$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_list' => $gotcha_list,
				'tickets' => $tickets
			];
			return json_encode($result);
		}

		$gotchas = Gotcha::with('prizes')->get();
		//　ガチャ情報確認
		if(count($gotchas) == 0){
			$status = 'no';
			$reason = "ガチャ情報がありません";
			$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_list' => $gotcha_list,
				'tickets' => $tickets
			];
			return json_encode($result);
		}
		
		//　ガチャ情報をセットする
		foreach($gotchas as $gotcha) {

			// ガチャ景品情報確認
			if(count($gotcha->prizes) == 0){
				continue;
			}
			if(!is_null($gotcha->picture->url) && $gotcha->picture->type == 1){
				$img_url = asset('storage/imgs/'.$gotcha->picture->url);
			}else{
				$img_url = "";
			}
			$gotcha_list[] = [
				'name' => $gotcha->name,
				'cost_name' => $gotcha->cost_name,
				'cost_value' => $gotcha->cost_value,
				'img_url' => $img_url
			];
		}

		if(count($gotcha_list) > 0){
			$status = 'ok';
			$reason = 'ガチャ情報取得しました';
		}else{
			$status = 'no';
			$reason = "ガチャの景品情報がありません";
		}



    	$all_records = UserTicket::query()->where("uid", $uid)->get();
    	foreach ($all_records as $record) {
    		if($record->type == 1) {
    			$tickets += $record->tickets;
		    }

		    if ($record->type == 2) {
    			$tickets -= $record->tickets;
		    }
	    }

		$log = new Log();
		$log->log = "ユーザーID：" . $uid . " はガチャ一覧ページにアクセスした。";
		$log->save();

		//　返す値をセットする
		$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_list' => $gotcha_list,
				'tickets' => $tickets
		];
		return json_encode($result);
	}

	public function gotcha_detail(Request $request)
	{
		$status = "";
		$reason = "";
		$gotcha_prize_list = [];

		$img_url = "";
		$result = "";
		$uid = $request->get("uid");
		$api_token = $request->get("api_token");
		$gotcha_id = intval($request->get("gotcha_id"));

		//　ログインユーザー確認
		if (!$uid || !$api_token || !$gotcha_id) {
			$status = 'no';
			$reason = "parameters are not corret";
			$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_prize_list' => $gotcha_prize_list
			];
			return json_encode($result);
		}

		$gotcha = Gotcha::with('prizes')->where('id',$gotcha_id)->first();
		//　ガチャ情報確認
		if(is_null($gotcha)){
			$status = 'no';
			$reason = "ガチャ情報が存在しません";
			$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_prize_list' => $gotcha_prize_list
			];
			return json_encode($result);
		}

		//　ガチャ景品情報確認
		if(count($gotcha->prizes) == 0)
		{
			$status = 'no';
			$reason = "ガチャ景品情報が存在しません";
		}else{
			$status = 'ok';
			$reason = "ガチャ景品情報が取得できました";

			// 景品情報配列にセット
			foreach($gotcha->prizes as $prize){
				if(!is_null($prize->picture->url) && $prize->picture->type == 3){
					$img_url = asset('storage/imgs/'.$prize->picture->url);
				}else{
					$img_url = "";
				}
				$gotcha_prize_list[] = [
					'name' => $prize->name,
					'img_url' => $img_url
				];
			}
		}

		//　戻り値セット
		$result = [
			'status' => $status,
			'reason' => $reason,
			'gotcha_prize_list' => $gotcha_prize_list
		];
		return json_encode($result);
	}
	
	public function gotcha_result(Request $request)
	{
		$status = "";
		$reason = "";
		$gotcha_result_img_url = "";
		$prize_name = "";
		$prize_img_url = "";
		$redirect = "";
		$tickets = 0;
		$result = "";

		$uid = $request->get("uid");
		$api_token = $request->get("api_token");
		$gotcha_id = intval($request->get("gotcha_id"));

		//　ログインユーザー確認
		if (!$uid || !$api_token || !$gotcha_id) {
			$status = 'no';
			$reason = "parameters are not corret";
			$result = [
				'status' => $status,
				'reason' => $reason
			];
			return json_encode($result);
		}

		//　該当ユーザーのチケット取得
		$all_records = UserTicket::query()->where("uid", $uid)->get();
	    foreach ($all_records as $record) {
		    if($record->type == 1) {
			    $tickets += $record->tickets;
		    }

		    if ($record->type == 2) {
			    $tickets -= $record->tickets;
		    }
	    }

		$gotcha = Gotcha::with('picture')->where('id',$gotcha_id)->first();

		//　ガチャ情報確認
		if(is_null($gotcha)){
			$status = 'no';
			$reason = "ガチャ情報がありません";
			$result = [
				'status' => $status,
				'reason' => $reason
			];
			return json_encode($result);
		}

		// ユーザー利用可能チケット数とガチャ必要チケット数確認
	    if($tickets < $gotcha->cost_value) {
			$status = 'no';
			$reason = "チケット数が足りない";
			$result = [
				'status' => $status,
				'reason' => $reason
			];
			return json_encode($result);
	    }

		// 景品情報取得
	    $records = [];
	    $gotcha_prize = GotchaPrize::query()->where("gotcha_id", $gotcha_id)->get()->toArray();

		// 景品情報チェック
		if( count($gotcha_prize) == 0){
			$reason = "景品情報がありません";
			$result = [
				'status' => $status,
				'reason' => $reason
			];
			return json_encode($result);
		}

		// 景品重みとあたり率計算
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

		DB::beginTransaction();
		try{

			$user_ticket = new UserTicket();
			$user_ticket->uid = $uid;
			$user_ticket->api_token = $uid;
			$user_ticket->tickets = $gotcha->cost_value;
			$user_ticket->type = 2;
			$user_ticket->gotcha_result_id = $gotcha_id;
			$user_ticket->save();
	
			$result = new Result();
			$result->gotcha_id = $gotcha_id;
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
				. "はガチャID：" . $gotcha_id
				. "をプレーした。賞品ID：" . $target_prize_id
				. "　消費したチケット数：" . $gotcha->cost_value
				. "　チケット残高：" . ($tickets - $gotcha->cost_value);
	
			$log->save();
			DB::commit();
			$status = 'ok';
			$reason = 'おめでとうございます！';

			$prize = Prize::with('picture')->where('id',$target_prize_id)->first();
			
			if(!is_null($gotcha->picture->url) && $gotcha->picture->type == 2){
				$gotcha_result_img_url = asset('storage/imgs/'.$gotcha->picture->url);
			}else{
				$gotcha_result_img_url = "";
			}

			if(!is_null($prize->picture->url) && $prize->picture->type == 3){
				$prize_img_url = asset('storage/imgs/'.$prize->picture->url);
			}else{
				$prize_img_url = "";
			}
			
			$result = [
				'status' => $status,
				'reason' => $reason,
				'gotcha_result_img_url' => $gotcha_result_img_url,
				'prize_name' => $prize->name,
				'prize_img_url' => $prize_img_url,
				'redirect' => $prize->url
			];
			
		}catch(\Exception $e){
			DB::rollBack();
			$status = 'no';
			$reason = $e->getMessage();
			$result = [
				'status' => $status,
				'reason' => $reason
			];
		}
		return json_encode($result);
	}
}
