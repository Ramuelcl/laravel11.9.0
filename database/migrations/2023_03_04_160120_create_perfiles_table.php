<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  protected $table = 'perfiles';
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::disableForeignKeyConstraints();

    Schema::create($this->table, function (Blueprint $table) {
      $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate()->primary();
      $table->unsignedTinyInteger('edad');
      $table->unsignedTinyInteger('id_profesion')->nullable()->default(null);
      $table->longText('biografia')->default(null)->charset('utf8');
      $table->string('website', 128)->default(null)->charset('utf8');
      $table->timestamps();
      $table->softDeletes();
    });

    Schema::enableForeignKeyConstraints();
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists($this->table);
  }
};
