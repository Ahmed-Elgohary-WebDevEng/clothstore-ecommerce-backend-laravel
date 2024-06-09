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
        Schema::create('attribute_variant', function (Blueprint $table) {
            $table
                ->foreignId('attribute_id')
                ->constrained('attributes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreignId('variant_id')
                ->constrained('variants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_variant');
    }
};
