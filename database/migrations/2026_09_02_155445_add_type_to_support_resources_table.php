<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('support_resources', function (Blueprint $table) {
            if (! Schema::hasColumn('support_resources', 'type')) {
                $table->string('type')->nullable()->after('url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('support_resources', function (Blueprint $table) {
            if (Schema::hasColumn('support_resources', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
