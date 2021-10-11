<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Arr;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function errorUnauthorizedResponse($message)
    {
        return $this->errrorResponse($message, 401);
    }

    public function errorForbiddenResponse($message)
    {
        return $this->errrorResponse($message, 403);
    }

    public function errorNotFoundResponse($message)
    {
        return $this->errrorResponse($message, 404);
    }

    public function errrorResponse($message, $code)
    {
        return response([
            'message' => $message,
            'status_code' => $code,
//            'debug' => [
//                'line' => $exception->getLine(),
//                'file' => $exception->getFile(),
//                'class' => get_class($exception),
//                'trace' => explode("\n", $exception->getTraceAsString()),
//            ]
        ], $code);
    }

    /**
     * 分页响应
     */
    public function paginateResponse($data,$count,$offset,$limit)
    {
        return ['data' => $data, 'meta' => ['count' => (integer)$count, 'limit' => (integer)$limit, 'offset' => (integer)$offset]];
    }

    /**
     * model 分页响应
     */
    public function modelPaginateResponse($data)
    {
        $model = Arr::get($data,'model');
        $query = Arr::get($data,'query',$model::query());
        $load = Arr::get($data,'load');


        $offset = Arr::get($data,'offset',request()->input('offset',0));
        $limit =  Arr::get($data,'limit',request()->input('limit',20));


        // 获取对应模型的总数量
        $count = $query->count();
        // 获取对应模型的数据
        $data = $query->latest('id')->offset($offset)->limit($limit)->get();


        // 获取模型对应的resource
        $resource = str_replace('Models','Http\Resources',$model).'Resource';


        // 是否有load
        if($load){
            $data = $data->load($load);
        }

        $collect = $resource::collection($data);


        return $this->paginateResponse($collect,$count,$offset,$limit);
    }
}
