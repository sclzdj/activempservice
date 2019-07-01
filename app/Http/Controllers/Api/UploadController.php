<?php

namespace App\Http\Controllers\Api;

use App\Servers\FileServer;
use Illuminate\Http\Request;

class UploadController extends BaseController {

    /**
     * 文件上传
     *
     * @param string $path 保存目录
     * @param string $key  表单名称
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function main(Request $request, $path = 'public', $key = 'file') {
        $filename = $request->instance()->post('filename', '');
        $filename = str_replace('\\', '/', $filename);
        $filename = ltrim($filename, '/');
        if ($filename === '') {
            $filename = date("Ymd/").time().mt_rand(10000, 99999);
        }
        $config = [
          'upload_image_limit_size'      => 1024,//允许最大上传图片大小，单位kb默认2048kb
          'upload_image_allow_extension' => 'jpg,jpeg,gif,png,bmp',//允许上传图片的后缀名，单位kb默认2048kb
          'upload_file_limit_size'      => 10240,//允许最大上传文件大小，单位kb默认2048kb
          'upload_file_allow_extension' => '',//允许上传文件的后缀名，单位kb默认2048kb
        ];
        if (!$request->hasFile($key)) {
            return $this->response->error('没有选择上传文件', 400);
        }
        if (!$request->file($key)->isValid()) {
            return $this->response->error('上传过程中出错，请主要检查服务器端php.ini是否配置正确', 400);
        }
        $fileInfo = [];
        $fileInfo['extension'] = $request->file->extension();
        $fileInfo['mimeType'] = $request->file->getMimeType();
        $fileInfo['size'] = $request->file->getClientSize();
        $fileInfo['iniSize'] = $request->file->getMaxFilesize();
        if ($fileInfo['size'] > $fileInfo['iniSize']) {
            return $this->response->error('php.ini最大限制上传'.number_format($fileInfo['iniSize'] / 1024 / 1024, 2, '.', '').'M的文件', 400);
        }
        if (strpos($fileInfo['mimeType'], 'image/') !== false) {
            $upload_image_limit_size = $config['upload_image_limit_size'];
            if ($upload_image_limit_size > 0 && $fileInfo['size'] > $upload_image_limit_size * 1000) {
                return $this->response->error('最大允许上传'.$upload_image_limit_size.'K的图片', 400);
            }
            $upload_image_allow_extension = $config['upload_image_allow_extension'];
            if ($upload_image_allow_extension !== '') {
                $upload_image_allow_extension_arr = explode(',', $upload_image_allow_extension);
                if (!in_array($fileInfo['extension'], $upload_image_allow_extension_arr)) {
                    return $this->response->error('只允许上传图片的后缀类型：'.$upload_image_allow_extension, 400);
                }
            }
        } else {
            $upload_file_limit_size = $config['upload_file_limit_size'];
            if ($upload_file_limit_size > 0 && $fileInfo['size'] > $upload_file_limit_size * 1000) {
                return $this->response->error('最大允许上传'.$upload_file_limit_size.'K的文件', 400);
            }
            $upload_file_allow_extension = $config['upload_file_allow_extension'];
            if ($upload_file_allow_extension !== '') {
                $upload_file_allow_extension_arr = explode(',', $upload_file_allow_extension);
                if (!in_array($fileInfo['extension'], $upload_file_allow_extension_arr)) {
                    return $this->response->error('只允许上传文件的后缀类型：'.$upload_file_allow_extension, 400);
                }
            }
        }
        $filename .= '.'.$fileInfo['extension'];
        $FileServer = new FileServer();
        if (request()->method() == 'OPTIONS') {
            return $this->response->noContent();
        }
        $url = $FileServer->upload($filename, $path, $request->file($key), $fileInfo);
        if ($url !== false) {
            return $this->response->created(null, ['url'=>$url]);
        } else {
            return $this->response->error('上传失败', 400);
        }
    }
}
