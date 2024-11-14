<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $table = "categorias";

    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 32)->unique();
            $table->string("slug", 32);
            $table->unsignedBigInteger('parent_id')->nullable(); // Add this line
            $table->timestamps();
        });

        Schema::create("categoriables", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("categoriable_id");
            $table->string("categoriable_type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("categoriables");
        Schema::dropIfExists($this->table);
    }
};
