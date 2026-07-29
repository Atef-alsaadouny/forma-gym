<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->after('is_available');
            $table->unsignedTinyInteger('experience_years')->nullable()->after('specialization');
            $table->decimal('rating', 3, 2)->nullable()->after('experience_years');
            $table->string('profile_photo_path')->nullable()->after('bio');
            $table->timestamp('joined_at')->nullable()->after('profile_photo_path');
            $table->text('notes')->nullable()->after('joined_at');
            $table->string('gender', 10)->nullable()->after('notes');
            $table->date('date_of_birth')->nullable()->after('gender');

            $table->index('status');
            $table->index('specialization');
        });
    }

    public function down(): void
    {
        Schema::table('trainers', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'experience_years',
                'rating',
                'profile_photo_path',
                'joined_at',
                'notes',
                'gender',
                'date_of_birth',
            ]);
        });
    }
};
