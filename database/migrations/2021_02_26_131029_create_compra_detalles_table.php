<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->nullable()->constrained('compras');
            $table->foreignId('producto_lote_id')->nullable()->constrained('producto_lotes');
            $table->decimal('precio', 10, 2)->nullable()->default(0);
            $table->decimal('descuento', 10, 2)->nullable()->default(0);
            $table->decimal('cantidad', 10, 2)->nullable()->default(0);
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
        Schema::dropIfExists('compra_detalles');
    }
}
