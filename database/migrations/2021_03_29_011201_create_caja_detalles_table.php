<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCajaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('caja_id')->nullable()->constrained('cajas');
            $table->string('detalle')->nullable();
            $table->decimal('monto', 10, 2)->nullable()->default(0);
            $table->smallInteger('tipo')->nullable()->default(1);
            $table->foreignId('venta_id')->nullable()->constrained('ventas');
            $table->foreignId('compra_id')->nullable()->constrained('compras');
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
        Schema::dropIfExists('caja_detalles');
    }
}
