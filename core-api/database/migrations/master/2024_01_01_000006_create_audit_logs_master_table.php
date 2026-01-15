<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('master')->create('audit_logs_master', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_user_id')->nullable();
            $table->string('action');
            $table->json('metadata_json')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('master')->dropIfExists('audit_logs_master');
    }
};
