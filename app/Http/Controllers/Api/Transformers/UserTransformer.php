<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/22
 * Time: 3:52
 */

namespace App\Http\Controllers\Api\Transformers;

use App\Model\Active\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

    public function transform(User $user) {
        return [
          'id'         => $user->id,
          'nickName'   => $user->nickName,
          'avatarUrl'  => $user->avatarUrl,
          'gender'     => $user->gender,
          'province'   => $user->province,
          'created_at' => $user->created_at->toDateTimeString(),#时间处理
          'updated_at' => $user->created_at->toDateTimeString(),#时间处理
        ];
    }
}