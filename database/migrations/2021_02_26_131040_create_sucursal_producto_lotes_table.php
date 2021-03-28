<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalProductoLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal_producto_lotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursals');
            $table->foreignId('producto_lote_id')->nullable()->constrained('producto_lotes');
            $table->decimal('precio', 10, 2)->nullable()->default(0);
            $table->decimal('precio_mayor', 10, 2)->nullable()->default(0);
            $table->decimal('descuento', 10, 2)->nullable()->default(0);
            $table->decimal('stock', 10, 2)->nullable()->default(0);
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
        Schema::dropIfExists('sucursal_producto_lotes');
    }
}
