<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    // Mostrar todas las ciudades
    public function index()
    {
        $cities = City::paginate(20);
        return view('admin.cities.index', compact('cities'));
    }

    // Mostrar formulario para crear nueva ciudad
    public function create()
    {
        return view('admin.cities.create');
    }

    // Guardar nueva ciudad
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities',
            'short_name' => 'required|string|max:10|unique:cities',
        ]);

        //revisar la secuencia SQL para agregar ciudades 
        City::create([
            'name' => $request->name,
            'short_name' => $request->short_name
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'Ciudad creada correctamente');
    }

    // Mostrar formulario para editar ciudad
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities.edit', compact('city'));
    }

    // Actualizar ciudad
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $id,
            'short_name' => 'required|string|max:10|unique:cities,short_name,' . $id,
        ]);

        $city->update([
            'name' => $request->name,
            'short_name' => $request->short_name,
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', 'Ciudad actualizada correctamente');
    }

    // Eliminar ciudad
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
            
            return redirect()->route('admin.cities.index')
                ->with('success', 'Ciudad eliminada correctamente');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.cities.index')
                ->with('error', 'Error al eliminar la ciudad. Puede estar en uso.');
        }
    }
}