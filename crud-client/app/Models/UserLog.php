<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'field_changed',
        'old_value',
        'new_value',
        'performed_at',
    ];
    
}
