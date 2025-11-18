<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CityRoute;
use Illuminate\Http\Request;

class CityRouteController extends Controller
{

     protected $fillable = [
        'origin_city_id',
        'destination_city_id'
    ];

    // Mostrar todas las rutas de una ciudad
    public function index()
    {
        $cities = City::with(['originRoutes.destinationCity'])->get();
        return view('admin.city-routes.index', compact('cities'));
    }

    // Mostrar formulario para asignar destinos a una ciudad
    public function edit($cityId)
    {
        $city = City::findOrFail($cityId);
        $allCities = City::where('id', '!=', $cityId)->get();
        
        // Obtener las ciudades destino ya asignadas
        $assignedDestinations = CityRoute::where('origin_city_id', $cityId)
            ->pluck('destination_city_id')
            ->toArray();
        
        return view('admin.city-routes.edit', compact('city', 'allCities', 'assignedDestinations'));
    }

    // Actualizar las ciudades destino de una ciudad
public function update(Request $request, $cityId)
{
    $request->validate([
        'destinations' => 'nullable|array',
        'destinations.*' => 'exists:cities,id'
    ]);

    $city = City::findOrFail($cityId);
    
    // Eliminar todas las rutas existentes de esta ciudad
    CityRoute::where('origin_city_id', $cityId)->delete();
    
    // Crear las nuevas rutas (CORREGIDO: usar [] en lugar de {})
    if ($request->has('destinations')) {
        foreach ($request->destinations as $destinationId) {
            CityRoute::create([
                'origin_city_id' => $cityId,
                'destination_city_id' => $destinationId
            ]);
        }
    }
    
    return redirect()->route('admin.city-routes.index')
        ->with('success', 'Rutas actualizadas correctamente para ' . $city->name);
}

    // Eliminar una ruta específica
    public function destroy($routeId)
    {
        try {
            $route = CityRoute::findOrFail($routeId);
            $route->delete();
            
            return redirect()->back()
                ->with('success', 'Ruta eliminada correctamente');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la ruta');
        }
    }
}