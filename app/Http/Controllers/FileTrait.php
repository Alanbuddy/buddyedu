<?php

namespace App\Http\Controllers;

use App\Models\File;
use Faker\Provider\Uuid;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function move(UploadedFile $file, $directory = '', $targetName = '')
    {
        $directory = $directory ?: $this->defaultDirectory();
        $defaultName = $this->defaultNaming($file);
        return $file->move($directory, $targetName ?: $defaultName);
    }

    /**
     * example: public/storage/2017-10-06/58/03
     * @return string
     */
    public function defaultDirectory()
    {
        $key = Uuid::uuid();
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);
        return public_path('storage/') . date('Y-m-d') .'/'. implode('/', $parts);
    }

    public function defaultNaming(UploadedFile $file, $format = 'Y-m-d_His')
    {
        $meta = $this->getFileMeta($file);
        return date($format) . $meta['name'];
    }

    public function getFileMeta(UploadedFile $file)
    {
        $meta['name'] = $file->getClientOriginalName();
        $meta['mime'] = $file->getClientMimeType();
        $meta['extension'] = $file->getClientOriginalExtension();
        $meta['size'] = $file->getClientSize();
        return $meta;
    }

    public function delete($file)
    {
        Storage::delete($file);
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
            return tap(new File($suffix, tmpfile()), function ($file) use ($decoded) {
                fwrite($file->tmpFile, $decoded);
            });
        }

    }

    public function store2DB(UploadedFile $file, $target)
    {
        $item = new File();
        $item->path = substr($target->getPathname(), strlen(public_path()));
        $item->user_id = auth()->user()->id;
        $item->fill($this->getFileMeta($file));
        $item->save();
        return $item;
    }
}
