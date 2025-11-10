<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trip; 
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalTrips = Trip::count();
        $recentTrips = Trip::with(['departureCity', 'arrivalCity', 'driver'])
        ->latest()
        ->take(10)
        ->get();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalTrips', 'recentTrips', 'recentUsers'));
    }
    
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }
    
    public function trips()
    {
        $trips = Trip::with('driver')->paginate(20);
        return view('admin.trips', compact('trips'));
    }

    public function deleteUser($id)
    {
        try{
            $user = User::findOrFail($id);
            
            if($user->id === auth()->id()){
                return redirect()->route('admin.users')
                ->with('error','No puedes eliminar este usuario');
                
            }
            $user->delete();
            return redirect()->route('admin.users')
                ->with('success','Usuario eliminado correctamente');

    } catch (\Exception $e) {
        return redirect()->route('admin.users')
            ->with('error','Error al eliminar el usuario');
    }
    }

    public function deleteTrip($id)
    {
        try{
            $trip = Trip::findOrFail($id);
            $trip->delete();
            
            return redirect()->route('admin.trips')
                ->with('success','Viaje eliminado correctamente');
        
            } catch (\Exception $e) {
            return redirect()->route('admin.trips')
                ->with('error','Error al eliminar el viaje');
        }

    }

}
