<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratorio_id')->nullable()->constrained('laboratorios');
            $table->foreignId('linea_id')->nullable()->constrained('lineas');
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('logo')->nullable()->default('../img/producto_default.png');
            $table->smallInteger('estado')->nullable()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
