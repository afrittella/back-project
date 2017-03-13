<?php
namespace Afrittella\BackProject\Models;

use Spatie\Permission\Models\Permission as OriginalPermission;

class Permission extends OriginalPermission
{
    protected $fillable = ['name', 'updated_at', 'created_at'];
}