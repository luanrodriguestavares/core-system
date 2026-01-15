<?php

namespace App\Services;

use App\Models\Master\Tenant;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantConnectionService
{
    public function setTenantContext(Tenant $tenant): void
    {
        $this->configureTenantConnection($tenant);
        $this->setDefaultTenantConnection();

        app()->instance('tenant', $tenant);

        Log::withContext([
            'tenant_id' => $tenant->id,
            'tenant_slug' => $tenant->slug,
        ]);
    }

    public function configureTenantConnection(Tenant $tenant): void
    {
        $password = Crypt::decryptString($tenant->db_pass);

        config([
            'database.connections.tenant' => [
                'driver' => 'mysql',
                'host' => $tenant->db_host ?? config('database.connections.master.host'),
                'port' => $tenant->db_port ?? config('database.connections.master.port'),
                'database' => $tenant->db_name,
                'username' => $tenant->db_user,
                'password' => $password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ],
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    public function setDefaultTenantConnection(): void
    {
        DB::setDefaultConnection('tenant');
    }
}
