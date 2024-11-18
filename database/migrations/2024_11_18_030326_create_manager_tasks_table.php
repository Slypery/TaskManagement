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
        Schema::create('manager_tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->unsigned();
            $table->bigInteger('assigned_to')->unsigned()->nullable();
            $table->string('title', 70);
            $table->text('description');
            $table->json('attachment');
            $table->date('due_date');
            $table->enum('status', ['not viewed', 'viewed', 'in progress', 'done']);
            $table->timestamps();

            $table->foreign('created_by', 'manager_task_director_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('no action');
            $table->foreign('assigned_to', 'manager_task_manager_id')->references('id')->on('users')->onDelete('set null')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manager_tasks');
    }
};
