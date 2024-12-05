<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovementController extends Controller
{
    public function index()
    {
        $movements = Movement::with(['product', 'movementType', 'user'])->get();
    
      
        
        return response()->json($movements);
    }



    public function indexL(Request $request)
    {
        
        $query = Movement::query();

        if ($request->filled('movement_type_id')) {
            $query->where('movement_type_id', $request->movement_type_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('movement_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('movement_date', '<=', $request->end_date);
        }

        $movements = $query->with(['product', 'movementType', 'user'])->get();

        return response()->json($movements);
    }




   public function store(Request $request)
{
    // Validar los datos recibidos
    $data = $request->validate([
        'product_id' => 'required|exists:products,id', // Validar si el producto existe
        'movement_type_id' => 'required|exists:movement_types,movement_type_id', // Validar el tipo de movimiento
        'quantity' => 'required|integer',
        'movement_date' => 'nullable|date_format:Y-m-d H:i:s', // Asegurarse de que la fecha esté en el formato correcto
        'user_id' => 'required|exists:users,id', // Asegurarte de validar el user_id
    ]);

    $movementDate = $data['movement_date'] ?? now();

    // Obtener el producto
    $product = Product::find($data['product_id']);

    if (!$product) {
        return response()->json(['error' => 'Producto no encontrado.'], 404);
    }

    // Actualizar la cantidad del producto
    if ($data['movement_type_id'] == 2) { // Movimiento de entrada
        $product->quantity += $data['quantity'];
    } elseif ($data['movement_type_id'] == 1) { // Movimiento de salida
        if ($product->quantity < $data['quantity']) {
            return response()->json(['error' => 'No hay suficiente stock para la salida.'], 400);
        }
        $product->quantity -= $data['quantity'];
    } else {
        return response()->json(['error' => 'Tipo de movimiento inválido.'], 400);
    }

    $product->save();

    // Crear el movimiento incluyendo el user_id
    $movement = Movement::create([
        'product_id' => $data['product_id'],
        'movement_type_id' => $data['movement_type_id'],
        'quantity' => $data['quantity'],
        'movement_date' => $movementDate,
        'user_id' => $data['user_id'], // Incluyendo el user_id
    ]);

    return response()->json($movement, 201);
}

    public function show(Movement $movement)
    {
        return response()->json($movement->load(['product', 'movementType']));
    }

    public function update(Request $request, Movement $movement)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'movement_type_id' => 'required|exists:movement_types,movement_type_id',
            'quantity' => 'required|integer',
            'movement_date' => 'nullable|date',
        ]);

        $movement->update([
            'product_id' => $data['product_id'],
            'movement_type_id' => $data['movement_type_id'],
            'quantity' => $data['quantity'],
            'movement_date' => $data['movement_date'] ?? $movement->movement_date, // Mantener la fecha original si no se proporciona una nueva
        ]);

        return response()->json($movement);
    }

    public function destroy(Movement $movement)
    {
        $movement->delete();
        return response()->json(['message' => 'Movimiento eliminado exitosamente.']);
    }
}
