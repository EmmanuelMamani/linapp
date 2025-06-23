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
        profile::create(['user_id'=>$user->id,'presentation'=>'','video'=>'']);

        //Institution
        institution::create(['name'=>'Universidad Mayor de San Simón']);

        //Unit
        unit::create(['name'=>'Facultad de Ciencias Economicas','institution_id'=>1]);

        //plan
        plan::create(['name'=>'LICENCIATURA EN CONTADURIA PUBLICA','code'=>'089801','unit_id'=>1]);

        //gestion
        age::create(['name'=>'2025','period'=>'1','active'=>true]);

        //academic mode
        academic_mode::create(['name'=>'Proyecto']);
        academic_mode::create(['name'=>'Diplomado']);
        academic_mode::create(['name'=>'Adscripcion']);
        academic_mode::create(['name'=>'Taller']);

        //level academic
        academic_level::create(['name'=>'Tecnico medio']);
        academic_level::create(['name'=>'Tecnico superior']);
        academic_level::create(['name'=>'Licenciatura']);
        academic_level::create(['name'=>'Ingenieria']);
        academic_level::create(['name'=>'Postgrado']);
        academic_level::create(['name'=>'Maestria']);
        academic_level::create(['name'=>'Especialidad']);
        academic_level::create(['name'=>'Doctorado']);


    }
}
