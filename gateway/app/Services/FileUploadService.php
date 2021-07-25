<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class FileUploadService
 * @package App\Services
 */
class FileUploadService
{
    public static function uploadFile($object, $image, $type = 'transfer')
    {
        switch ($type) {
            case $type == 'transfer';
                $fileName = 'transfer' . $object->uuid . '.' . $image->getClientOriginalExtension();
            break;
        }

        if(Storage::exists(public_path($object->uuid))) {
            $file = $image->move(public_path($object->uuid) , $fileName);
        } else {
            //creates directory
            $path = public_path().'/' . $object->uuid;
            File::makeDirectory($path, $mode = 0775, true, true);
            $file = $image->move(public_path($object->uuid) , $fileName);
        }
        
        $path = '/' . $object->uuid. '/' .$fileName;
        return $path;
    }
}
