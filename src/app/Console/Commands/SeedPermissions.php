<?php
namespace Afrittella\BackProject\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Afrittella\BackProject\Models\Role;

class SeedPermissions extends Command
{
    protected $signature = 'back-project:seed-permissions';

    protected $description = 'Seed default permissions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $roles = [
            ['name' => 'administrator'],
            ['name' => 'user'],
        ];

        foreach ($roles as $role):
            Role::create($role);
        endforeach;

        $this->info('Seeding default permissions');
    }
}