<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($data);
        return response()->json($category, 201); 
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($data);
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        \Log::info('Categoria a eliminar:', ['category_id' => $category->id]);

        try {
            // Elimina los productos relacionados
            $category->products()->delete();
    
            // Luego elimina la categoría
            $category->delete();
    
            return response()->json(['message' => 'Categoría y productos relacionados eliminados exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar la categoría.', 'details' => $e->getMessage()], 500);
        }
    }
}
