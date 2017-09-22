<?php

namespace App\Http\Controllers;

use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function move(UploadedFile $file, $directory = '', $targetName = '')
    {
        $directory = $directory ?: public_path('storage');
        $defaultName = $this->defaultNaming($file);
        return $file->move($directory, $targetName ?: $defaultName);
    }

    public function delete($file)
    {
        Storage::delete($file);
    }

    public function getFileMeta(UploadedFile $file)
    {
        $meta['name'] = $file->getClientOriginalName();
        $meta['mime'] = $file->getClientMimeType();
        $meta['extension'] = $file->getClientOriginalExtension();
        $meta['size'] = $file->getClientSize();
        return $meta;
    }

    public function defaultNaming(UploadedFile $file, $format = 'Y-m-d_His')
    {
        $meta = $this->getFileMeta($file);
        return date($format) . $meta['name'];
    }

    public function decodeBase64Image($data)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)) {
            //保存base64字符串为图片 //匹配出图片的格式
            $suffix = $result[2];
            $decoded = base64_decode(str_replace($result[1], '', $data));
//            $tmp = tmpfile();
//            fwrite($tmp, $decoded);
//            return $tmp;
            return tap(new File($suffix,tmpfile()), function ($file) use ($decoded) {
                fwrite($file->tmpFile, $decoded);
            });
        }

    }
}
