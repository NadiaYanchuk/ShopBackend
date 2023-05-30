<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function Index(){
        $allsubcategories = Subcategory::latest()->get();
        return view('admin.allsubcategories', compact('allsubcategories'));
    }

    public function AddSubCategory(){
        $categories = Category::latest()->get();
        return view('admin.addsubcategory', compact('categories'));
    }

    public function StoreSubCategory(Request $request) {
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
            'category_id' => 'required'
        ]);

        $category_id = $request->category_id;

        $category_name = Category::where('id', $category_id)->value('category_name');

        Subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
            'category_id' => $category_id,
            'category_name' => $category_name
        ]);

        Category::where('id', $category_id)->increment('subcategory_count', 1);

        return redirect()->route('allsubcategories')->with('message', 'Sub Category Added Successfully!');
    }

    public function EditSubCategory($id) {
        $subcatinfo = Subcategory::findOrFail($id);

        return view('admin.editsubcategory', compact('subcatinfo'));
    }

    public function UpdateSubCategory(Request $request) {
        $subcatid = $request->subcatid;

        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
        ]);

        Subcategory::findOrFail($subcatid)->update([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        return redirect()->route('allsubcategories')->with('message', 'Sub Category Updated Successfully!');
    }
}
