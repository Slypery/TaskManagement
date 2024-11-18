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
        Schema::create('manager_task_returns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('manager_task_id')->unsigned();
            $table->text('description');
            $table->json('attachment');
            $table->date('return_date');
            $table->timestamps();

            $table->foreign('manager_task_id', 'manager_task_return_manager_task_id')->references('id')->on('manager_tasks')->onDelete('cascade')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_task_returns');
    }
};
