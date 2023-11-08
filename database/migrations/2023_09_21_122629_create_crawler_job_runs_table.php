<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('crawler_job_runs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crawlsite_id'); // Foreign key
            $table->longText('output')->nullable(); 
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('crawlsite_id')
                ->references('id')
                ->on('crawlsites')
                ->onDelete('cascade'); // Adjust this based on your needs
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawler_job_runs');
    }
};
