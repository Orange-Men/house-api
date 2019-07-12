<?php

namespace App\Http\Controllers;

use App\House;
use App\Http\Requests\GetHouse;

class HouseController extends Controller
{
    public function index(GetHouse $request)
    {
        $validated = $request->validated();

        $houses = House::when($validated['name'] ?? false, function ($query, $name) use (&$validated) {
                unset($validated['name']);
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($validated['price'] ?? false, function ($query, $price) use (&$validated) {
                unset($validated['price']);
                return $query->where('price', '>=', $price[0])
                    ->where('price', '<=', $price[1]);
            })
            ->where($validated)
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'success',
            'data' => [
                'houses' => $houses
            ]
        ]);
    }
}
