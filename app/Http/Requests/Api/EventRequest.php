<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 10:29
 */

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Other\CommonRequest;

class EventRequest extends CommonRequest {

    public function rules() {
        $rules = [];
        switch ($this->getScence()) {
            case 'id':
                $rules = [
                  'id' => 'required|numeric|min:1|exists:events',
                ];
                break;
        }

        return $rules;
    }

    public function messages() {
        $messages = [];
        switch ($this->getScence()) {
            case 'id':
                $messages = [
                  'id.required' => '活动id必须传递',
                  'id.numeric'  => '活动id必须传数字',
                  'id.min'      => '活动id最小为1',
                  'id.exists'   => '活动不存在',
                ];
                break;
        }

        return $messages;
    }

    public function scences() {
        return [
          'id' => ['GET|EventController@getOne'],
        ];
    }
}