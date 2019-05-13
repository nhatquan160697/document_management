<?php

namespace App\Uploaders;
use File;

class Uploader
{
    public function saveDocument($documentFile, $path)
    {
        if (isset($documentFile)) {
            $strDefault = config('setting.str_default');
            $tokenName = substr(str_shuffle($strDefault), 0, 16);
            $file = $documentFile;
            $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
            $fileExtension = $file->getClientOriginalExtension();
            $newName = $fileName.'-'.time().'-'.$tokenName.'.'.$fileExtension;
            $documentFile = $newName;
            $file->move($path, $newName);
            return $newName;
        }
    }

    public function saveFileAttach($fileAttach , $link)
    {
        if (isset($fileAttach)) {
            foreach($fileAttach as $file)
            {
                $strDefault = config('setting.str_default');
                $tokenName = substr(str_shuffle($strDefault), 0, 16);
                $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $newName = $fileName.'-'.time().'-'.$tokenName.'.'.$fileExtension;
                $path = public_path($link);
                $file->move($path, $newName);
                $data[] = $newName;
            }
            return $data;
        }
    }

    public function saveImg($imgFile)
    {
        if (isset($imgFile)) {
            $strDefault = config('setting.str_default');
            $tokenName = substr(str_shuffle($strDefault), 0, 16);
            $file = $imgFile;
            $fileExtension = $imgFile->getClientOriginalExtension();
            $nameFile = explode('.',$imgFile->getClientOriginalName());
            $newName = 'avatar-'.time().'-'.$tokenName.'.'.$fileExtension;
            $path = public_path('/upload/images');
            $imgFile = $newName;
            $file->move($path, $newName);
            return $newName;
        }
    }

    public function checkOldImg($file, $isArray, $path){
        if(isset($file)){
            if($isArray == false){
                File::delete(public_path($path.'/'.$file));
            }
            else {
                $arrayFileDecode = json_decode($file);
                foreach($arrayFileDecode as $value)
                {
                    File::delete(public_path($path.'/'.$value));
                }
            }
        }
    }
}
