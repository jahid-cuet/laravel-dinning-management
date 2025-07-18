<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateMonthlyMealDetailsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('monthly_meal_details', function (Blueprint $table) {
              $table->id();
              $table->string('gender')->nullable();$table->integer('user_id')->nullable();
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
          Schema::dropIfExists('monthly_meal_details');
      }
  }
  