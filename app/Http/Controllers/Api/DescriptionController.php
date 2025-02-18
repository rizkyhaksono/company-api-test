<?php

namespace App\Http\Controllers\Api;

use App\Models\Description;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Description::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['content' => 'required']);
        $description = Description::create($request->all());
        return response()->json($description, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Description::find($id), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $description = Description::find($id);

        if (!$description) {
            return $this->sendError('Description not found.', 404);
        }

        $request->validate(['content' => 'required']);
        $description->update($request->all());
        return $this->sendResponse($description, 'Description updated successfully.', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Description::destroy($id);
        return response()->json(null, 204);
    }
}
