<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index(){
        $pageTitle = 'Genre Types';
        $genres = Genre::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.genre.index', compact('genres', 'pageTitle'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $genre = new Genre;
        $genre->name = $request->name;
        $genre->is_menu_item = $request->is_menu_item;
        $genre->save();
        $notify[] = ['success', 'Genre has been added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $genre = Genre::find($id);
        $genre->name = $request->name;
        $genre->is_menu_item = $request->is_menu_item;
        $genre->save();
        $notify[] = ['success', 'Genre has been updated successfully'];
        return back()->withNotify($notify);
    }
}
