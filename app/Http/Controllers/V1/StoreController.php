<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\ExpressPost;
use App\Http\Requests\StorePost;
use App\Modules\User;
use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class StoreController extends Controller
{
    //
    private $handle;
    public function __construct()
    {
        $this->handle = new User();
    }
    public function addStoreCategory()
    {
        $title = Input::get('title');
        $id = Input::get('id',0);
        if ($this->handle->addStoreCategory($id,$title)){
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }
        return jsonResponse([
            'msg'=>'添加失败！'
        ],400);
    }
    public function getStoreCategories()
    {
        $page = Input::get('page',1);
        $limit = Input::get('limit',10);
        $categories = $this->handle->getStoreCategories($page,$limit);
        return jsonResponse([
            'msg'=>'ok',
            'data'=>$categories
        ]);
    }
    public function deletesStoreCategory()
    {
        $id = Input::get('id');
        if ($this->handle->delStoreCategory($id)){
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }
        return jsonResponse([
            'msg'=>'删除失败！'
        ],400);
    }
    public function test(Request $request)
    {
        $path = $request->file('image')->store('images','public');
//        $path = Storage::putFile('avatars', $request->file('avatar'));
        return $path;
    }
    public function getSettleApplies()
    {
        $page = Input::get('page',1);
        $limit = Input::get('limit',10);
        $data = $this->handle->getSettleApplies($page,$limit);
        return $data;
    }
    public function checkSettleApply()
    {
        $id = Input::get('id');
        $state = Input::get('state',2);
        $result = $this->handle->checkSettleApply($id,$state);
        if (!$result){
            return jsonResponse([
                'msg'=>'操作失败！'
            ],400);
        }else{
            if ($state==1){
                $apply = $this->handle->getSettleApplyById($result);
                $user = new \App\User();
                $user->username = $apply->phone;
                $user->phone = $apply->phone;
                $user->password = bcrypt('123456');
                $user->save();
            }
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }

    }
    public function addStore(StorePost $post)
    {
        $id = $post->id?$post->id:0;
        if ($this->handle->getUserStoreCount(Auth::id(),$id)!=0){
            return jsonResponse([
                'msg'=>'不能重复开店！'
            ],400);
        }

        $data = [
            'name'=>$post->name,
            'manager'=>$post->manager
        ];
        if ($this->handle->addStore($id,Auth::id(),$data)){
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }
        return jsonResponse([
            'msg'=>'操作失败！'
        ],400);
    }
    public function getStoreExpresses()
    {
        $page = Input::get('page',1);
        $limit = Input::get('limit',10);
        $title = Input::get('title','');
        $code = Input::get('code','');
        $data = $this->handle->getExpresses(getStoreId(),$page,$limit,$title,$code);
        return jsonResponse([
            'msg'=>'ok',
            'data'=>$data
        ]);
    }
    public function delExpress()
    {
        $id = Input::get('id');
        if ($this->handle->delExpress($id)){
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }
        return jsonResponse([
            'msg'=>'操作失败！'
        ],400);
    }
    public function addExpress(ExpressPost $post)
    {
        $id = $post->id?$post->id:0;
        if ($this->handle->addExpress($id,getStoreId(),$post->title,$post->code)){
            return jsonResponse([
                'msg'=>'ok'
            ]);
        }
        return jsonResponse([
            'msg'=>'操作失败！'
        ]);
    }

}
