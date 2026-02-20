<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $pageTitle = 'Product Categories';
        $categories = Category::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.category.index', compact('categories', 'pageTitle'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->is_menu_item = $request->is_menu_item;
        $category->save();
        $notify[] = ['success', 'Category has been added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $category = Category::find($id);
        $category->name = $request->name;
        $category->is_menu_item = $request->is_menu_item;
        $category->save();
        $notify[] = ['success', 'Category has been updated successfully'];
        return back()->withNotify($notify);
    }

}
