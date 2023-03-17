<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mockery\Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function rand;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    private $rolesNames = ['user', 'admin','seller'];
    private $permissions=[
        'user'=>[
            'read plantes',
            'read categories',
            'update profile',
        ],
        'seller'=>[
            'update profile',
            'read plantes',
            'read categories',
            'create plantes',
            'update plantes',
            'delete plantes',
            'restore plantes'
        ],
        'admin'=>[
            'read plantes',
            'read categories',
            'create plantes',
            'update plantes',
            'delete plantes',
            'create categories',
            'update categories',
            'delete categories',
            'read users',
            'delete users',
            'add roles',
            'delete roles',
            'update roles',
            'add permissions',
            'delete permissions',
            'update permissions',
            'create users',
            'update users',
            'update profile',
        ]
    ];
    private $roles;

    /**
     * @param string[] $roles
     * @param \string[][] $permissions
     */
    public function __construct()
    {
        parent::__construct();
       foreach ($this->rolesNames as $role){
           $role_created = Role::firstOrCreate(['name'=>$role]);
           foreach ($this->permissions[$role] as $permissionName){
               $permission = Permission::firstOrCreate(['name'=>$permissionName,'guard_name' => 'api']);
               $role_created->givePermissionTo($permission);
           }
            $this->roles[] = $role_created;
       }
    }


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make("azer1234"), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


}
