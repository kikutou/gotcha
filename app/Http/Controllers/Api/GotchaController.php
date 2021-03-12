<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserTicket;
use Illuminate\Http\Request;

class GotchaController extends Controller
{

	public function add_user_ticket(Request $request)
	{
		$sid = $request->get("sid");
		$api_token = $request->get("api_token");
		$tickets = $request->get("tickets", 1);

		if (!$sid or !$api_token or !$tickets) {
			return "parameters are not corret";
		}

		$user_ticket = new UserTicket();
		$user_ticket->sid = $sid;
		$user_ticket->api_token = $api_token;
		$user_ticket->tickets = $tickets;
		$user_ticket->type = 1;
		$user_ticket->save();

		return "ok";

	}

}
