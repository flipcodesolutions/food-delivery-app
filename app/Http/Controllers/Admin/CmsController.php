<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;
use Illuminate\Support\Str;

class CmsController extends Controller
{
   public function edit($slug){
        // get single cms data
        $cms =  Cms::where('slug', $slug)->first();  
        return view('admin.cms.edit', compact('cms'));
    }
    public function update(Request $request, $slug){
       $request->validate([
        'title'=>'required',
         'description'=>'required',

       ]);
       $cms=Cms::where('slug',$slug)->firstOrFail();
       $cms->update([
        'title'=>$request->title,
        'slug'=>Str::slug($request->title),
        'description'=>$request->description,
       ]);
       return redirect()->route('admin.cms.edit',$cms->slug)->with('success','CMS updated successfully');
        }
}
