<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SQLite does not support ALTER COLUMN to change nullability.
     * We recreate the table with the slot column as nullable (INTEGER DEFAULT NULL).
     * All existing data is preserved.
     */
    public function up(): void
    {
        // Copy existing rows
        $rows = DB::table('support_resources')->get();

        // Drop and recreate with slot nullable
        DB::statement('DROP TABLE IF EXISTS support_resources_old');
        DB::statement('ALTER TABLE support_resources RENAME TO support_resources_old');

        DB::statement('
            CREATE TABLE support_resources (
                id              INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                title           VARCHAR(255) NOT NULL,
                description     TEXT,
                hover_text      TEXT,
                url             VARCHAR(255),
                icon            VARCHAR(255),
                color_class     VARCHAR(255),
                is_active       INTEGER DEFAULT 1,
                display_order   INTEGER DEFAULT 0,
                created_at      DATETIME,
                updated_at      DATETIME,
                slot            INTEGER DEFAULT NULL,
                type            VARCHAR(255)
            )
        ');

        // Restore data
        foreach ($rows as $row) {
            DB::table('support_resources')->insert([
                'id'            => $row->id,
                'title'         => $row->title,
                'description'   => $row->description ?? null,
                'hover_text'    => $row->hover_text ?? null,
                'url'           => $row->url ?? null,
                'icon'          => $row->icon ?? null,
                'color_class'   => $row->color_class ?? null,
                'is_active'     => $row->is_active ?? 1,
                'display_order' => $row->display_order ?? 0,
                'created_at'    => $row->created_at,
                'updated_at'    => $row->updated_at,
                'slot'          => $row->slot ?? null,
                'type'          => $row->type ?? null,
            ]);
        }

        DB::statement('DROP TABLE support_resources_old');
    }

    public function down(): void
    {
        // Reverse: make slot NOT NULL with default 0
        DB::statement('ALTER TABLE support_resources RENAME TO support_resources_new');
        DB::statement('
            CREATE TABLE support_resources (
                id              INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                title           VARCHAR(255) NOT NULL,
                description     TEXT,
                hover_text      TEXT,
                url             VARCHAR(255),
                icon            VARCHAR(255),
                color_class     VARCHAR(255),
                is_active       INTEGER DEFAULT 1,
                display_order   INTEGER DEFAULT 0,
                created_at      DATETIME,
                updated_at      DATETIME,
                slot            INTEGER NOT NULL DEFAULT 0,
                type            VARCHAR(255)
            )
        ');

        foreach (DB::table('support_resources_new')->get() as $row) {
            DB::table('support_resources')->insert([
                'id'            => $row->id,
                'title'         => $row->title,
                'description'   => $row->description ?? null,
                'hover_text'    => $row->hover_text ?? null,
                'url'           => $row->url ?? null,
                'icon'          => $row->icon ?? null,
                'color_class'   => $row->color_class ?? null,
                'is_active'     => $row->is_active ?? 1,
                'display_order' => $row->display_order ?? 0,
                'created_at'    => $row->created_at,
                'updated_at'    => $row->updated_at,
                'slot'          => $row->slot ?? 0,
                'type'          => $row->type ?? null,
            ]);
        }

        DB::statement('DROP TABLE support_resources_new');
    }
};
