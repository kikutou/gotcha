<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PictureService;

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
        $pictures = $this->pictureService->getAll();
        $message = null;
        return view('picture.index', compact('pictures', 'message'));
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $message = null;
        if($request->isMethod('get')){
            return view('picture.create',compact('message'));
        }elseif($request->isMethod('post')){
            $result = $this->insert($request);
            if($result){
                $message = '成功しました。';
            }else{
                $message = '失敗しました。';
            }
            $pictures = $this->pictureService->getNoDel();
            return view('picture.index')->with(['pictures' => $pictures, 'message' => $message]);
        }
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
