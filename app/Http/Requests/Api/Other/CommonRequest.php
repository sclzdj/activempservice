<?php

namespace App\Http\Requests\Api\Other;

use Illuminate\Foundation\Http\FormRequest;

class CommonRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [];
        switch ($this->getScence()) {
            case 'data_count':
                $rules = [
                  'limit' => 'numeric|min:1|max:5',
                ];
                break;
            case 'paginate':
                $rules = [
                  'page'     => 'numeric|min:1',
                  'pageSize' => 'numeric|min:1',
                ];
                break;
            case 'mp_login':
                $rules = [
                  'code' => 'required',
                ];
                break;
        }

        return $rules;
    }

    public function messages() {
        $messages = [];
        switch ($this->getScence()) {
            case 'data_count':
                $messages = [
                  'limit.numeric' => '条数必须传数字',
                  'limit.min'     => '条数最小为1',
                  'limit.max'     => '条数最大为5',
                ];
                break;
            case 'paginate':
                $messages = [
                  'page.numeric'     => '页码必须传数字',
                  'page.min'         => '页码最小为1',
                  'pageSize.numeric' => '每页条数必须传数字',
                  'pageSize.min'     => '每页条数最小为1',
                ];
                break;
            case 'mp_login':
                $messages = [
                  'code.required'  => 'code必须传递',
                ];
                break;
        }

        return $messages;
    }

    public function scences() {
        return [
          'data_count' => ['GET|SlideController@getData', 'GET|EventController@getHomeData'],
          'paginate'   => ['GET|getPageData@getHomeData'],
          'mp_login'   => ['GET|UserController@mpLogin'],
        ];
    }

    public function getScence() {
        $actionName = request()->route()->getActionName();
        $requestMethod = $this->method();
        $scences = $this->scences();
        $is = false;
        $scence = '';
        foreach ($scences as $k => $v) {
            if (in_array($requestMethod.'|'.$actionName, $v)) {
                $is = true;
                $scence = $k;
                break;
            }
        }
        if (!$is) {
            foreach ($scences as $k => $v) {
                if (in_array($actionName, $v)) {
                    $scence = $k;
                    break;
                }
            }
        }

        return $scence;
    }
}
