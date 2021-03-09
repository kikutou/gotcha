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
        $pictures = $this->pictureService->getNoDel();
        $message = null;
        return view('picture.index', compact('pictures', 'message'));
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_index(Request $request)
    {
        $message = null;
        return view('picture.create', compact('message'));
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_action(Request $request)
    {
        if($request->has('delete')){

        }elseif($request->has('insert')){
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
     * @return \Illuminate\Http\Response
     */
    public function edit_index(Request $request)
    {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit_action(Request $request)
    {
        dd($request);
        if($request->has('delete')){

        }elseif($request->has('insert')){
            $result = $this->update($request);
        }
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function delete(Request $request){
        if(!$request->has('picture_id')){
            return false;
        }
        $picture_id = $request->get('picture_id');
        $picture = $this->pictureService->getPictureById($picture_id);
        if(is_null($picture) || empty($picture)){
            return false;
        }
        $picture->del_flg = 1;
        $picture = $this->pictureService->getPictureById($picture_id);
        dd($picture);
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
