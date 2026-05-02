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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->mediumText('description');
            $table->string('location');
            $table->enum('type', ['Full-Time', 'Remote', 'Contract', 'Hybrid'])->default('Full-Time');
            $table->string('salary');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignUuid('company_id')->constrained('companies')->onDelete('restrict');
            $table->foreignUuid('category_id')->constrained('job_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
