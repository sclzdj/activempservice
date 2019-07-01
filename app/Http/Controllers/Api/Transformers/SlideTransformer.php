<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/22
 * Time: 3:52
 */

namespace App\Http\Controllers\Api\Transformers;
use App\Model\Active\Slide;
use League\Fractal\TransformerAbstract;

class SlideTransformer extends TransformerAbstract{
    public function transform(Slide $slide){
        return [
          'id'=>$slide->id,
          'title'=>$slide->title,
          'pic'=>$slide->pic,
          'event_id'=>$slide->event_id,
          'created_at'=>$slide->created_at->toDateTimeString(),#时间处理
          'updated_at'=>$slide->created_at->toDateTimeString(),#时间处理
        ];
    }
}