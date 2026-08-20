<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $progressTables = [
            'feasibility_studies' => 'status',
            'design_packages' => 'status',
            'drawings' => 'drawing_status',
            'mobilization_plans' => 'status',
            'purchase_requisitions' => 'approval_status',
            'purchase_orders' => 'status',
            'material_issue_requests' => 'approval_status',
            'documents' => 'approval_status',
        ];

        foreach ($progressTables as $table => $afterColumn) {
            if (Schema::hasTable($table) && ! Schema::hasColumn($table, 'progress_percentage')) {
                Schema::table($table, function (Blueprint $table) use ($afterColumn) {
                    if (Schema::hasColumn($table->getTable(), $afterColumn)) {
                        $table->decimal('progress_percentage', 5, 2)->default(0)->after($afterColumn);
                    } else {
                        $table->decimal('progress_percentage', 5, 2)->default(0);
                    }
                });
            }
        }

        if (! Schema::hasTable('incidents')) {
            Schema::create('incidents', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('project_id');
                $table->string('incident_number', 30)->unique();
                $table->string('incident_type', 50);
                $table->date('incident_date');
                $table->text('description');
                $table->string('status', 50)->default('Open');
                $table->decimal('progress_percentage', 5, 2)->default(0);
                $table->unsignedBigInteger('reported_by')->nullable();
                $table->string('location', 255)->nullable();
                $table->text('immediate_action')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');

        $progressTables = [
            'feasibility_studies',
            'design_packages',
            'drawings',
            'mobilization_plans',
            'purchase_requisitions',
            'purchase_orders',
            'material_issue_requests',
            'documents',
        ];

        foreach ($progressTables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'progress_percentage')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('progress_percentage');
                });
            }
        }
    }
};
