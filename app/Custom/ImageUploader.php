<?php


namespace App\Custom;


use App\Picture;
use App\PictureType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploader
{
    public static function upload($image,$type_id){
        try{
            $path = self::uploadFile($image,$type_id);
            $picture = new Picture([
                "picture_path"=>$path,
                "creator_id"=>Auth::id(),
                "type_id"=>$type_id
            ]);
            $picture->save();

            return [
                "uploaded"=>true,
                "picture_id"=>$picture->id_p
            ];
        }catch(\Exception $e){
            return [
                "uploaded"=>false,
                "e"=>$e->getMessage()
            ];
        }
    }
    private static function uploadFile($image,$type_id){
        $type = PictureType::find($type_id);
        $abs = "images/".$type->name."s";
        $ext = $image->extension();
        do{
            $path = Str::random('32');
        }while(Storage::exists($abs."/".$path.".".$ext));

        $image->storeAs("public/".$abs,$path.".".$ext);
        return "/".$type->name."s"."/".$path.".".$ext;
    }
}
