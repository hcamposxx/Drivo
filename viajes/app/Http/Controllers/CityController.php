<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\CityRoute;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has('name')){
            $data = City::where('active',"=",1)
            ->orderBy('name','asc')
            ->pluck('name');
        }else{
            $data = City::select('id','name as text','short_name')
            ->where('active',"=",1)
            ->orderBy('name','asc')
            ->get();
        }

        return response()->json(array("results" => $data));
    }

    public function getDestinations($id){
        $cityRoutes = CityRoute::where('origin_city_id', $id)->get();
        //En caso de error
        if($cityRoutes->isEmpty()){
            return response()->json(['message'=>'No existen rutas desde la ciudad de origen'],404);
        }

        $destinationCities = $cityRoutes->map(function($cityRoute){

            return[
                'id'=>$cityRoute->destinationCity->id,
                'text'=>$cityRoute->destinationCity->name,
                'short_name'=>$cityRoute->destinationCity->short_name
            ];

        });

        return response()->json(array("results" => $destinationCities));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
