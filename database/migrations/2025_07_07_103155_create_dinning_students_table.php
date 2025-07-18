<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateDinningStudentsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('dinning_students', function (Blueprint $table) {
              $table->id();
              $table->string('avatar')->nullable();$table->string('student_id')->unique();$table->string('name')->nullable();$table->string('txid')->nullable();$table->integer('total_meals')->nullable();$table->date('from')->nullable();$table->date('to')->nullable();$table->string('paid_status')->nullable();$table->integer('user_id')->nullable();$table->integer('dinning_month_id')->nullable();$table->integer('department_id')->nullable();$table->integer('student_session_id')->nullable();
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
          Schema::dropIfExists('dinning_students');
      }
  }
  