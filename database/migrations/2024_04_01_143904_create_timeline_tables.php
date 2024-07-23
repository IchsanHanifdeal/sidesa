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
        Schema::create('grup', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_desa');
            $table->unsignedBigInteger('id_creator');

            $table->string('group_name');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('cascade');
            $table->foreign('id_creator')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('anggota_grup', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_grup');
            $table->unsignedBigInteger('id_user');
            $table->enum('status', ["Pending", "Accepted", "Rejected"])->default("Pending");
            $table->timestamps();

            $table->foreign('id_grup')->references('id')->on('grup')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['Umum', 'Grup']);
            $table->unsignedBigInteger('id_grup')->nullable();
            $table->unsignedBigInteger('id_desa');
            $table->unsignedBigInteger('id_creator');
            $table->text('content');
            $table->string('photo')->nullable();
            $table->timestamps();

            $table->boolean('for_sale')->default(false);
            $table->decimal('harga', 10, 2)->nullable();
            $table->integer('stock')->nullable();

            $table->foreign('id_grup')->references('id')->on('grup')->onDelete('set null');
            $table->foreign('id_desa')->references('id')->on('desa')->onDelete('cascade');
            $table->foreign('id_creator')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('post_like', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_post')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_creator');
            $table->text('content');
            $table->timestamps();

            $table->foreign('id_post')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('id_creator')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_user');
            $table->integer('jumlah');
            $table->string('id_order')->nullable();
            $table->string('snap_token')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('status')->default('Unpaid'); // Unpaid, Paid
            $table->timestamps();

            $table->foreign('id_post')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar');
        Schema::dropIfExists('post_like');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('anggota_grup');
        Schema::dropIfExists('grup');
    }
};
