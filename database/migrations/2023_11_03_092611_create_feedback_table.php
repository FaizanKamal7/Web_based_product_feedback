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
        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("title");
            $table->longText("description")->nullable();
            $table->uuid("feedback_category_id");
            $table->uuid("user_id");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("feedback_category_id")->references("id")->on("feedback_categories")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
