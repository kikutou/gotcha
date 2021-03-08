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
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
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
    public function create_index(Request $request)
    {
        $message = null;
        return view('gotcha.create',compact('message'));
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_action(Request $request)
    {
        //
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
        if(!$request->has('gotcha_id')){
            return false;
        }
        $gotcha_id = $request->get('gotcha_id');

        $gotchas = $this->gotchaService->getGotchaById($gotcha_id);
        return view('gotcha.detail', compact('gotchas'));
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
        $gotchas = $this->gotchaService->getGotcha();
        return view('gotcha.detail', compact('gotchas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
