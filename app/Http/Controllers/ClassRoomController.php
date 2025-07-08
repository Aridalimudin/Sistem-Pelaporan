<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource (or fetch data for table).
     * Ini adalah endpoint API untuk mengambil semua data Kelas, mirip dengan fetchData di UserController.
     */
    public function fetchData() // Diubah dari 'index' ke 'fetchData' untuk konsistensi API
    {
        // Memuat semua Kelas dan memetakannya untuk respons JSON yang terstruktur
        $classRooms = ClassRoom::all()->map(function ($classRoom) {
            return [
                'id' => $classRoom->id,
                'name' => $classRoom->name,
                // Tambahkan properti lain yang ingin Anda kirim ke frontend
            ];
        });

        return response()->json($classRooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',    
            ]);

            // Optional: Tambahkan created_by jika Anda menggunakan Auth
            if (auth()->check()) {
                $validatedData['created_by'] = auth()->user()->name;
            }

            $classRoom = ClassRoom::create($validatedData);
            return response()->json($classRoom, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan Kelas: ' . $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding untuk mengambil Kelas.
     */
    public function show(ClassRoom $classRoom) // Kembali ke Route Model Binding
    {
        // Objek $classRoom sudah otomatis dimuat oleh Laravel.
        // Format respons sesuai dengan apa yang diharapkan frontend untuk modal edit.
        return response()->json([
            'id' => $classRoom->id,
            'name' => $classRoom->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassRoom $classRoom) // Menggunakan Route Model Binding
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Optional: Tambahkan updated_by jika Anda menggunakan Auth
            if (auth()->check()) {
                $validatedData['updated_by'] = auth()->user()->name;
            }

            // Lanjutkan dengan operasi update
            $classRoom->update($validatedData); // <--- INI BARIS KRITIS YANG SEBELUMNYA MUNGKIN TERKOMENTARI ATAU TIDAK LENGKAP

            return response()->json($classRoom); // Mengembalikan objek Kelas yang diupdate
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui Kelas: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassRoom $classRoom) // Menggunakan Route Model Binding
    {
        try {
            // Jika Anda menggunakan SoftDeletes di model Student, ini hanya akan mengisi kolom 'deleted_at'.
            // Untuk menghapus permanen (force delete) jika SoftDeletes aktif, gunakan $student->forceDelete();
            $classRoom->delete();

            return response()->json(['message' => 'Kelas berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus Kelas: ' . $e->getMessage()], 500);
        }
    }
}
