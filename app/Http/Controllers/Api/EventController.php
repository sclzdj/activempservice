<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Transformers\EventTransformer;
use App\Http\Requests\Api\EventRequest;
use App\Http\Requests\Api\Other\CommonRequest;
use App\Model\Active\Event;

class EventController extends BaseController {

    public function getHomeData(CommonRequest $request) {
        $limit = (int)$request->get('limit', 2);
        $hotEvents = Event::orderBy('pv', 'DESC')->limit($limit)->get()->toArray();
        $newEvents = Event::orderBy('created_at', 'DESC')->limit($limit)->get()->toArray();

        return $this->responseParseArray(compact('hotEvents', 'newEvents'));
    }

    public function getPageData(CommonRequest $request) {
        $pageSize = (int)$request->get('pageSize', 10);
        $filter = [];
        $filter['keywords'] = urldecode((string)$request->get('keywords', ''));
        $filter['type'] = urldecode((string)$request->get('type', ''));
        $where = [];
        if ($filter['keywords'] !== '') {
            $where[] = ['title', 'like', '%'.$filter['keywords'].'%'];
        }
        if ($filter['type'] == 'hot') {
            $events = Event::where($where)->orderBy('pv', 'DESC')->paginate($pageSize);
        } elseif ($filter['type'] == 'new') {
            $events = Event::where($where)->orderBy('created_at', 'DESC')->paginate($pageSize);
        } else {
            $events = Event::where($where)->orderBy('id', 'DESC')->paginate($pageSize);
//            $events = Event::where($where)->orderBy('pv', 'DESC')->orderBy('created_at', 'DESC')->paginate($pageSize);
        }

        return $this->response->paginator($events, new EventTransformer());
    }

    public function getOne(EventRequest $request) {
        $id = (int)$request->get('id');
        $event = Event::find($id);

        $event->pv++;
        $event->save();

        return $this->responseParseArray($event);
    }
}
