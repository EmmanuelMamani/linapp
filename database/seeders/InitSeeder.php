<?php

namespace Database\Seeders;

use App\Models\academic_level;
use App\Models\academic_mode;
use App\Models\age;
use App\Models\institution;
use App\Models\plan;
use App\Models\profile;
use App\Models\unit;
use App\Models\User;
use App\Models\Workshop_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //roles
        Role::create(['name' => 'student']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'admin_university']);

        //User
        $user=User::create(['name'=>'Jimena',
                        'email'=>'jime@gmail.com',
                        'cellphone'=>'79797979',
                        'ci'=>'75757575',
                        'telephone'=>'79797979',
                        'photo'=>'',
                        'birthdate'=>'2000-1-1',
                        'code'=>'741258',
                        'password'=>bcrypt('79793177')]);
        $user->assignRole('admin_university');

        //profile
        Profile::create(['user_id'=>$user->id,'presentation'=>'','video'=>'']);

        //Institution
        Institution::create(['name'=>'Universidad Mayor de San Simón']);

        //Unit
        Unit::create(['name'=>'Facultad de Ciencias Economicas','institution_id'=>1]);

        //plan
        Plan::create(['name'=>'LICENCIATURA EN CONTADURIA PUBLICA','code'=>'089801','unit_id'=>1]);

        //gestion
        Age::create(['name'=>'2025','period'=>'1','active'=>true]);

        //academic mode
        Academic_mode::create(['name'=>'Proyecto']);
        Academic_mode::create(['name'=>'Diplomado']);
        academic_mode::create(['name'=>'Adscripcion']);
        academic_mode::create(['name'=>'Taller']);

        //level academic
        Academic_level::create(['name'=>'Tecnico medio']);
        Academic_level::create(['name'=>'Tecnico superior']);
        Academic_level::create(['name'=>'Licenciatura']);
        Academic_level::create(['name'=>'Ingenieria']);
        Academic_level::create(['name'=>'Postgrado']);
        Academic_level::create(['name'=>'Maestria']);
        Academic_level::create(['name'=>'Especialidad']);
        Academic_level::create(['name'=>'Doctorado']);

        //workshop types
        Workshop_type::create(['name'=>'Examen de grado']);
        Workshop_type::create(['name'=>'Taller de informatica']);
    }
}
