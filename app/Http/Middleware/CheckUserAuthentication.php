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
		$uid = $request->get("uid");
		$api_token = $request->get("api_token");

		if (!$uid or !$api_token) {
			throw new NotFoundHttpException();
		}

		$client = new \GuzzleHttp\Client();
		// //　2021/03/22 add
		// $client = new \GuzzleHttp\Client(
        //     [\GuzzleHttp\RequestOptions::VERIFY => false]
        // );

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
