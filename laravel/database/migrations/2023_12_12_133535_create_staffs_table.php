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
        Schema::create('staffs', function (Blueprint $table) {
            $table->comment('スタッフ');
            $table->bigIncrements('id')->comment('スタッフID');

            // ↓not foreign key. just a relation column.
            // $table->bigInteger('company_id')->comment('会社ID');

            // ↓foreign key.
            $table->foreignId('company_id')->comment('会社ID')->constrained('companies')->onDelete('cascade');

            $table->string('col1')->comment('カラム1');
            $table->string('col2')->nullable()->comment('カラム2');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
