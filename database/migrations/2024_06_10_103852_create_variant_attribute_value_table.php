<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('variant_attribute_value', function (Blueprint $table) {
            $table->foreignId('attribute_value_id')->constrained('attribute_values')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('variants')->cascadeOnUpdate()->cascadeOnDelete();

            $table->primary(['attribute_value_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_attribute_value');
    }
};
