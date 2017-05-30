<?php namespace Afrittella\BackProject\Console\Commands;

use Afrittella\BackProject\Models\Menu;
use Afrittella\BackProject\Models\Role;
use Afrittella\BackProject\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class SeedDefaultMenus extends Command
{
    protected $signature = 'back-project:seed-menus';

    protected $description = 'Seed default admin-menu';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $nodes = [
        'name' => 'admin-menu',
        'title' => 'Administrator Menu',
        'description' => 'A default menu you can use for back office purposes',
        'route' => null,
        'icon' => null,
        'is_active' => 1,
        'is_protected' => 1,
        'children' => [
            [
            'name' => 'dashboard',
            'permission' => 'backend',
            'title' => 'Dashboard',
            'description' => 'Your dashboard',
            'route' => config('back-project.route_prefix').'/dashboard',
            'icon' => 'fa fa-dashboard',
            'is_active' => 1,
            'is_protected' => 1,
            ],
            [
            'name' => 'auth',
            'title' => 'Authorization',
            'description' => 'Manage Users, Roles and Permissions',
            'route' => null,
            'icon' => 'fa fa-key',
            'is_active' => 1,
            'children' => [
                [
                'name' => 'users',
                'permission' => 'administration',
                'title' => 'Users',
                'description' => 'Manage Users',
                'route' => config('back-project.route_prefix').'/users',
                'icon' => 'fa fa-users',
                'is_active' => 1
                ],
                [
                'name' => 'roles',
                'permission' => 'administration',
                'title' => 'Roles',
                'description' => 'Manage Roles',
                'route' => config('back-project.route_prefix').'/roles',
                'icon' => 'fa fa-group',
                'is_active' => 1
                ],
                [
                'name' => 'permissions',
                'permission' => 'administration',
                'title' => 'Permissions',
                'description' => 'Manage Permissions',
                'route' => config('back-project.route_prefix').'/permissions',
                'icon' => 'fa fa-group',
                'is_active' => 1
                ]
            ]
            ],
            [
            'name' => 'menus',
            'permission' => 'administration',
            'title' => 'Menus',
            'description' => 'Manage menus',
            'route' => config('back-project.route_prefix').'/menus',
            'icon' => 'fa fa-ellipsis-v',
            'is_active' => 1,
            'is_protected' => 1,
            ],
            [
            'name' => 'attachments',
            'permission' => 'backend',
            'title' => 'My Media',
            'description' => 'Manage attachments',
            'route' => config('back-project.route_prefix').'/attachments',
            'icon' => 'fa fa-user-circle-o',
            'is_active' => 1,
            'is_protected' => 1,
            ],
            [
            'name' => 'admin-attachments',
            'permission' => 'administration',
            'title' => 'All Media',
            'description' => 'Manage all user\'s attachments',
            'route' => config('back-project.route_prefix').'/media',
            'icon' => 'fa fa-file-image-o',
            'is_active' => 1,
            'is_protected' => 1,
            ],
        ]
        ];

        // Truncate menu table
        DB::table('menus')->truncate();

        Menu::create($nodes);

        $menus = DB::table('menus')->select('permission')->where('permission', '<>', '')->groupBy('permission')->get();

        $role = Role::where('name', '=', 'administrator')->first();
        $user_role = Role::where('name', '=', 'user')->first();

        foreach ($menus as $menu):

          if (!empty($menu->permission)) {
                $permission = Permission::firstOrCreate(['name' => $menu->permission]);

                if (!$role->hasPermissionTo($menu->permission)) {
                    $role->givePermissionTo($menu->permission);
                }

                if ($menu->permission == 'backend' and !$role->hasPermissionTo($menu->permission)) {
                    $user_role->givePermissionTo($menu->permission);
                }
            }
        endforeach;

        $this->info('Seeding admin-menu'.'...');
    }
}
