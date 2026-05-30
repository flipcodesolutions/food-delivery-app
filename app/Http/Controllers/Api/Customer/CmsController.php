<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    // 1. Get all CMS pages
    public function cms(Request $request)
    {
        // $cmsPages = Cms::select('id', 'title', 'slug')->get();

        // return apiResponse(true , 'CMS created',$cmsPages,200);

      $query = Cms::query();

    // Search by title
    if ($request->filled('title')) {
        $query->where('title', 'LIKE', '%' . $request->title . '%');
    }

    // Search by slug
    if ($request->filled('slug')) {
        $query->where('slug', 'LIKE', '%' . $request->slug . '%');
    }

    $data = $query->select('id', 'title', 'slug')->get();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
       
    }

    // 2. Get single CMS page by slug
    public function showcms($slug)
    {
        $cms = Cms::where('slug', $slug)->first();

        if (!$cms) {
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $cms
        ]);
    }
}