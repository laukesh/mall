<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contractors') && ! Schema::hasColumn('contractors', 'parent_contractor_id')) {
            Schema::table('contractors', function (Blueprint $table) {
                $table->unsignedBigInteger('parent_contractor_id')->nullable()->after('contractor_type');
                $table->unsignedBigInteger('user_id')->nullable()->after('parent_contractor_id');
            });
        }

        if (Schema::hasTable('lands') && ! Schema::hasColumn('lands', 'project_id')) {
            Schema::table('lands', function (Blueprint $table) {
                $table->unsignedBigInteger('project_id')->nullable()->after('longitude');
            });
        }

        if (! Schema::hasTable('pm_status_histories')) {
            Schema::create('pm_status_histories', function (Blueprint $table) {
                $table->id();
                $table->string('entity_type', 50);
                $table->unsignedBigInteger('entity_id');
                $table->string('field_name', 50)->default('status');
                $table->string('old_value', 100)->nullable();
                $table->string('new_value', 100);
                $table->unsignedBigInteger('changed_by')->nullable();
                $table->text('remarks')->nullable();
                $table->dateTime('changed_at');
                $table->timestamps();

                $table->index(['entity_type', 'entity_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pm_status_histories');

        if (Schema::hasTable('contractors')) {
            Schema::table('contractors', function (Blueprint $table) {
                if (Schema::hasColumn('contractors', 'parent_contractor_id')) {
                    $table->dropColumn('parent_contractor_id');
                }
                if (Schema::hasColumn('contractors', 'user_id')) {
                    $table->dropColumn('user_id');
                }
            });
        }

        if (Schema::hasTable('lands') && Schema::hasColumn('lands', 'project_id')) {
            Schema::table('lands', function (Blueprint $table) {
                $table->dropColumn('project_id');
            });
        }
    }
};
