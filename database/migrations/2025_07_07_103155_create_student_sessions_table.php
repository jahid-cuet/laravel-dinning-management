<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateStudentSessionsTable extends Migration
  {
      
      public function up()
      {
          Schema::create('student_sessions', function (Blueprint $table) {
              $table->id();
              $table->string('hsc_session')->nullable();$table->string('name')->nullable();
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
          Schema::dropIfExists('student_sessions');
      }
  }
  