<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;


class Admin extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guard = 'admin'; // Specifies this model uses the 'admin' authentication guard
    protected $guarded = []; // Allows all attributes to be mass assignable (opposite of $fillable)

     protected $guard_name = 'admin';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Get all unique permission groups from the permissions table.
    public static function getpermissionGroups(){
        $permission_groups = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();
        return $permission_groups;
    }

    // Get permissions by a specific group name.
    public static function getpermissionByGroupName($group_name){
        $permissions = DB::table('permissions')
                            ->select('name','id')
                            ->where('group_name',$group_name)
                            ->get();
                            return $permissions;
    }

    // Check if a given role has all the permissions in a collection.
    public static function roleHasPermissions($role,$permissions){
            $hasPermission = true;
            foreach ($permissions as $key => $permission) {
               if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
               }
               return $hasPermission;
            }
    }
}