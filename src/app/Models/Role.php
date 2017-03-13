<?php
namespace Afrittella\BackProject\Models;

use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    protected $fillable = ['name', 'updated_at', 'created_at'];
}