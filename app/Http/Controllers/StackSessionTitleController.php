<?php

namespace App\Http\Controllers;

use App\Models\StackSessionTitle;
use Illuminate\Http\Request;

class StackSessionTitleController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        try {
            StackSessionTitle::create($data);
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function update(Request $request, StackSessionTitle $stackSessionTitle)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;

        try {
            $stackSessionTitle->fill($data)->save();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(StackSessionTitle $stackSessionTitle)
    {
        $stackSessionTitle->delete();
        session()->flash('success', __('dashboard.response_item_delete'));
        return redirect()->back();
    }
}
