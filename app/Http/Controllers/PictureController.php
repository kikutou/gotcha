<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PictureService;
use App\Models\Picture;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class PictureController extends Controller
{
    public function __construct(PictureService $picture_service)
    {
        $this->pictureService = $picture_service;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pictures = Picture::all();

        return view('picture.index', [
        	"pictures" => $pictures
        ]);
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	if($request->isMethod('post')){

		    $rules = [
			    'type_id' => 'required',
			    'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000', // max 10000kb
		    ];

		    $errors = [
			    'type_id.required' => '種類を選択してください',
			    'image.required' => '画像を選択してください',
			    'image.mimes' => '画像以外のファイルを選択しました。',
			    'image.max' => '画像サイズが大きい過ぎ',
		    ];

		    $validator = Validator::make($request->all(), $rules, $errors);
		    if($validator->fails()) {
			    return redirect()->back()->withErrors($validator)->withInput();
		    }

            $result = $this->insert($request);
            if($result){
                $message = '成功しました。';
            }else{
                $message = '失敗しました。';
            }
            return Redirect::route('picture');
        }

	    return view('picture.create');
    }

        /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id=null)
    {
        if($request->isMethod('get')){
            $picture = Picture::find($id);
            return view('picture.edit', ['picture' => $picture]);
        }elseif($request->isMethod('post')){
            $result = $this->up($request);
            if($result){
                $message = '成功しました。';
            }else{
                $message = '失敗しました。';
            }
            return Redirect::route('picture');
        }
        
        if($request->has('edit')){
            if(!$request->has('picture_id')){
                return false;
            }
            $picture_id = $request->get('picture_id');
            if(is_null($picture_id) || empty($picture_id)){
                return false;
            }
            $picture = $this->pictureService->getPictureById($picture_id);
            if(is_null($picture) || empty($picture)) {
                return false;
            }

            return view('picture.edit', compact('picture'));
        } elseif($request->has('delete')) {
            $this->delete($request);
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
        $picture = Picture::find( $id );;
        if(is_null($picture) || empty($picture)){
            return false;
        }
        $result = $picture->delete();
        if($result){
            $message = "削除しました。";
            return Redirect::route('picture');
        }else{
            $message = "削除失敗しました。";
            return Redirect::back()->with('message', $message);
        }
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function insert(Request $request){

        $path = $request->file('image')->store('public/imgs');
        $description = $request->get('description');
        $type_id = $request->get('type_id');
        $image = basename($path);
        $create_data = [
            'description' => $description,
            'type_id' => $type_id,
            'url' => $image,
        ];

        $picture = $this->pictureService->create($create_data);

        if($picture){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Display a listing of the resource.
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
        $picture->save();
    }
}
