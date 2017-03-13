<?php

namespace Afrittella\BackProject\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Menu extends Model
{
    use NodeTrait;

    protected $fillable = ['title', 'name', 'permission', 'description', 'route', 'icon', 'is_active', 'is_protected', 'parent_id'];
}
