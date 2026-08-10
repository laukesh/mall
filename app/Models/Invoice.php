<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'invoices';

    protected $guarded = ['id'];

    protected $dates = [
        'invoice_date',
        'billing_period_from',
        'billing_period_to',
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function leaseAgreement()
    {
        return $this->belongsTo(LeaseAgreement::class, 'lease_agreement_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function generatedByUser()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}