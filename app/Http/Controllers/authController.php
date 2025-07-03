<?php

namespace App\Http\Controllers;

use App\Models\Age;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\student_workshop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class authController extends Controller
{
    public function register(Request $request)
    {
        $exists = User::where('ci', $request->ci)
            ->where('birthdate', $request->birthdate)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Usuario ya existe'], 409);
        }

        $student = student_workshop::where('ci', $request->ci)
            ->where('birthdate', $request->birthdate)
            ->latest()->first();

        if (!$student) {
            return response()->json(['message' => 'Usuario no existe'], 409);
        }

        $user = User::create([
            'name' => $student->name,
            'email' => $request->email,
            'cellphone' => $request->cellphone,
            'ci' => $student->ci,
            'telephone' => $request->telephone,
            'birthdate' => $student->birthdate,
            'password' => bcrypt($request->password),
            'code' => $student->code_est,
        ]);
        $user->assignRole('student');
        $user->profile()->create([
            'presentation'=>'',
            'video'=>''
        ]);
        $plan= Plan::where('code',$student->code_plan)->first();
        $age = Age::where('active',true)->latest()->first();
        $user->academic_titles()->create([
            'title' => $plan->name,
            'status' => 'En proceso',
            'active' => true,
            'age_id' => $age->id,
            'plan_id' => $plan->id,
        ]);
        Auth::login($user);
        return $this->authenticated( $user);
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
        return $this->authenticated( Auth::user());
    }

    private function authenticated( $user)
    {
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


    public function user(Request $request){

        $user = $request->user()->load('profile');

        $user->setRelation('roles', $user->getRoleNames());

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }
    public function update(Request $request){
        $user = $request->user();

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }
        $user->cellphone = $request->cellphone;
        $user->email = $request->email;
        $user->password= $request->password?bcrypt($request->password):$user->password;
        $user->save();

        $profile = Profile::where('user_id',$user->id)->first();
        $profile->presentation=$request->presentation??'';
        $profile->video=$request->video??'';
        $profile->save();
    }
}
