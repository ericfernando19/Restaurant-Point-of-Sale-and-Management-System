<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search nama, email, telepon
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('telepon', 'like', "%$search%");
            });
        }

        $karyawans = $query->orderBy('nama')->paginate(10)->withQueryString();

        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawans,email',
            'telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,kasir,koki',
        ]);

        Karyawan::create($validated); // ✅ Simpan ke DB

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,kasir,koki',
        ]);

        $karyawan->update($validated); // ✅ Update DB

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan diperbarui!');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus!');
    }
}
