<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Roles del Sistema
        $admin = Role::create(['name' => 'Administrador']); //Administrador del Sistema
        $labor = Role::create(['name' => 'Laboratorio']); //Laboratorio
        $user = Role::create(['name' => 'Usuario']); //Usuario Final

        //Permisos del Sistema
        Permission::create(['name' => 'usuarios'])->syncRoles([$admin]);
        Permission::create(['name' => 'generadorTokensApi'])->syncRoles([$admin, $labor]);

        //usuario
        User::create([
            'name' => 'Oliver Gomez',
            'email' => 'kayserenrique@gmail.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Odennis Quiroz',
            'email' => 'ohaymard@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Laboratorio Clinico Prueba1',
            'email' => 'prueba@pruebas1.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Laboratorio');

        User::create([
            'name' => 'Laboratorio Clinico Prueba2',
            'email' => 'prueba@pruebas2.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Laboratorio');


        User::create([
            'name' => 'Usuario1 Prueba1',
            'email' => 'usuario@pruebas1.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Usuario');

        User::create([
            'name' => 'Usuario2 Prueba2',
            'email' => 'usuario@pruebas2.com',
            'password' => bcrypt('123456789'),
            'email_verified_at' => '2022-02-26 20:48:29'
        ])->assignRole('Usuario');
    }
}
