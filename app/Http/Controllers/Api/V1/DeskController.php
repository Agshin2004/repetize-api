<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreDeskRequest;
use App\Http\Resources\V1\DeskResource;
use App\Models\Desk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DeskCollection;

class DeskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new DeskCollection(Desk::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeskRequest $request)
    {
        $data = $request->validated();
        $desk = Desk::create($data);

        return $desk;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $desk = Desk::find($id);
        if ($desk) {
            return new DeskResource(Desk::find($id));
        }
        return response()->json([
            'message' => "no desk with id {$id} found"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $desk = Desk::find($id);
        if ($desk) {
            $desk->delete();
            return response(status: 204);
        }

        return response()->json([
            'message' => "no desk with id {$id} found"
        ]);
    }
}
