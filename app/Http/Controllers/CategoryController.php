<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiHandler;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiHandler;
    public function create(Request $request){
        $rules = [
            'name_ar' => 'required|string|max:50',
            'name_en' => 'required|string|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($validator, $code);
        }

        $category = Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
        ]);
        
        if(!$category){
            return $this->errorMessage("Failed to create category");
            // return response()->json(['msg' => 'Failed to create category'], 500);
        }
        return $this->errorMessage("Added Successfully");
        // return response()->json(['msg' => 'Added Successfully'], 200);
    }

    public function getAll(Request $request){
        $categories = Category::select("id", "name_".app()->getLocale())->get();
        if(!$categories){
            return response()->json(['msg' => 'No categories to show'], 500); 
        }
        return response()->json($categories);
    }

    public function update(Request $request){
        $updated = Category::where("id", $request->id)->update([
            "name_ar" => $request->name_ar,
            "name_en" => $request->name_en
        ]);
        
        if($updated){
            return response()->json(['msg' => 'Category Updated Successfully!'], 200);
        }
        return response()->json(['msg' => 'Failed to update category'], 500);
    }

    public function delete(Request $request){
        $deleted = Category::find($request->id);
        if($deleted){
            $deleted->delete();
            return response()->json(['msg' => 'Category deleted successfully!'], 200);
        }
        return response()->json(['msg' => 'Failed to delete category'], 500);
    }

    public function getCategoryById(Request $request){
        $category = Category::where("id", $request->id)->get();
        if($category){
            return response()->json(["msg" => $category]);
        }
        return response()->json(['msg' => 'No category found'], 500); 
    }
}
