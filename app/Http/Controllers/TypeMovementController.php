<?php

namespace App\Http\Controllers;

use App\Models\TypeMovement;
use Illuminate\Http\Request;

class TypeMovementController extends Controller
{
    /**
     * Mostrar una lista de todos los tipos de movimientos.
     */
    public function index()
    {
        $typeMovements = TypeMovement::all();
        return response()->json($typeMovements);
    }

    /**
     * Almacenar un nuevo tipo de movimiento.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeMovement = TypeMovement::create($data);
        return response()->json($typeMovement, 201);
    }

    /**
     * Mostrar un tipo de movimiento específico.
     */
    public function show(TypeMovement $typeMovement)
    {
        return response()->json($typeMovement);
    }

    /**
     * Actualizar un tipo de movimiento específico.
     */
    public function update(Request $request, TypeMovement $typeMovement)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeMovement->update($data);
        return response()->json($typeMovement);
    }

    /**
     * Eliminar un tipo de movimiento específico.
     */
    public function destroy(TypeMovement $typeMovement)
    {
        $typeMovement->delete();
        return response()->json(['message' => 'Tipo de movimiento eliminado exitosamente.']);
    }
}
