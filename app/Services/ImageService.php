<?php

namespace App\Services;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
class ImageService
{

    public function upload($image, $path, $width = null, $height = null)
    {
        $newImage = time() . $image->getClientOriginalName();
        $imagePath = $path . '/' . $newImage;
        $resizedImage = ImageManager::imagick()->read($image->getRealPath());

        if ($width && $height)
        {
            $resizedImage->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        else
         {
            $resizedImage->resize(800, 600, function ($constraint)
             {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        $resizedImage->save($imagePath);
        return $imagePath;
    }
    public function delete($imagePath)
    {
        if (File::exists($imagePath))
        {
            File::delete($imagePath);
        }
    }
}

