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
        Schema::table('insights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('summarize_logs');
            $table->string('input_data');
            $table->string('ai_response')->nullable();
            $table->date('created_at')->nullable();
            $table->date('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
