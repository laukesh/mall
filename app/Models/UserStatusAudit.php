<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatusAudit extends Model
{
    protected $table = 'user_status_audits';

    protected $fillable = [
        'user_id',
        'field',
        'old_value',
        'new_value',
        'changed_by',
    ];
}
