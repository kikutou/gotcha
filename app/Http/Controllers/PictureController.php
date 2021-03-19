<?php

namespace App\Http\Controllers;

use App\Services\PictureService;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class PictureController extends Controller
{
    public function __construct(PictureService $picture_service)
    {
        $this->pictureService = $picture_service;
    }

    /**
     * 画像一覧表示
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pictures = Picture::query()->where('deleted_at', NULL)->paginate(10);

        return view('picture.index', [
        	"pictures" => $pictures,
	        "title" => "ガチャ-画像"
        ]);
    }

    /**
     * 画像新規画面
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    	if($request->isMethod('post')) {
            // validation check
            $check = $this->check($request, "create");
		    if($check->fails()) {
			    return redirect()->back()->withErrors($check)->withInput()->with("error", "画像登録失敗");
		    }

            $result = $this->insert($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route("picture")->with('message', '画像を登録しました。');
        }

	    return view('picture.create',
		    [
			    "title" => "ガチャ-画像"
		    ]);
    }

    /**
     * 画像編集画面
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id=null)
    {
        if($request->isMethod('post')){
            // validation check
            $check = $this->check($request, "edit");
		    if($check->fails()) {
			    return redirect()->back()->withErrors($check)->withInput()->with("error", "画像登録失敗");
		    }
            $result = $this->up($request);
            if($result){
                session()->flash('flash_message', '成功しました');
            }else{
                session()->flash('flash_message', '失敗しました');
            }
            return redirect()->route('picture');
        }

        $picture = Picture::find($id);
        return view('picture.edit',
	        [
	        	'picture' => $picture,
		        "title" => "ガチャ-画像"
	        ]
        );
    }

    /**
     * 画像削除処理
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
    	if(is_null($id) || empty($id)){
            return false;
        }

        $picture = Picture::find( $id );
        if(is_null($picture) || empty($picture)){
            return false;
        }
        $result = $picture->delete();
        if($result){
            session()->flash('flash_message', '成功しました');
        }else{
            session()->flash('flash_message', '失敗しました');
        }
        return redirect()->route("picture")->with('message', '画像を削除しました。');
    }

    /**
     * 画像登録処理
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function insert(Request $request){
        $path = $request->file('image')->store('public/imgs');
        $picture = new Picture();
        $picture->url = basename($path);
        $picture->description = $request->get('description');
        $picture->type = $request->get('type_id');
        $result = $picture->save();

        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 画像更新処理
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function up(Request $request){
        $picture = Picture::find($request->get('picture_id'));
        if($request->file('image')){
            $path = $request->file('image')->store('public/imgs');
            $image = basename($path);
            $picture->url = $image;
        }
        $picture->description = $request->get('description');
        $picture->type = $request->get('type_id');
        return $picture->save();
    }

    /**
     * 画像情報取得
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPicture(Request $request){
        $url = null;
        if($request->has('id')){
            $id = intval($request->get('id'));
            $picture = Picture::find($id);
            if ( !is_null($picture) && !empty($picture) ) {
                $url = asset('storage/imgs/'.$picture->url);
            }
        };
        return response()->json([
            'url' => $url
            ]);
    }

    public function check(Request $request, $type){
        if($type == 'create') {
            $rules = [
                'description' => 'required',
                'type_id' => 'required',
                'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
            ];

            $errors = [
                'description.required' => '⽤途を入力してください', 
                'type_id.required' => '種類を選択してください',
                'image.required' => '画像を選択してください',
                'image.mimes' => '画像以外のファイルを選択しました。',
                'image.max' => '画像サイズが大きい過ぎ',
            ];
        } else {
            $rules = [
                'description' => 'required',
                'type_id' => 'required',
            ];

            $errors = [
                'description.required' => '⽤途を入力してください', 
                'type_id.required' => '種類を選択してください',
            ];
        }
        return $validator = Validator::make($request->all(), $rules, $errors);
    }
}
