<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PictureService;
use App\Models\Picture;
use Illuminate\Support\Facades\Validator;

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
			    'name' => 'required|max_width:20|unique:bases,name',
			    "code" => "required|max:10|unique:bases,code",
			    'address' => 'required|max_width:100',
			    'telephone'=> 'required:max:15',
			    "privilege" => "required",
		    ];

		    $errors = [
			    "name.unique" => "すでに登録済みの名称です。変更してください。",
			    "code.unique" => "すでに登録済みのコードです。変更してください。",
			    'name.required' => '名前を入力してください',
			    'code.required' => 'コードを入力してください',
			    'address.required' => '住所を入力してください',
			    'telephone.required' => '電話番号を入力してください',
			    'privilege.required' => '権限を入力してください',
			    "name.max_width" => "名称は全角10文字以内で入力してください",
			    "address.max_width" => "住所は全角50文字以内で入力してください",
			    "code:max" => "コードは10文字以内で入力してください",
			    "telephone:max" => "電話番号は:max文字以内で入力してください",

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
            $pictures = $this->pictureService->getNoDel();
            return view('picture.index')->with(['pictures' => $pictures, 'message' => $message]);
        }

	    return view('picture.create',compact('message'));
    }

        /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $message = null;
        if($request->isMethod('get')){
            $picture = $this->pictureService->getPictureById($id);
            return view('picture.edit',compact('picture', 'message'));
        }elseif($request->isMethod('post')){
            $result = $this->up($request);
            if($result){
                $message = '成功しました。';
            }else{
                $message = '失敗しました。';
            }
            $pictures = $this->pictureService->getNoDel();
            return view('picture.index')->with(['pictures' => $pictures, 'message' => $message]);
        }
        
        
        
        
        dd($request);
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
            $message = null;
            return view('picture.edit', compact('picture', 'message'));
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
        $picture = $this->pictureService->getPictureById($id);
        if(is_null($picture) || empty($picture)){
            return false;
        }
        $picture = $this->pictureService->delete($id);
        if($picture){
            $pictures = $this->pictureService->getAll();
            $message = "削除しました。";
            return redirect('/picture')->with([
                'pictures' => $pictures,
                'message' => $message
                ]);
        }else{
            $pictures = $this->pictureService->getAll();
            $message = "削除失敗しました。";
            return view('picture.index', compact('pictures', 'message'));
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
            'name' => $image,
        ];

        $picture = $this->pictureService->create($create_data);
        $picture =true;
        if($picture){
            return true;
        }else{
            return false;
        }

    }
}
