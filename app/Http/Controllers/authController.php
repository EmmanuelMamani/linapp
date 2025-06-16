<?php

namespace App\Http\Controllers;

use App\Models\student_workshop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->assignRole('student');
        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first()
            ]
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        return response()->json([
            'message' => 'Login exitoso',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->getRoleNames()->first()
            ]
        ]);
    }

    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function register_postulant(Request $request){
        $student = student_workshop::where('ci',$request->ci)
                    ->where('code_est',$request->code_est)
                    ->where('birthday',$request->birtday)
                    ->first();
        if($student){
            $user = User::create([
                'name' => $student->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'ci'=>$student->ci,
                'code_est'=>$student->code_est,
                'birthday'=>$student->birthday,
                'cellphone'=>$request->cellphone,
                'telephone'=>$request->telephone,
            ]);

            $user->assignRole('student');
            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Usuario registrado exitosamente',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'ci' => $user->ci,
                    'code_est' => $user->code_est,
                    'birthday' => $user->birthday,
                    'cellphone' => $user->cellphone,
                    'telephone' => $user->telephone,
                    'role' => $user->getRoleNames()->first()
                ]
            ]);
        }else{
            return response()->json(['Postulante no encontrado'], 404);
        }
    }
}
