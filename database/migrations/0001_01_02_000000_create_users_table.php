<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('nik')->nullable()->unique();
            $table->string('no_hp')->nullable()->unique();
            $table->text('alamat')->nullable();
            $table->string('image')->nullable();
            $table->enum('role', ['Admin', 'Warga']);

            $table->decimal('saldo', 10, 2)->default(0);

            $table->unsignedBigInteger('id_desa');
            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('cascade');

            $table->string('password');
            $table->boolean('is_confirmed')->default(false);


            $table->double('lat')->nullable();
            $table->double('long')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
