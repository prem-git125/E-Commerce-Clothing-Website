<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_varients', function (Blueprint $table) {
            $table->dropColumn('stock'); // remove column
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_varients', function (Blueprint $table) {
            $table->integer('stock')->after('size_id'); // restore column
        });

        Schema::table('products', function (Blueprint $table) {
            $table->float('price')->after('description'); // restore column
        });
    }
};
