<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('freedom_walls', function (Blueprint $table) {
            if (! Schema::hasColumn('freedom_walls', 'student_email')) {
                $table->string('student_email')->nullable()->after('postName');
            }
        });
    }

    public function down(): void
    {
        Schema::table('freedom_walls', function (Blueprint $table) {
            $table->dropColumn('student_email');
        });
    }
};
