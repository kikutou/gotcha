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
        return view('gotcha.index',
	        [
	        	'gotchas' => $gotchas,
		        "title" => "ガチャ-ガチャ"
	        ]
        );
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
            return redirect()->route("gotcha")->with('message', 'ガチャを登録しました。');
        }

        $gotcha_disp_imgs = Picture::all()->where('type',1);
        $gotcha_result_imgs = Picture::all()->where('type',2);
        return view('gotcha.create',[
            'gotcha_disp_imgs' => $gotcha_disp_imgs,
            'gotcha_result_imgs' => $gotcha_result_imgs,
	        "title" => "ガチャ-ガチャ"
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id=null)
    {
        $prizes = Prize::all();
        // $gotcha = Gotcha::with('picture')->with('result_picture')->get();
        if($request->isMethod('post')){
            // validation check
            $check = $this->check($request, "edit");
		    if($check->fails()) {
			    return redirect()->back()->withErrors($check)->withInput()->with("error", "ガチャ更新失敗");
		    }

            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route('picture');
        }

        $gotcha = Gotcha::find($id);
        $gotcha_disp_imgs = Picture::all()->where('type',1);
        $gotcha_result_imgs = Picture::all()->where('type',2);
        return view('gotcha.edit',[
            'gotcha' => $gotcha,
            'gotcha_disp_imgs' => $gotcha_disp_imgs,
            'gotcha_result_imgs' => $gotcha_result_imgs,
            'prizes' => $prizes,
	        "title" => "ガチャ-ガチャ"
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function prizeInsert(Request $request,$id=null)
    {
        $prizes = Prize::all();
        // $gotcha = Gotcha::with('picture')->with('result_picture')->get();
        if($request->isMethod('post')){
            // check
            $prize_ids = $request->get('prize_id');
            $frequencies = $request->get('frequency');
            $occurrence_rates = $request->get('occurrence_rate');
            $check_result = $this->check_prizes($prize_ids, $frequencies);
            if($check_result){
            }
            $result = $this->up($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route('picture');
        }

        $gotcha = Gotcha::find($id);
        $gotcha_disp_imgs = Picture::all()->where('type',1);
        $gotcha_result_imgs = Picture::all()->where('type',2);
        return view('gotcha.prize_insert',[
            'gotcha' => $gotcha,
            'gotcha_disp_imgs' => $gotcha_disp_imgs,
            'gotcha_result_imgs' => $gotcha_result_imgs,
            'prizes' => $prizes,
	        "title" => "ガチャ-ガチャ"
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

    /**
     * Display a listing of the resource.
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
    	if(is_null($id) || empty($id)){
            return false;
        }

        $gotcha = Gotcha::find( $id );
        if(is_null($gotcha) || empty($gotcha)){
            return false;
        }
        $result = $gotcha->delete();
        if($result){
            session()->flash('flash_message', '成功しました');
        }else{
            session()->flash('flash_message', '失敗しました');
        }
        return redirect()->route('gotcha');
    }

    public function check(Request $request) {
        $rules = [
            'name' => 'required',
            'cost_name' => 'required',
            'cost_value' => 'required|numeric|between:1,999999',
            'id_img_disp' => 'required|min:1',
            'id_img_result' => 'required|min:1',
        ];

        $errors = [
            'name.required' => 'ガチャ名称を入力してください', 
            'cost_name.required' => 'コスト名を入力してください',
            'cost_value.required' => 'コスト量を入力してください',
            'cost_value.numeric' => '数値を入力してください', 
            'cost_value.between' => '0より大きい数値を入力してください', 
            'id_img_disp.required' => '画像を選択してください',
            'id_img_result.required' => '画像を選択してください',
        ];

        return $validator = Validator::make($request->all(), $rules, $errors);
    }

    public function check_prizes($prize_ids, $frequencies) {
        $prize_error = [];
        $prize_error['prize_id'] = "";
        $prize_error['prize_id_all'] = "";
        $prize_error['frequency'] = "";
        $prize_error['frequency_all'] = "";

        if(is_null($prize_ids) || empty($prize_ids)) {
            $prize_error['prize_id_all'] = 1;
        } elseif(!is_array($prize_ids)) {
            $prize = Prize::find($prize_ids);
            if(is_null($prize) || empty($prize)) {
                $prize_error['prize_id'] = $prize_ids;
            }
        } else {
            
            if (count($prize_ids) != count(array_unique($prize_ids))) {  
                var_dump('该数组有重复值'); 
            }
            dd('pass');
            foreach($prize_ids as $prize_id) {
                $prize = Prize::find($prize_id);
                if(is_null($prize) || empty($prize)) {
                    $prize_error['prize_id'] = $prize_id;
                }
            }
        }

        if(is_null($prize_ids) || empty($prize_ids)) {
            $prize_error['frequency_all'] = 1;
        } elseif(!is_array($frequencies)) {
            if(is_null($frequencies) || empty($frequencies)) {
                $prize_error['frequency'] = $frequencies;
            }
        } else {
            foreach($frequencies as $frequency) {
                if(is_null($frequency) || empty($frequency)) {
                    $prize_error['frequency'] = $frequency;
                }
            }
        }
        return $prize_error;
    }
}
