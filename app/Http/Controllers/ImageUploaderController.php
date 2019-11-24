<?php

namespace App\Http\Controllers;

use App\Picture;
use App\PictureType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploaderController extends Controller
{
    public function __invoke(Request $request){
        $data = $request->validate([
            "image"=>"required|image",
            "type_id"=>"required|exists:picture_types,id_pt"
        ]);

        $for_users = [1,2];
        if(!array_search($data["type_id"],$for_users)){
            return [
                "response"=>403
            ];
        }
        try{
            $path = $this->uploadFile($data);
            $picture = new Picture([
                "picture_path"=>$path,
                "creator_id"=>Auth::id(),
                "type_id"=>intval($data["type_id"])
            ]);
            $picture->save();

            return [
                "uploaded"=>true,
                "picture_id"=>$picture->id_p
            ];
        }catch(\Exception $e){
            return [
                "uploaded"=>false
            ];
        }
    }

    private function uploadFile($data){
        $type = PictureType::find($data["type_id"]);
        $abs = "images/".$type->name."s";
        $ext = $data["image"]->extension();
        do{
            $path = Str::random('32');
        }while(Storage::exists($abs."/".$path.".".$ext));

        $data["image"]->storeAs("public/".$abs,$path.".".$ext);
        return "/".$type->name."s"."/".$path.".".$ext;
    }
}
