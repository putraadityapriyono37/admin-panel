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
        Schema::create('admin_microsite', function (Blueprint $table) {
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete();
            $table->foreignId('microsite_id')->constrained()->cascadeOnDelete();
            $table->primary(['admin_id', 'microsite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_microsite');
    }
};
