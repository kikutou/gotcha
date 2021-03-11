<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GotchaService;

class GotchaController extends Controller
{
    public function __construct(GotchaService $gotcha_service)
    {
        $this->gotchaService = $gotcha_service;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gotchas = $this->gotchaService->getGotcha();
        $message = null;
        return view('gotcha.index', compact('gotchas', 'message'));
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $message = null;
        return view('gotcha.create',compact('message'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=null)
    {
        if(!$request->has('gotcha_id')){
            return false;
        }
        $gotcha_id = $request->get('gotcha_id');

        $gotchas = $this->gotchaService->getGotchaById($gotcha_id);
        return view('gotcha.detail', compact('gotchas'));
    }

}
