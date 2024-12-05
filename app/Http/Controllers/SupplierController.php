<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $supplier = Supplier::create($data);
        return response()->json($supplier, 201); 
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }


    public function update(Request $request, Supplier $supplier)
    {
        \Log::info('Update method called for supplier ID: ' . $supplier->id);
    
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);
    
        $supplier->update($data);
    
        return response()->json($supplier);
    }

    
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['message' => 'Proveedor eliminado exitosamente.']);
    }
}
