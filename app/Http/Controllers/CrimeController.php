<?php

namespace App\Http\Controllers;

use App\Models\Crime;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CrimeController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $crimes = Crime::select('id', 'name', 'type', 'urgency')->get();
        dd($crimes);
        return response()->json($crimes); 
    }

    /**
     *
     * @param  \Illuminate\Http\Request 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'type' => 'required|in:Bullying Verbal,Bullying Fisik,Pelecehan Seksual Verbal,Pelecehan Seksual Fisik',
                'urgency' => 'required|integer|min:1|max:3',
            ]);

            $crime = Crime::create($validatedData);

            return response()->json($crime, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     *
     * @param  \Illuminate\Http\Request 
     * @param  int 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $crime = Crime::findOrFail($id); 
            $validatedData = $request->validate([
                'name' => 'required|string|max:100',
                'type' => 'required|in:Bullying Verbal,Bullying Fisik,Pelecehan Seksual Verbal,Pelecehan Seksual Fisik',
                'urgency' => 'required|integer|min:1|max:3',
            ]);

            $crime->update($validatedData);
            return response()->json($crime); 
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 
     *
     * @param  int 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $crime = Crime::findOrFail($id); 
            $crime->delete(); 

            return response()->json(['message' => 'Data berhasil dihapus.'], 200); 
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Data tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
