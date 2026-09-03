<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('high_risk_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('freedom_wall_id');
            $table->string('sent_by')->nullable();   // admin name who triggered
            $table->json('recipients');              // array of emails
            $table->timestamp('sent_at');
            $table->timestamps();

            $table->foreign('freedom_wall_id')
                  ->references('id')->on('freedom_walls')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('high_risk_alerts');
    }
};
