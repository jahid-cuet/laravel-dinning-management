<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateDinningMonthsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('dinning_months', function (Blueprint $table) {
              $table->id();
              $table->string('title')->nullable();$table->integer('meal_rate')->nullable();$table->date('from')->nullable();$table->date('to')->nullable();$table->integer('user_id')->nullable();$table->integer('dinning_student_id')->nullable();
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
          Schema::dropIfExists('dinning_months');
      }
  }
  