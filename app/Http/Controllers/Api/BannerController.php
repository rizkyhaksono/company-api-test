<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all()->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'image' => $banner->image,
                'created_at' => $banner->created_at,
                'updated_at' => $banner->updated_at,
            ];
        });

        return $this->sendResponse($banners, 'Banners retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        } else {
            return response()->json(['error' => 'Image is required'], 400);
        }

        $banner = Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return $this->sendResponse($banner, 'Banner created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['error' => 'Banner not found'], 404);
        }

        $banner = [
            'id' => $banner->id,
            'title' => $banner->title,
            'image' => $banner->image,
            'created_at' => $banner->created_at,
            'updated_at' => $banner->updated_at,
        ];

        return $this->sendResponse($banner, 'Banner retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return $this->sendError('Banner not found.', 404);
        }

        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        return $this->sendResponse($banner, 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Banner::destroy($id);
        return $this->sendResponse(null, 'Banner deleted successfully.', 200);
    }
}
