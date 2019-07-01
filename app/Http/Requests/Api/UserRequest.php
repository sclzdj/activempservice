<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/23
 * Time: 10:29
 */

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\Other\CommonRequest;

class UserRequest extends CommonRequest {

    public function rules() {
        $rules = [];
        switch ($this->getScence()) {
            case 'id':
                $rules = [
                  'id' => 'required|numeric|min:1|exists:events',
                ];
                break;
            case 'edit':
                $rules = [
                  'nickName' => 'required|min:2|max:20',
                  'gender'   => 'numeric|in:0,1,2',
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
                  'id.required' => '用户id必须传递',
                  'id.numeric'  => '用户id必须传数字',
                  'id.min'      => '用户id最小为1',
                  'id.exists'   => '用户不存在',
                ];
                break;
            case 'edit':
                $messages = [
                  'nickName.required' => '用户昵称必须传递',
                  'nickName.min'      => '用户昵称最小2位',
                  'nickName.max'      => '用户昵称最大20位',
                  'gender.numeric'    => '用户性别必须传数字',
                  'gender.in'         => '用户性别传值错误',
                ];
                break;
        }

        return $messages;
    }

    public function scences() {
        return [
          'id'   => [],
          'edit' => ['GET|UserController@save'],
        ];
    }
}