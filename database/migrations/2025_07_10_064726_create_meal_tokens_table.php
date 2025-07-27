<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateMealTokensTable extends Migration
  {
      
      public function up()
      {
          Schema::create('meal_tokens', function (Blueprint $table) {
              $table->id();
              $table->string('token_number')->unique();$table->string('time_type')->nullable();$table->date('dinning_date')->nullable();$table->time('dinning_time')->nullable();$table->integer('user_id')->nullable();
              $table->integer('order')->default(0);
              $table->boolean('is_active')->default(true);
              $table->unsignedBigInteger('created_by')->nullable();
              $table->unsignedBigInteger('updated_by')->nullable();
              $table->timestamps();
              $table->softDeletes();
          });
      }

      public function down()
      {
          Schema::dropIfExists('meal_tokens');
      }
  }
  