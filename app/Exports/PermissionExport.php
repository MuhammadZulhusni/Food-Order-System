<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;

class PermissionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // This method retrieves a collection of permissions from the database.
    public function collection()
    {
        // It selects the 'name', 'guard_name', and 'group_name' columns.
        return Permission::select('name','guard_name','group_name')->get();
    }
}