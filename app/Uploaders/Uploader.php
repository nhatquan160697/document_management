<?php

namespace App\Uploaders;

class Uploader
{
    public function saveDocument($documentFile)
    {
        if (isset($documentFile)) {
            $strDefault = config('setting.str_default');
            $tokenName = substr(str_shuffle($strDefault), 0, 16);
            $file = $documentFile;
            $fileExtension = $documentFile->getClientOriginalExtension();
            $nameFile = explode('.',$documentFile->getClientOriginalName());
            $newName = time() .'-'. $nameFile[0] . '.' . $fileExtension;
            $path = public_path('files/file_attachment');
            $documentFile = $newName;
            $file->move($path, $newName);
            return $newName;
        }
    }

    public function saveFileAttach($fileAttach , $path)
    {
        if (isset($fileAttach)) {
            foreach($fileAttach as $file)
            {
                $strDefault = config('setting.str_default');
                $tokenName = substr(str_shuffle($strDefault), 0, 16);
                $fileName = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                $fileExtension = $file->getClientOriginalExtension();
                $newName = $fileName.'-'.time().'-'.$tokenName.'.'.$fileExtension;
                $path = public_path($path);
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
}
