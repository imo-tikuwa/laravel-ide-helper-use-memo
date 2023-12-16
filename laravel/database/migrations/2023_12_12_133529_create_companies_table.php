<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->comment('会社');
            $table->bigIncrements('id')->comment('会社ID');
            $table->foreignId('user_id')->comment('ユーザーID')->constrained('users')->onDelete('cascade');
            $table->integer('col1')->comment('カラム1');
            $table->integer('col2')->nullable()->comment('カラム2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
