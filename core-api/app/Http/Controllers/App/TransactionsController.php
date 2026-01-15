<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;

class TransactionsController
{
    public function index()
    {
        return response()->json(['data' => []]);
    }

    public function store(Request $request)
    {
        return response()->json(['data' => $request->all()], 201);
    }

    public function show(int $id)
    {
        return response()->json(['data' => ['id' => $id]]);
    }

    public function update(Request $request, int $id)
    {
        return response()->json(['data' => array_merge(['id' => $id], $request->all())]);
    }

    public function destroy(int $id)
    {
        return response()->json(['deleted' => $id]);
    }
}
