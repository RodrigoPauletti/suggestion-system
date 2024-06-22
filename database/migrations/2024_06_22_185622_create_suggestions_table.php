<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\SuggestionStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->text('description');
            $table->integer('votes')->default(0);
            $table->enum('status', [
                SuggestionStatus::PENDING->value,
                SuggestionStatus::APPROVED->value,
                SuggestionStatus::REJECTED->value,
                SuggestionStatus::UNDER_DEVELOPMENT->value,
            ])->default(SuggestionStatus::PENDING->value);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
    }
};
