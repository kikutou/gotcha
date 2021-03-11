<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GotchaService;
use App\Models\Picture;
use App\Models\Prize;
use App\Models\Gotcha;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

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
        $gotchas = Gotcha::all();
        return view('gotcha.index', ['gotchas' => $gotchas]);
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post')) {
            // validation check
            $check = $this->check($request);
		    if($check->fails()) {
			    return redirect()->back()->withErrors($check)->withInput()->with("error", "ガチャ登録失敗");
		    }

            $result = $this->insert($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route("prize")->with('message', 'ガチャを登録しました。');
        }

        $gotcha_disp_imgs = Picture::all()->where('type',1);
        $gotcha_result_imgs = Picture::all()->where('type',2);
        return view('gotcha.create',[
            'gotcha_disp_imgs' => $gotcha_disp_imgs,
            'gotcha_result_imgs' => $gotcha_result_imgs
        ]);
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
        return view('gotcha.detail', [
            'gotchas' => $gotchas,
            'gotcha_disp_imgs' => $gotcha_disp_imgs,
            'gotcha_result_imgs' => $gotcha_result_imgs
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function insert(Request $request){
        $gotcha = new Gotcha();
        $gotcha->name = $request->get('name');
        $gotcha->cost_name = $request->get('cost_name');
        $gotcha->cost_value = $request->get('cost_value');
        $gotcha->picture_id = $request->get('id_img_disp');
        $gotcha->result_picture_id = $request->get('id_img_result');
        $result = $gotcha->save();
        if($gotcha){
            return true;
        }else{
            return false;
        }
    }

    public function check(Request $request){
        $rules = [
            'name' => 'required',
            'cost_name' => 'required',
            'cost_value' => 'required|numeric',
            'id_img_disp' => 'required|min:1',
            'id_img_result' => 'required|min:1',
        ];

        $errors = [
            'name.required' => 'ガチャ名称を入力してください', 
            'cost_name.required' => 'コスト名を入力してください',
            'cost_value.required' => 'コスト量を入力してください',
            'cost_value.numeric' => '数値を入力してください', 
            'id_img_disp.required' => '画像を選択してください',
            'id_img_result.required' => '画像を選択してください',
        ];

        return $validator = Validator::make($request->all(), $rules, $errors);
    }

}
