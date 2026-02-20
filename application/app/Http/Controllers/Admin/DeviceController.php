<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index(){
        $pageTitle = 'Device Types';
        $devices = Device::orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.device.index', compact('devices', 'pageTitle'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $device = new Device;
        $device->name = $request->name;
        $device->icon = $request->icon;
        $device->is_menu_item = $request->is_menu_item;
        $device->save();
        $notify[] = ['success', 'Device has been added successfully'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:100'
        ]);
        $device = Device::find($id);
        $device->name = $request->name;
        $device->icon = $request->icon;
        $device->is_menu_item = $request->is_menu_item;
        $device->save();
        $notify[] = ['success', 'Device has been updated successfully'];
        return back()->withNotify($notify);
    }
}
