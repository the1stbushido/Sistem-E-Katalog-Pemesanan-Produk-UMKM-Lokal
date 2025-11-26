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
     * Daftar admin dengan fitur pencarian
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'admin');

       
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $admins = $query
            ->orderBy('is_approved', 'asc')
            ->orderBy('name', 'asc')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

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
