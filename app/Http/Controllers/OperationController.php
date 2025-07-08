<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class OperationController extends Controller
{
     /**
     * Display a listing of the resource (or fetch data for table).
     * Ini adalah endpoint API untuk mengambil semua data Tindakan, mirip dengan fetchData di UserController.
     */
    public function fetchData() // Diubah dari 'index' ke 'fetchData' untuk konsistensi API
    {
        // Memuat semua Tindakan dan memetakannya untuk respons JSON yang terstruktur
        $operations = Operation::all()->map(function ($operation) {
            return [
                'id' => $operation->id,
                'name' => $operation->name,
                // Tambahkan properti lain yang ingin Anda kirim ke frontend
            ];
        });

        return response()->json($operations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',    
                'description' => 'nullable|string',    
            ]);

            // Optional: Tambahkan created_by jika Anda menggunakan Auth
            if (auth()->check()) {
                $validatedData['created_by'] = auth()->user()->name;
            }

            $operation = Operation::create($validatedData);
            return response()->json($operation, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan Tindakan: ' . $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding untuk mengambil Tindakan.
     */
    public function show(Operation $operation) // Kembali ke Route Model Binding
    {
        // Objek $operation sudah otomatis dimuat oleh Laravel.
        // Format respons sesuai dengan apa yang diharapkan frontend untuk modal edit.
        return response()->json([
            'id' => $operation->id,
            'name' => $operation->name,
            'description' => $operation->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operation $operation) // Menggunakan Route Model Binding
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
            $operation->update($validatedData); // <--- INI BARIS KRITIS YANG SEBELUMNYA MUNGKIN TERKOMENTARI ATAU TIDAK LENGKAP

            return response()->json($operation); // Mengembalikan objek Tindakan yang diupdate
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui Tindakan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation) // Menggunakan Route Model Binding
    {
        try {
            // Jika Anda menggunakan SoftDeletes di model Student, ini hanya akan mengisi kolom 'deleted_at'.
            // Untuk menghapus permanen (force delete) jika SoftDeletes aktif, gunakan $student->forceDelete();
            $operation->delete();

            return response()->json(['message' => 'Operation berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus Tindakan: ' . $e->getMessage()], 500);
        }
    }
}
