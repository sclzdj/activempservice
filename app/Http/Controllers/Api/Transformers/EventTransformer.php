<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/22
 * Time: 3:52
 */

namespace App\Http\Controllers\Api\Transformers;

use App\Model\Active\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract {

    public function transform(Event $event) {
        return [
          'id'         => $event->id,
          'title'      => $event->title,
          'pic'        => $event->pic,
          'describe'   => $event->describe,
          'content'    => $event->content,
          'pv'         => $event->pv,
          'created_at' => $event->created_at->toDateString(),#时间处理
          'updated_at' => $event->created_at->toDateString(),#时间处理
        ];
    }
}