<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/13
 * Time: 17:02
 */

namespace App\Servers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileServer {

    public $seccess_path = null;//成功上传文件路径

    /**
     * @param Request $request
     * @param string  $filename 保存文件名
     * @param string  $path     保存目录
     * @param string  $key      表单名称
     *
     * @return false|string
     */
    public function upload($filename, $path = 'public', $file, $fileInfo = []) {
        if (config('filesystems.default') == 'local') {
            $path = $path.'/uploads';
            $path = $file->storeAs($path, $filename);
            $this->seccess_path = $path;
            $url = asset(Storage::url($path));

            return $url;
        } else {
            return false;
        }
    }
}
