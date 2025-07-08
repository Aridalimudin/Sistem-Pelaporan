<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule; // Pastikan ini diimport

class StudentController extends Controller
{
    /**
     * Display a listing of the resource (or fetch data for table).
     * Ini adalah endpoint API untuk mengambil semua data siswa, mirip dengan fetchData di UserController.
     */
    public function fetchData() // Diubah dari 'index' ke 'fetchData' untuk konsistensi API
    {
        // Memuat semua siswa dan memetakannya untuk respons JSON yang terstruktur
        $students = Student::all()->map(function ($student) {
            return [
                'id' => $student->id,
                'nis' => $student->nis,
                'name' => $student->name,
                'email' => $student->email,
                'classroom' => $student->classroom,
                // Tambahkan properti lain yang ingin Anda kirim ke frontend
            ];
        });

        return response()->json($students);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nis' => 'required|string|max:255|unique:students,nis',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:students,email',
                'classroom' => 'required|string|max:255',
            ]);

            // Optional: Tambahkan created_by jika Anda menggunakan Auth
            if (auth()->check()) {
                $validatedData['created_by'] = auth()->user()->id;
            }

            $student = Student::create($validatedData);
            return response()->json($student, 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity for validation errors
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan siswa: ' . $e->getMessage()], 500); // 500 Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding untuk mengambil siswa.
     */
    public function show(Student $student) // Kembali ke Route Model Binding
    {
        // Objek $student sudah otomatis dimuat oleh Laravel.
        // Format respons sesuai dengan apa yang diharapkan frontend untuk modal edit.
        return response()->json([
            'id' => $student->id,
            'nis' => $student->nis,
            'name' => $student->name,
            'email' => $student->email,
            'classroom' => $student->classroom,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student) // Menggunakan Route Model Binding
    {
        try {
            $validatedData = $request->validate([
                'nis' => ['required', 'string', 'max:255', Rule::unique('students', 'nis')->ignore($student->id)],
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
                'classroom' => 'required|string|max:255',
            ]);

            // Optional: Tambahkan updated_by jika Anda menggunakan Auth
            if (auth()->check()) {
                $validatedData['updated_by'] = auth()->user()->id;
            }

            // Lanjutkan dengan operasi update
            $student->update($validatedData); // <--- INI BARIS KRITIS YANG SEBELUMNYA MUNGKIN TERKOMENTARI ATAU TIDAK LENGKAP

            return response()->json($student); // Mengembalikan objek siswa yang diupdate
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui siswa: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student) // Menggunakan Route Model Binding
    {
        try {
            // Jika Anda menggunakan SoftDeletes di model Student, ini hanya akan mengisi kolom 'deleted_at'.
            // Untuk menghapus permanen (force delete) jika SoftDeletes aktif, gunakan $student->forceDelete();
            $student->delete();

            return response()->json(['message' => 'Siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus siswa: ' . $e->getMessage()], 500);
        }
    }
}