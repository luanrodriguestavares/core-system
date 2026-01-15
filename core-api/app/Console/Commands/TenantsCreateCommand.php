<?php

namespace App\Console\Commands;

use App\Models\Master\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantsCreateCommand extends Command
{
    protected $signature = 'tenants:create {slug} {--name=} {--domain=} {--manual-db}';
    protected $description = 'Create a tenant in master DB and provision tenant database.';

    public function handle(): int
    {
        $slug = $this->argument('slug');
        $name = $this->option('name') ?? Str::title($slug);
        $domain = $this->option('domain');

        $dbName = 'tenant_' . $slug;
        $dbUser = 'tenant_' . $slug;
        $dbPass = Str::password(24);

        DB::connection('master')->transaction(function () use ($slug, $name, $domain, $dbName, $dbUser, $dbPass) {
            Tenant::on('master')->create([
                'name' => $name,
                'slug' => $slug,
                'domain' => $domain,
                'db_name' => $dbName,
                'db_user' => $dbUser,
                'db_pass' => Crypt::encryptString($dbPass),
                'status' => 'active',
                'plan_id' => 1,
            ]);
        });

        if (!$this->option('manual-db')) {
            $this->createDatabaseAndUser($dbName, $dbUser, $dbPass);
        }

        $this->call('tenants:migrate', ['--tenant' => $slug]);
        $this->seedAdminUser($slug, $dbName, $dbUser, $dbPass);

        $this->info('Tenant created.');

        return Command::SUCCESS;
    }

    private function createDatabaseAndUser(string $dbName, string $dbUser, string $dbPass): void
    {
        $root = DB::connection('master');

        $root->statement("CREATE DATABASE IF NOT EXISTS `$dbName`");
        $root->statement("CREATE USER IF NOT EXISTS '$dbUser'@'%' IDENTIFIED BY '$dbPass'");
        $root->statement("GRANT ALL PRIVILEGES ON `$dbName`.* TO '$dbUser'@'%'");
    }

    private function seedAdminUser(string $slug, string $dbName, string $dbUser, string $dbPass): void
    {
        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'host' => config('database.connections.master.host'),
                'port' => config('database.connections.master.port'),
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
            ],
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');

        DB::connection('tenant')->table('users')->insert([
            'name' => 'Admin ' . Str::title($slug),
            'email' => $slug . '@tenant.local',
            'password' => Hash::make('ChangeMe123!'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
