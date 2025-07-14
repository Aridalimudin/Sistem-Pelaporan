<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; // <-- Tambahkan ini

class RoleController extends Controller
{
    /**
     * Menampilkan halaman manajemen role.
     */
    public function index()
    {
        $permissions = Permission::orderBy('name')->get(['id', 'name'])->toJson();
        return view('dashboard_Admin.Data_role.role', compact('permissions'));
    }

    /**
     * Mengambil data role untuk ditampilkan di tabel (dipanggil oleh JavaScript).
     */
    public function fetchData()
    {
        $roles = Role::with('permissions')->withCount('users')->latest()->get()->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name')->toArray(),
                'totalUsers' => $role->users_count,
                'createdAt' => $role->created_at->format('d M Y'),
            ];
        });

        return response()->json($roles);
    }

    /**
     * Menyimpan role baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id', // Pastikan semua item adalah ID permission yang valid
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Data tidak valid', 'errors' => $validator->errors()], 422);
        }

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        // FIX: Ambil model permission berdasarkan ID sebelum sync
        // Ini menghilangkan ambiguitas antara nama dan ID
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Role berhasil dibuat!', 'role' => $role], 201);
    }

    /**
     * Memperbarui role yang ada di database.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            // Gunakan Rule::unique untuk mengabaikan role saat ini dengan benar
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => 'required|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Data tidak valid', 'errors' => $validator->errors()], 422);
        }
        
        if ($role->name === 'Super Admin' && $role->name !== $request->name) {
             return response()->json(['message' => 'Nama role Super Admin tidak dapat diubah.'], 403);
        }

        $role->update(['name' => $request->name]);
        
        // FIX: Ambil model permission berdasarkan ID sebelum sync
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json(['message' => 'Role berhasil diperbarui!', 'role' => $role]);
    }

    /**
     * Menghapus role dari database.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['Super Admin', 'Admin'])) {
            return response()->json(['message' => 'Role ini tidak dapat dihapus.'], 403);
        }

        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus.']);
    }
}