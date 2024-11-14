<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public $table = 'entidades';
  public $tableTelefonos = 'telefonos';
  public $tableEmails = 'emails';
  public $tablePaises = 'paises';
  public $tableCiudades = 'ciudades';
  public $tablePostales = 'codigospostales';
  public $tableDirecciones = 'direcciones';

  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // Entidades
    Schema::create($this->table, function (Blueprint $table) {
      $table->id();
      $table->tinyInteger('tipoEntidad')->default(1); //  ['perfil', 'cliente', 'vendedor', 'cli-ven']
      $table->string('razonSocial')->nullable()->default(null);
      $table->string('website')->nullable()->default(null);
      $table->string('titulo')->nullable()->default(null);
      $table->string('nombres')->nullable()->default(null);
      $table->string('apellidos')->nullable()->default(null);
      $table->boolean('is_active')->default(true);
      $table->date('aniversario')->nullable()->default(null);
      $table->tinyInteger('sexo')->nullable()->default(1); // ['masculino', 'femenino', 'otro']
      $table->timestamps();
    });

    // telefonos
    Schema::create($this->tableTelefonos, function (Blueprint $table) {
      $table->id();
      $table->foreignId('entidad_id')->constrained('entidades')->onDelete('cascade');
      $table->string('numero', 20); // Adjust length as needed
      $table->tinyInteger('tipo')->nullable(); // Ej. casa, trabajo, etc.
      $table->timestamps();
    });

    // emails
    Schema::create(
      $this->tableEmails,
      function (Blueprint $table) {
        $table->id();
        $table->foreignId('entidad_id')->constrained('entidades')->onDelete('cascade');
        $table->string('mail', 100); // Adjust length as needed
        $table->tinyInteger('tipo')->nullable(); // Ej. casa, trabajo, etc.
        $table->timestamps();
      }
    );

    // Paises
    Schema::create($this->tablePaises, function (Blueprint $table) {
      $table->id();
      $table->string('nombre', 100)->unique()->nullable();
      $table->timestamps();
    });

    // Ciudades
    Schema::create($this->tableCiudades, function (Blueprint $table) {
      $table->id();
      $table->string('nombre', 100)->nullable();
      $table->string('region', 100)->nullable(); // Campo de región
      $table->foreignId('pais_id')->constrained('paises')->onDelete('cascade')->onUpdate('cascade');
      $table->timestamps();
    });

    // Codigos Postales
    Schema::create($this->tablePostales, function (Blueprint $table) {
      $table->id();
      $table->string('cp', 5)->nullable()->default(0)->unique(); // Código postal
      $table->foreignId('ciudad_id')->constrained('ciudades')->onDelete('cascade')->onUpdate('cascade');
      $table->timestamps();
    });

    // Direcciones
    Schema::create($this->tableDirecciones, function (Blueprint $table) {
      $table->id();
      $table->foreignId('entidad_id')->constrained('entidades')->onDelete('cascade');
      $table->string('numero', 10)->nullable()->default(null);
      $table->string('calle', 100)->nullable();
      $table->foreignId('cp_id')->constrained('codigospostales')->onDelete('cascade')->onUpdate('cascade');
      $table->tinyInteger('tipo')->nullable(); // Ej. casa, trabajo, etc.
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {

    Schema::dropIfExists($this->tableDirecciones);
    Schema::dropIfExists($this->tablePostales);
    Schema::dropIfExists($this->tableCiudades);
    Schema::dropIfExists($this->tablePaises);
    Schema::dropIfExists($this->tableTelefonos);
    Schema::dropIfExists($this->tableEmails);
    Schema::dropIfExists($this->table);
  }
};
