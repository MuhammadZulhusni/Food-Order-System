<?php

namespace App\Imports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;

class PermissionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if the permission already exists based on name and guard_name
        $permission = Permission::where('name', $row[0])
                                ->where('guard_name', $row[1])
                                ->first();

        // Only create a new model if a matching permission does not exist.
        if (is_null($permission)) {
            return new Permission([
               'name'     => $row[0],
               'guard_name'    => $row[1],
               'group_name' => $row[2],
            ]);
        }

        // Return null to skip this row if the permission already exists.
        return null;
    }
}