<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    /**
     * Daftar admin + search.
     */
    public function index(Request $request)
    {
        // Query dasar: semua user dengan role admin
        $query = User::where('role', 'admin');

        // Jika ada parameter search, filter berdasarkan nama atau email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Urutan:
        // 1. yang belum disetujui dulu (is_approved ascending)
        // 2. urut nama
        // 3. yang paling baru dibuat di atas (created_at desc)
        $admins = $query
            ->orderBy('is_approved', 'asc')
            ->orderBy('name', 'asc')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString(); // supaya ?search tetap ikut saat pindah halaman

        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Setujui akun admin yang baru mendaftar
     */
    public function approve(User $user)
    {
        if ($user->role === 'admin' && !$user->is_approved) {
            $user->update(['is_approved' => true]);
            return redirect()->back()->with('success', 'Akun admin berhasil disetujui.');
        }

        return redirect()->back()->with('error', 'Gagal menyetujui akun.');
    }

    /**
     * Ganti password akun admin
     */
    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($user->role === 'admin') {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Password admin berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Gagal mengubah password.');
    }

    /**
     * Hapus akun admin
     */
    public function destroy(User $user)
    {
        // Pastikan superadmin tidak menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'admin') {
            $user->delete();
            return redirect()->back()->with('success', 'Akun admin berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus akun.');
    }
}
