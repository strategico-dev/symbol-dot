<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesFunnelThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_funnel_themes', function (Blueprint $table) {
            $table->id();
            $table->string('cover')->default('/uploads/sales-funnels/covers/default.png');
            $table->string('background_image')->default('/uploads/sales-funnels/backgrounds/default.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_funnel_themes');
    }
}
