<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $table = "posts";
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->string("titulo", 64)->nullable()->default(null);
            $table->string("slug", 64)->nullable()->default(null);
            $table->text("contenido")->nullable()->default(null);
            $table->enum("estado", ['sin_publicar', 'editando', 'en_revision', 'publicado'])->default('sin_publicar'); // Use enum
            $table->boolean("is_active")->nullable()->default(true);
            $table->string("image_path")->nullable()->default("null");
            $table->unsignedBigInteger("categoria_id"); // Define the foreign key column
            $table->foreign('categoria_id') // Add the foreign key constraint
                ->references('id') // Reference the 'id' column in the 'categorias' table
                ->on('categorias') // Specify the related table
                ->onDelete('cascade'); // Define the behavior on delete (cascade)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
