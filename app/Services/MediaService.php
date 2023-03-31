<?php

namespace App\Services;

class MediaService
{
    public function upload($file)
    {
        try{
            $imageName = time().'.'.$file->extension();
            $file->move(public_path('images'), $imageName);
        }catch (\Exception $e){
            // default image in case of error
            return "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.default.com%2F&psig=AOvVaw2ps0NbnzZo7YJYrmrAX2M1&ust=1680348705361000&source=images&cd=vfe&ved=0CBAQjRxqFwoTCNCt5_CIhv4CFQAAAAAdAAAAABAD";
        }
        return $imageName;
    }

}
