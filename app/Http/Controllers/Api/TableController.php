<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TableResource;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of tables.
     */
    public function index(Request $request)
    {
        $query = Table::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tables = $query->get();

        return TableResource::collection($tables);
    }

    /**
     * Store a newly created table.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:255|unique:tables,table_number',
            'status' => 'required|in:available,occupied',
        ]);

        $table = Table::create([
            'table_number' => $request->table_number,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil ditambahkan.',
            'data' => new TableResource($table),
        ], 201);
    }

    /**
     * Display the specified table.
     */
    public function show(Table $table)
    {
        return response()->json([
            'success' => true,
            'data' => new TableResource($table),
        ], 200);
    }

    /**
     * Update the specified table.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'sometimes|required|string|max:255|unique:tables,table_number,' . $table->id,
            'status' => 'sometimes|required|in:available,occupied',
        ]);

        $table->update($request->only(['table_number', 'status']));

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil diupdate.',
            'data' => new TableResource($table),
        ], 200);
    }

    /**
     * Remove the specified table.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return response()->json([
            'success' => true,
            'message' => 'Meja berhasil dihapus.',
        ], 200);
    }
}
