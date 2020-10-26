<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->enum('animal_type', ['cat', 'dog']);
            $table->string('name');
            $table->string('temperament');
            $table->string('alternative_names')->nullable();
            $table->string('life_span')->nullable();
            $table->string('origin')->nullable();
            $table->string('wikipedia_url')->nullable();
            $table->string('country_code')->nullable();
            $table->text('description')->nullable();
            $table->string('favourite')->nullable();
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
        Schema::dropIfExists('breeds');
    }
}
