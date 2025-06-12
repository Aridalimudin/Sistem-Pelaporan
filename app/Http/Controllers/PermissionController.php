<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission; // Import model Permission dari Spatie
use Carbon\Carbon; // Untuk formatting tanggal

class PermissionController extends Controller
{
    /**
     * Tampilkan daftar semua permissions.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $permissions = Permission::all()->map(function ($permission) {

            $usageCount = $permission->roles->count(); 

            return [
                'id' => $permission->id,
                'name' => $permission->name,
                'usage' => $usageCount,
                'createdAt' => Carbon::parse($permission->created_at)->toISOString(),
                'updatedAt' => Carbon::parse($permission->updated_at)->toISOString(),
            ];
        });

        $permissionsUsed = $permissions->filter(fn($p) => $p['usage'] > 0)->count();
        $totalRolesFromUsage = $permissions->sum('usage');

        $activeRolesCount = \Spatie\Permission\Models\Role::count();

        return response()->json([
            'permissions' => $permissions,
            'stats' => [
                'totalPermissions' => $permissions->count(),
                'permissionsUsed' => $permissionsUsed,
                'activeRoles' => $activeRolesCount,
            ]
        ]);
    }

    /**
     * Simpan permission baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name', 
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web', 
        ]);

        // Format data untuk respons
        $usageCount = $permission->roles->count();
        $formattedPermission = [
            'id' => $permission->id,
            'name' => $permission->name,
            'usage' => $usageCount,
            'createdAt' => Carbon::parse($permission->created_at)->toISOString(),
            'updatedAt' => Carbon::parse($permission->updated_at)->toISOString(),
        ];

        return response()->json([
            'message' => 'Permission berhasil ditambahkan!',
            'permission' => $formattedPermission
        ], 201);
    }

    /**
     * Perbarui permission yang ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        $usageCount = $permission->roles->count();
        $formattedPermission = [
            'id' => $permission->id,
            'name' => $permission->name,
            'usage' => $usageCount,
            'createdAt' => Carbon::parse($permission->created_at)->toISOString(),
            'updatedAt' => Carbon::parse($permission->updated_at)->toISOString(),
        ];

        return response()->json([
            'message' => 'Permission "' . $permission->name . '" berhasil diperbarui!',
            'permission' => $formattedPermission
        ]);
    }

    /**
     * Hapus permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permissionName = $permission->name;
        $permission->delete();

        return response()->json([
            'message' => 'Permission "' . $permissionName . '" berhasil dihapus!',
        ]);
    }
}