<?php

namespace App\Http\Controllers;

use App\Category;
use App\Custom\ImageUploader;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\EditCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function getAdminCategories()
    {
        return view("admin/configure/categories");
    }

    public function ajaxAdminGetCategories()
    {
        $cat = Category::all();
        $cat = $cat->map(function ($x) {
            $x->path = $x->picture->path;
            return $x;
        });
        return $cat;
    }

    public function ajaxAdminCreate(CreateCategory $request)
    {
        $data = $request->validated();
        $cat = new Category([
            "uuid" => $this->generateUUID(),
            "label" => $data["label"],
            "description" => $data["description"],
            "picture_id" => $data["picture_id"],
            "color" => $data["color"],
            "disabled" => $data["disabled"]
        ]);

        try {
            $cat->save();
            $cat->path = $cat->picture->path;
            return [
                "created" => true,
                "category" => $cat
            ];
        } catch (\Exception $e) {
            return [
                "created" => false
            ];
        }
    }

    private function generateUUID()
    {
        do {
            $str = Str::random(4);
        } while ((Category::where("uuid", $str)->exists()));
        return $str;
    }

    public function ajaxAdminEdit(EditCategory $request)
    {
        $data = $request->validated();
        $c = Category::where("uuid", $data["uuid"])->firstOrFail();

        try {
            $c->update([
                "label" => $data["label"],
                "description" => $data["description"],
                "picture_id" => $data["picture"],
                "color" => $data["color"],
                "disabled" => $data["disabled"]
            ]);
            $c->path = $c->picture->path;
            return response()->json([
                "edited" => true,
                "category" =>$c
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "edited" => false,
                "e"=>$e->getMessage()
            ]);
        }

    }

    public function ajaxAdminUploadImage(Request $request)
    {
        $data = $request->validate([
            "image" => "required|image",
        ]);
        return ImageUploader::upload($data["image"],3);
    }
}
