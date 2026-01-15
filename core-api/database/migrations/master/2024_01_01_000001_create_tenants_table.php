<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('master')->create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable();
            $table->string('db_name');
            $table->string('db_user');
            $table->text('db_pass');
            $table->string('db_host')->nullable();
            $table->integer('db_port')->nullable();
            $table->string('status')->default('active');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('master')->dropIfExists('tenants');
    }
};
