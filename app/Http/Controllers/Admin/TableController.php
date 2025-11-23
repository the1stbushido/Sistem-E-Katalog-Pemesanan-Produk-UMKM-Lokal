<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table; 
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Tampilkan daftar semua meja.
     */
    public function index()
    {
        $tables = Table::all();
        return view('admin.tables.index', compact('tables'));
    }

    /**
     * Tampilkan form untuk membuat meja baru.
     */
    public function create()
    {
        return view('admin.tables.form');
    }

    /**
     * Simpan meja baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:255|unique:tables',
            'status' => 'required|in:available,occupied',
        ]);

        Table::create($request->all());

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil ditambahkan.');
    }

    /**
     * Tampilkan form untuk mengedit meja.
     */
    public function edit(Table $table)
    {
        return view('admin.tables.form', compact('table'));
    }

    /**
     * Update meja di database.
     */
    public function update(Request $request, Table $table)
    {
        $request->validate([
            'table_number' => 'required|string|max:255|unique:tables,table_number,' . $table->id,
            'status' => 'required|in:available,occupied',
        ]);

        $table->update($request->all());

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil diperbarui.');
    }

    /**
     * Hapus meja dari database.
     */
    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }
}