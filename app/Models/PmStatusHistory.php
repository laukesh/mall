<?php

namespace App\Models;

class PmStatusHistory extends ErpModel
{
    protected $table = 'pm_status_histories';

    // Pre-Construction
    public const ENTITY_LAND = 'land';
    public const ENTITY_FEASIBILITY = 'feasibility_study';
    public const ENTITY_DESIGN_PACKAGE = 'design_package';
    public const ENTITY_DRAWING = 'drawing';
    public const ENTITY_RFI = 'rfi';

    // Project Execution
    public const ENTITY_PROJECT = 'project';
    public const ENTITY_WORK_PACKAGE = 'work_package';
    public const ENTITY_CONTRACTOR = 'contractor';
    public const ENTITY_CONTRACTOR_BILL = 'contractor_bill';
    public const ENTITY_MOBILIZATION = 'mobilization_plan';

    // Supply Chain
    public const ENTITY_PURCHASE_REQUISITION = 'purchase_requisition';
    public const ENTITY_PURCHASE_ORDER = 'purchase_order';
    public const ENTITY_MATERIAL_ISSUE_REQUEST = 'material_issue_request';

    // Operations
    public const ENTITY_DOCUMENT = 'document';
    public const ENTITY_INCIDENT = 'incident';
    public const ENTITY_SAFETY_INSPECTION = 'safety_inspection';
    public const ENTITY_PAYMENT = 'payment';

    public static function entityTypeLabels(): array
    {
        return [
            self::ENTITY_LAND => 'Land Acquisition',
            self::ENTITY_FEASIBILITY => 'Feasibility Study',
            self::ENTITY_DESIGN_PACKAGE => 'Design Package',
            self::ENTITY_DRAWING => 'Drawing',
            self::ENTITY_RFI => 'RFI',
            self::ENTITY_PROJECT => 'Project',
            self::ENTITY_WORK_PACKAGE => 'Work Package',
            self::ENTITY_CONTRACTOR => 'Contractor',
            self::ENTITY_CONTRACTOR_BILL => 'Contractor Bill',
            self::ENTITY_MOBILIZATION => 'Mobilization Plan',
            self::ENTITY_PURCHASE_REQUISITION => 'Purchase Requisition',
            self::ENTITY_PURCHASE_ORDER => 'Purchase Order',
            self::ENTITY_MATERIAL_ISSUE_REQUEST => 'Material Issue Request',
            self::ENTITY_DOCUMENT => 'Document',
            self::ENTITY_INCIDENT => 'HSE Incident',
            self::ENTITY_SAFETY_INSPECTION => 'Safety Inspection',
            self::ENTITY_PAYMENT => 'Payment',
        ];
    }

    public static function forEntity(string $entityType, int $entityId)
    {
        return static::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->orderByDesc('changed_at');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
