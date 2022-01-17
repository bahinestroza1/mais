<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'documento' => ['required', 'string', 'max:255'],
            // 'nombre' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            // 'centros_id' => ['required', 'string', 'max:255'],
            // 'roles_id' => ['required', 'string', 'max:255'],
            // 'tipos_documentos_id' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $pass = Hash::make("123456789");
        return User::create([
            // 'documento' => $data['documento'],
            // 'nombre' => $data['nombre'],
            // 'email' => $data['email'],
            // 'password' => Hash::make($data['password']),
            // 'centros_id' => $data['centros_id'],
            // 'roles_id' => $data['roles_id'],
            // 'tipos_documentos_id' => $data['tipos_documentos_id'],
            'documento' => '10059439511',
            'nombre' => 'Prueba',
            'email' => 'Prueba@gmail.com',
            'password' => $pass,
            'centros_id' => 1,
            'roles_id' => 1,
            'tipos_documentos_id' => '1',
            
        ]);
    }
}
