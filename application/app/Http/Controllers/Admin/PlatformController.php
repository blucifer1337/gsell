<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;

class PlatformController extends Controller
{
    public function index(){
        $pageTitle = 'Platform Types';
        $platforms = Platform::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.platform.index', compact('platforms', 'pageTitle'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $platform = new Platform;
        $platform->name = $request->name;
        $platform->icon = $request->icon;
        $platform->is_menu_item = $request->is_menu_item;
        $platform->save();
        $notify[] = ['success', 'Platform has been added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $platform = Platform::find($id);
        $platform->name = $request->name;
        $platform->icon = $request->icon;
        $platform->is_menu_item = $request->is_menu_item;
        $platform->save();
        $notify[] = ['success', 'Platform has been updated successfully'];
        return back()->withNotify($notify);
    }
}
