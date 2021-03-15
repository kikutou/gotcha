<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PrizeService;
use App\Models\Picture;
use App\Models\Prize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

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
        // $prizes = Prize::all()->pictures;
        $prizes = Prize::with('picture')->get();
        return view('prize.index',
	        [
	        	'prizes' => $prizes,
		        "title" => "ガチャ-景品"
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
			    return redirect()->back()->withErrors($check)->withInput()->with("error", "画像登録失敗");
		    }

            $result = $this->insert($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route("prize")->with('message', '景品を登録しました。');
        }
        $pictures = Picture::where('type',3)->get();
	    return view('prize.create',
		    [
		    	'pictures' => $pictures,
			    "title" => "ガチャ-景品"
		    ]
	    );
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
        if($request->isMethod('post')){
            // validation check
            $check = $this->check($request);
            if($check->fails()) {
                return redirect()->back()->withErrors($check)->withInput()->with("error", "景品を更新失敗しました");
            }
            $result = $this->up($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route("prize")->with('message', '景品を更新しました。');
        }
        $prize = Prize::find($id)->with('picture')->where('id',$id)->first();
        $pictures = Picture::where('type',3)->get();
        return view('prize.edit',
	        [
	        	'prize' => $prize,
		        'pictures' => $pictures,
		        "title" => "ガチャ-景品"
	        ]
        );
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function up(Request $request){
        $prize_id = $request->get('prize_id');
        $name = $request->get('name');
        $type = $request->get('type_id');
        $picture_id = $request->get('picture_id');
        $url = $request->get('url');
        
        $prize = Prize::find($prize_id);
        $prize->name = $name;
        $prize->type = $type;
        $prize->picture_id = $picture_id;
        $prize->url = $url;
        $prize->original_id = $prize_id;
        if (is_null($prize) || empty($prize)){
            return redirect()->back()->with("error", "更新失敗しました");
        }
        return $prize->save();
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function insert(Request $request){

        $prize_id = $request->get('prize_id');
        $name = $request->get('name');
        $type = $request->get('type_id');
        $picture_id = $request->get('picture_id');
        $url = $request->get('url');

        $prize = new Prize();
        $prize->name = $name;
        $prize->type = $type;
        $prize->picture_id = $picture_id;
        $prize->url = $url;
        $result = $prize->save();
        if($result){
            $prize->original_id = $prize->id;
            $prize->save();
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
        $prize = Prize::find( $id );
        if(is_null($prize) || empty($prize)){
            return false;
        }
        $result = $prize->delete($id);
        if($result){
            session()->flash('flash_message', '成功しました');
        }else{
            session()->flash('flash_message', '失敗しました');
        }
        return redirect()->route('prize');
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPrize(Request $request){
        $name = null;
        if($request->has('id')){
            $id = intval($request->get('id'));
            $prize = Prize::find($id);
            if ( !is_null($prize) && !empty($prize) ) {
                $name = $prize->name;
            }
        };
        return response()->json([
            'name' => $name
        ]);
    }

    public function check(Request $request){
        $rules = [
            'name' => 'required',
            'type_id' => 'required',
            'picture_id' => 'required|min:1',
            'url' => 'required|url'
        ];
    
        $errors = [
            'name.required' => '景品名称を入力してください', 
            'type_id.required' => '景品種別を選択してください',
            'picture_id.required' => '画像を選択してください',
            'url.required' => 'URLを入力してください',
            'url.url' => '正確のURLを入力してください',
        ];
        return $validator = Validator::make($request->all(), $rules, $errors);
    }

}
