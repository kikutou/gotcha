<?php

namespace App\Http\Controllers;

use App\Models\GotchaPrize;
use App\Services\GotchaService;
use App\Models\Picture;
use App\Models\Prize;
use App\Models\Gotcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class GotchaController extends Controller
{
    public function __construct(GotchaService $gotcha_service)
    {
        $this->gotchaService = $gotcha_service;
    }

    /**
     * ガチャ一覧表示
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gotchas = Gotcha::query()->where('deleted_at',NULL)->paginate(10);
        return view('gotcha.index',
	        [
	        	'gotchas' => $gotchas,
		        "title" => "ガチャ-ガチャ"
	        ]
        );
    }

    /**
     * ガチャ新規画面
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
     * ガチャ編集画面
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

            $result = $this->up($request);

            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route("gotcha")->with('message', 'ガチャを更新しました。');
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
     * ガチャの景品登録
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function prizeInsert(Request $request,$id=null)
    {
        $prize_arr = null;
        $prizes = Prize::all();
        // $gotcha = Gotcha::with('picture')->with('result_picture')->get();
        if($request->isMethod('post')){

        	$gotcha_id = $request->get("id");
            // check
            $prize_ids = $request->get('prize_id');
            $frequencies = $request->get('frequency');

            $old_gotcha_prize = GotchaPrize::query()->where("gotcha_id", $gotcha_id)->get();
            foreach ($old_gotcha_prize as $old_record) {
            	$old_record->delete();
            }

            for ($i = 0; $i < count($prize_ids) ; $i++) {
            	$prize_id = $prize_ids[$i];
            	$frequency = $frequencies[$i];
            	if ($prize_id and $frequency) {
		            $gotcha_prize = new GotchaPrize();
		            $gotcha_prize->gotcha_id = $gotcha_id;
		            $gotcha_prize->prize_id = $prize_id;
		            $gotcha_prize->frequency = $frequency;
		            $gotcha_prize->save();
	            }

            }

            return redirect()->back()->with("message", '成功しました');
        }

        $records = [];
        $gotcha_prize = GotchaPrize::with('prize')->where("gotcha_id", $id)->get()->toArray();

        $sum = 0;
	    for($i=0; $i < count($gotcha_prize); $i++) {
            if( array_key_exists ("deleted_at",$gotcha_prize[$i]["prize"]) ){
                $sum += $gotcha_prize[$i]["frequency"];
            }
	    }

        for($i=0; $i < count($gotcha_prize); $i++) {
            if( array_key_exists ("deleted_at",$gotcha_prize[$i]["prize"]) ){
                $one_record = array();
                $one_record["prize_id"] = $gotcha_prize[$i]["prize_id"];
                $one_record["frequency"] = $gotcha_prize[$i]["frequency"];
                $one_record["chance"] = sprintf('%.1f',$gotcha_prize[$i]["frequency"]/$sum * 100) . "%";

                $records[] = $one_record;
            }
        }

        return view('gotcha.prize_insert',[
            'id' => $id,
            'prize_arr' => $prize_arr,
            'prizes' => $prizes,
	        "title" => "ガチャ-ガチャ",
	        "records" => $records
        ]);
    }
    
    /**
     * ガチャ登録処理
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
     * ガチャ更新処理
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function up(Request $request){

        // validation check
        $check = $this->check($request, "edit");
        if($check->fails()) {
            return redirect()->back()->withErrors($check)->withInput()->with("error", "ガチャ更新失敗");
        }
        $gotcha = Gotcha::find($request->get('id'));
        $gotcha->name = $request->get('name');
        $gotcha->cost_name = $request->get('cost_name');
        $gotcha->cost_value = $request->get('cost_value');
        $gotcha->picture_id = $request->get('id_img_disp');
        $gotcha->result_picture_id = $request->get('id_img_result');
        return $gotcha->save();
    }

    /**
     * ガチャ削除処理
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
        return redirect()->route("gotcha")->with('message', 'ガチャを削除しました。');
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
        $prize_error['prize_id_repeat'] = "";
        // $unique_arr = array_unique ( $prize_ids ); 
        // // 获取重复数据的数组 
        // $repeat_arr = array_diff_assoc ( $prize_ids, $unique_arr );
        // if(!empty($repeat_arr) || !isnull($repeat_arr)){
        //     $prize_error['prize_id_repeat'] = 1;
        // };
        if(is_null($prize_ids) || empty($prize_ids)) {
            $prize_error['prize_id_all'] = "景品を選択してください";
        } elseif(!is_array($prize_ids)) {
            $prize = Prize::find($prize_ids);
            if(is_null($prize) || empty($prize)) {
                $prize_error['prize_id'] = "景品が存在しません";
            }
        } else {
            
            if (count($prize_ids) != count(array_unique($prize_ids))) {  
                $prize_error['prize_id_repeat'] = "同じ景品idを選択した"; 
            }
            foreach($prize_ids as $prize_id) {
                $prize = Prize::find($prize_id);
                if(is_null($prize) || empty($prize)) {
                    $prize_error['prize_id'] = "景品が存在しません";
                }
            }
        }

        if(is_null($prize_ids) || empty($prize_ids)) {
            $prize_error['frequency_all'] = 1;
        } elseif(!is_array($frequencies)) {
            if(is_null($frequencies) || empty($frequencies)) {
                $prize_error['frequency'] = "重み数値を入力してください";
            }
        } else {
            foreach($frequencies as $frequency) {
                if(is_null($frequency) || empty($frequency)) {
                    $prize_error['frequency'] = "重み数値を入力してください";
                }
            }
        }
        return $prize_error;
    }
}
