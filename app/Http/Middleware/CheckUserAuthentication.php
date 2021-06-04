<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckUserAuthentication
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{

		// add by kiku
		// 20210603
		// https://adtech-ag.backlog.com/view/OCG-247
//		return response('サービスアクセス不可', 200)->header('Content-Type', 'text/plain');

		$uid = $request->get("uid");
		$api_token = $request->get("api_token");

		if (!$uid or !$api_token) {
			throw new NotFoundHttpException();
		}

		$client = new \GuzzleHttp\Client();

		$url = env("UFO_URL", "https://152.165.120.112") . "/api/user_stat.php";


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
			$result = json_decode($response->getBody());
			if ($result->status == "ok") {
				return $next($request);
			}
		}


		return response()->json([
			"status" => "ng",
			"error_msg"=> "token not match"
		]);


	}
}
