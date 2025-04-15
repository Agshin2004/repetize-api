<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreCardRequest;
use App\Http\Resources\V1\CardCollection;
use App\Http\Resources\V1\CardResource;
use App\Models\Card;
use Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CardCollection(Card::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        // Implemented bulk inserting because more than one card can be added at the same time
        $cards = collect($request->validated())->map(function ($arr) {
            return array_merge(
                Arr::except($arr, ['deskId']),
                ['created_at' => now(), 'updated_at' => now()]
            );
        });

        $newCards = Card::insert($cards->toArray());
        return $newCards;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $card = Card::find($id);
        if ($card) {
            return new CardResource(Card::find($id));
        }
        return response()->json([
            'message' => "card with ($id) not found"
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
        $card = Card::find($id);
        if ($card) {
            $card->delete();
            return response(status: 204);
        }
        return response()->json([
            'message' => "post with id ($id) not found"
        ]);
    }
}
