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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('loyalty_months')->nullable()->after('description');
            $table->json('installment_options')->nullable()->after('loyalty_months');
            $table->string('duration_unit', 20)->default('month')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('loyalty_months');
            $table->dropColumn('installment_options');
            $table->enum('duration_unit', ['month'])->change();
        });
    }
};
