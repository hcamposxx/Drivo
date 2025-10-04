<?php

use App\Http\Controllers\TripController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//ruta HOME
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('register', function () {
    return view('register');
})->name('register');

Route::get('login-google', function () {
    return Socialite::driver('google')->redirect();
})->name('login-google');


Route::get('google-callback', function () {
    $user= Socialite::driver('google')->user();
    $exists = User::where('email',$user->email)->first();
    if($exists && $exists->external_auth != 'google'){
        User::where('email',$user->email)->update([
            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google'
        ]);
    }elseif(!$exists){
        $exists= User::create([

            'name' => $user->name,
            'email' => $user->email,
            'photo' => $user->avatar,
            'external_id' => $user->id,
            'external_auth' => 'google'

        ]);
    }

    Auth::login($exists);
    return redirect(route('home'))->with('mensaje', "Hola,".$user->name);
})->name('google-callback');


Route::post('searchTrip',[TripController::class,'searchTrip'])->name('searchTrip');
//mantener info aunque actulice pagina
Route::get('search/{from}/{to}/{date}/{seats}/{sort}/{verified}',[TripController::class,'search']);

Route::post('register', function(Request $request){

    $exists = User::where('email',$request->get('email'))->first();
    if(!$exists){
        $exists=User::create([

            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
            'external_auth' => 'email'
        ]);

        Auth::login($exists);
        return redirect(route('home'))->with('mensaje', "Hola,".$exists->name);
    }else{
       return redirect(route('register'))->withErrors('Ya existe una cuenta con el correo'.$exists->email); 
    }


})->name('new-account-email');



Route::post('login', function(Request $request){
    $exists = $request->only('email','password');
    if(Auth::attempt($exists)){
        $exists=Auth::user();
        return redirect(route('home'))->with('mensaje', "Hola,".$exists->name);
    }else{
       return redirect(route('login-account-email'))->withErrors('Datos de acceso incorrectos'); 
    }
})->name('login-account-email');

Route::get('offer-seats', function () {
    return view('new-trip');
})->name('offer-seats');


Route::get('history',[TripController::class,'history'])->name('history');
Route::get('history/{id}',[TripController::class,'passengers']);

Route::get('logout', function () {
    Auth::logout();
    return redirect(route('home'));
})->name('logout');