<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id('movement_id');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->unsignedBigInteger('movement_type_id'); // Tipo de dato correcto
            $table->foreign('movement_type_id')
                  ->references('movement_type_id')
                  ->on('movement_types')
                  ->onDelete('restrict');
            $table->integer('quantity');
            $table->unsignedBigInteger('user_id'); // Clave foránea para usuario
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade'); // Opcional: elimina el movimiento si se elimina el usuario
            $table->timestamp('movement_date')->useCurrent();
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('movements');
    }
};
