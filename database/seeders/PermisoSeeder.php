<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\User;


class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Crea Rol
        $Rol = new Rol;
            $Rol->nombre = 'Super Administrador'; //Nombre del Rol
            $Rol->slug = 'super-administrador'; //Slug del Rol
            $Rol->nota = 'Acceso inicial de sistema'; //Nota
       $Rol->save();

        //Crea permisos
        $Permisos = new Permiso;
            $Permisos->rol_id = 1; //Nombre del permiso
            $Permisos->caso_id = 1; //Nombre del Caso de Uso
            $Permisos->lee = 1; //Nombre del Caso de Uso
            $Permisos->crea = 1; //Nombre del Caso de Uso
            $Permisos->edita = 1; //Nombre del Caso de Uso
            $Permisos->elimina = 1; //Nombre del Caso de Uso
        $Permisos->save();

        //Creacion de usuario inicial
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'mauro.baquero.soto@gmail.com',
            'password' => Hash::make('12345678'),
            'tipo_id' => 9, 
            'rol_id' => 1,
            'pais_id' => 2,
        ]);  
    }
}
