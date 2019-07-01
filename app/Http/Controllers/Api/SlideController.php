<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Transformers\SlideTransformer;
use App\Http\Requests\Api\Other\CommonRequest;
use App\Model\Active\Slide;

class SlideController extends BaseController {

    public function getData(CommonRequest $request) {
        $limit = (int)$request->get('limit', 2);

        $slides = Slide::limit($limit)->get();

        return $this->response->collection($slides, new SlideTransformer());
    }
}
