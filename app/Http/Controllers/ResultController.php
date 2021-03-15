<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $results = Result::with('prize')->with('gotcha')->paginate(8);
        return view('result.index',
	        [
	        	'results' => $results,
		        "title" => "ガチャ結果一覧"
	        ]
        );
    }
}
