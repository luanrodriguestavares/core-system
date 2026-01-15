<?php

namespace App\Console\Commands;

use App\Models\Master\Tenant;
use App\Services\TenantConnectionService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantsMigrateCommand extends Command
{
    protected $signature = 'tenants:migrate {--tenant=}';
    protected $description = 'Run tenant migrations for all active tenants or a specific tenant.';

    public function handle(): int
    {
        $query = Tenant::on('master')->where('status', 'active');

        if ($tenantSlug = $this->option('tenant')) {
            $query->where('slug', $tenantSlug);
        }

        $tenants = $query->get();

        foreach ($tenants as $tenant) {
            app(TenantConnectionService::class)->setTenantContext($tenant);

            Artisan::call('migrate', [
                '--path' => 'database/migrations/tenant',
                '--database' => 'tenant',
                '--force' => true,
            ]);

            $this->info("Migrated tenant {$tenant->slug}");
        }

        return Command::SUCCESS;
    }
}
