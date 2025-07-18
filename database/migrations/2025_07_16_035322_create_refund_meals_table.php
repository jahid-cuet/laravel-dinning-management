<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateRefundMealsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('refund_meals', function (Blueprint $table) {
              $table->id();
              $table->date('meal_date')->nullable();$table->integer('lunch')->nullable();$table->integer('dinner')->nullable();$table->integer('refund_request_id')->nullable();
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
          Schema::dropIfExists('refund_meals');
      }
  }
  