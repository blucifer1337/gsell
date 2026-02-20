<?php

namespace App\Http\Controllers\Admin;

use App\Models\TopUp;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class TopUpController extends Controller
{
    public function index()
    {
        $pageTitle = 'Top Up List';
        $topUps = TopUp::orderBy('created_at', 'desc')->paginate(getPaginate());
        return view('admin.topup.index', compact('pageTitle', 'topUps'));
    }

    public function create()
    {

        $pageTitle = 'Publish A New Game Top Up';
        return view('admin.topup.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:55',
            'prices' => 'required',
            'status' => 'required',
            'quantities' => 'required',
            'description' => 'required',
            'instruction' => 'required|string|max:300',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'instruction_image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $newArray = [
            'quantities' => $request->quantities,
            'prices' => $request->prices
        ];

        $combinedArray = [];

        if ($request->quantities && $request->prices) {
            foreach ($newArray['quantities'] as $key => $val) {
                $quantity = $newArray['quantities'][$key];
                $price = $newArray['prices'][$key];
                $combinedArray[] = [
                    'quantity'.$key => $quantity,
                    'price'.$key => $price
                ];
            }
        }

        $purifier = new \HTMLPurifier();
        $topUp = new TopUp();
        $topUp->name = $request->name;
        $topUp->status = $request->status;
        $topUp->services_data = $combinedArray;
        $topUp->is_trending = $request->is_trending;
        $topUp->play_store_link = $request->play_store_link;
        $topUp->apple_store_link = $request->apple_store_link;
        $topUp->description = $purifier->purify($request->description);
        $topUp->instruction = $purifier->purify($request->instruction);

        if ($request->hasFile('image')) {
            try {
                $topUp->image = fileUploader($request->image, getFilePath('topup'), getFileSize('topup'), null, '256x224');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('instruction_image')) {
            try {
                $topUp->instruction_image = fileUploader($request->instruction_image, getFilePath('topup_instruct'), getFileSize('topup_instruct'));
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $topUp->save();

        $notify[] = ['success', 'Top Up published successfully'];
        return to_route('admin.topup.index')->withNotify($notify);
    }

    public function Edit($id)
    {
        $topUp = TopUp::find($id);
        $pageTitle = $topUp->name . ' Edit';
        return view('admin.topup.edit', compact('pageTitle', 'topUp'));
    }

    //-----------topUp Update-----------\\
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:55',
            'prices' => 'required',
            'status' => 'required',
            'quantities' => 'required',
            'description' => 'required',
            'instruction' => 'required|string|max:300',
            'image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'instruction_image' => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $newArray = [
            'quantities' => $request->quantities,
            'prices' => $request->prices
        ];

        $combinedArray = [];

        if ($request->quantities && $request->prices) {
            foreach ($newArray['quantities'] as $key => $val) {
                $quantity = $newArray['quantities'][$key];
                $price = $newArray['prices'][$key];
                $combinedArray[] = [
                    'quantity'.$key => $quantity,
                    'price'.$key => $price
                ];
            }
        }

        $purifier = new \HTMLPurifier();
        $topUp = TopUp::find($id);
        $topUp->name = $request->name;
        $topUp->status = $request->status;
        $topUp->services_data = $combinedArray;
        $topUp->is_trending = $request->is_trending;
        $topUp->play_store_link = $request->play_store_link;
        $topUp->apple_store_link = $request->apple_store_link;
        $topUp->description = $purifier->purify($request->description);
        $topUp->instruction = $purifier->purify($request->instruction);

        if ($request->hasFile('image')) {
            try {
                $old = $topUp->image;
                $topUp->image = fileUploader($request->image, getFilePath('topup'), getFileSize('topup'), $old, '256x224');
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('instruction_image')) {
            try {
                $old = $topUp->instruction_image;
                $topUp->instruction_image = fileUploader($request->instruction_image, getFilePath('topup_instruct'), getFileSize('topup_instruct'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }
        $topUp->save();

        $notify[] = ['success', 'Top Up updated successfully'];
        return back()->withNotify($notify);
    }

}
