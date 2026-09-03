<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── users table extra columns ────────────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'roles')) {
                $table->string('roles')->default('user')->after('password');
            }
            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('roles');
            }
            if (! Schema::hasColumn('users', 'program')) {
                $table->string('program')->nullable()->after('name');
            }
            if (! Schema::hasColumn('users', 'year_level')) {
                $table->string('year_level')->nullable()->after('program');
            }
        });

        // ── freedom_walls extra columns ──────────────────────────────────
        Schema::table('freedom_walls', function (Blueprint $table) {
            if (! Schema::hasColumn('freedom_walls', 'program')) {
                $table->string('program')->nullable()->after('post');
            }
            if (! Schema::hasColumn('freedom_walls', 'year_level')) {
                $table->string('year_level')->nullable()->after('program');
            }
            if (! Schema::hasColumn('freedom_walls', 'sentiment')) {
                $table->string('sentiment')->nullable()->after('year_level');
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_sentiment')) {
                $table->string('ai_sentiment')->nullable();
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_emotion_category')) {
                $table->string('ai_emotion_category')->nullable();
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_confidence')) {
                $table->integer('ai_confidence')->nullable();
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_counselor_note')) {
                $table->text('ai_counselor_note')->nullable();
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_flagged')) {
                $table->boolean('ai_flagged')->default(false);
            }
            if (! Schema::hasColumn('freedom_walls', 'ai_raw')) {
                $table->text('ai_raw')->nullable();
            }
        });

        // ── services: description column ─────────────────────────────────
        Schema::table('services', function (Blueprint $table) {
            if (! Schema::hasColumn('services', 'description')) {
                $table->text('description')->nullable()->after('name');
            }
            if (! Schema::hasColumn('services', 'consultations_id')) {
                $table->string('consultations_id')->nullable()->after('description');
            }
        });

        // ── otp_verifications table ──────────────────────────────────────
        if (! Schema::hasTable('otp_verifications')) {
            Schema::create('otp_verifications', function (Blueprint $table) {
                $table->id();
                $table->string('email');
                $table->string('otp');         // stored as SHA-256 hash
                $table->dateTime('expires_at');
                $table->boolean('used')->default(false);
                $table->integer('attempts')->default(0);
                $table->dateTime('sent_at')->nullable();
                $table->timestamps();
            });
        }

        // ── system_settings table ────────────────────────────────────────
        if (! Schema::hasTable('system_settings')) {
            Schema::create('system_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Seed default settings
            $defaults = [
                ['key' => 'maintenance_mode',      'value' => '0'],
                ['key' => 'high_risk_contact_url', 'value' => ''],
                ['key' => 'deactivation_date',     'value' => ''],
                ['key' => 'deactivation_done',     'value' => '0'],
            ];
            foreach ($defaults as $row) {
                DB::table('system_settings')->insertOrIgnore(array_merge($row, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // ── sentiment_keywords table ─────────────────────────────────────
        if (! Schema::hasTable('sentiment_keywords')) {
            Schema::create('sentiment_keywords', function (Blueprint $table) {
                $table->id();
                $table->string('word');
                $table->string('category');   // high_risk | negative | positive
                $table->timestamps();
            });
        }

        // ── support_resources table ──────────────────────────────────────
        if (! Schema::hasTable('support_resources')) {
            Schema::create('support_resources', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('url')->nullable();
                $table->string('type')->nullable();
                $table->integer('slots')->nullable();
                $table->timestamps();
            });
        }

        // ── links table ──────────────────────────────────────────────────
        if (! Schema::hasTable('links')) {
            Schema::create('links', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('url');
                $table->string('icon')->nullable();
                $table->string('category')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Intentionally minimal — do not drop tables in rollback
        Schema::dropIfExists('otp_verifications');
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('sentiment_keywords');
        Schema::dropIfExists('support_resources');
        Schema::dropIfExists('links');
    }
};
