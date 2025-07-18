<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateRefundRequestsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('refund_requests', function (Blueprint $table) {
              $table->id();
              $table->string('status')->nullable();$table->integer('total_meal')->nullable();$table->integer('total_amount')->nullable();$table->integer('dinning_student_id')->nullable();
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
          Schema::dropIfExists('refund_requests');
      }
  }
  