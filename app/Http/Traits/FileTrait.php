<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    private function uploadFile($path, $file, $old_file = null)
    {
        if($old_file)
        {
            $this->deleteFile($path, $old_file);
        }

        $file_name = uuid_create() . "_" . $file->getClientOriginalName();
        $file->move($path, $file_name);
        return $file_name;
    }

    private function deleteFile($path)
    {
        $file = Storage::disk('public_uploads')->delete($path); 

    }

    private function deleteFolder($directory)
    {
        Storage::disk("public_uploads")->deleteDirectory($directory);
    }


}