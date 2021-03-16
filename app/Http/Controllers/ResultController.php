<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class ResultController extends Controller
{
    /**
     * ユーザーチケット一覧表示
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketIndex(Request $request)
    {   
        return view('result.ticket_list',
	        [
	        	'get_tickets' => "",
                'used_tickets' => "",
                'rest_tickets' => "",
                'results' => [],
		        "title" => "チケット一覧"
	        ]
        );
    }

    /**
     *  ユーザーチケット検索
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketSearch(Request $request)
    {
        $check = $this->check($request);
        if($check->fails()) {
            return redirect()->back()->withErrors($check)->withInput()->with("error", "検索失敗");
        }
        $results = Userticket::query()->where('sid',$request->get('user_id'))->where('deleted_at',NULL)->get();
        $get_tickets = Userticket::query()
            ->where('sid',$request->get('user_id'))
            ->where('type',1)
            ->where('deleted_at',NULL)
            ->sum("tickets");
        $used_tickets = Userticket::query()
            ->where('sid',$request->get('user_id'))
            ->where('type',2)
            ->where('deleted_at',NULL)
            ->sum("tickets");
        $rest_tickets = $get_tickets-$used_tickets;
        return view('result.ticket_list',
	        [
                'get_tickets' => $get_tickets,
                'used_tickets' => $used_tickets,
                'rest_tickets' => $rest_tickets,
	        	'results' => $results,
		        "title" => "チケット一覧"
	        ]
        );
    }

    public function check(Request $request){
        $rules = [
            'user_id' => 'required|numeric'
        ];
    
        $errors = [
            'user_id.required' => 'ユーザーIDを入力してください', 
            'user_id.numeric' => '数値を入力してください'
        ];
        return $validator = Validator::make($request->all(), $rules, $errors);
    }
}
