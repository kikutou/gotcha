<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrizeService;

class PrizeController extends Controller
{
    public function __construct(PrizeService $prize_service)
    {
        $this->prizeService = $prize_service;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $prizes = $this->prizeService->getPrize();
        $message = null;
        return view('prize.index', compact('prizes', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_index(Request $request)
    {
        $message = null;
        return view('prize.create',compact('message'));
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_action(Request $request)
    {
        dd(1);
        $message = null;
        return view('prize.create',compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_index(Request $request)
    {
        if(!$request->has('prize_id')){
            return false;
        }
        $prize_id = $request->get('prize_id');

        $prize = $this->gotchaService->getPrizeById($prize_id);
        return view('prize.detail', compact('prize'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_action(Request $request)
    {
        dd($request);
        $prize = $this->prizeService->getPrize();
        return view('gotcha.detail', compact('prize'));
    }
}
