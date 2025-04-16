<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalStep extends Model
{
    use HasFactory;


    public function workflow()
{
    return $this->belongsTo(ApprovalWorkflow::class);
}

public function requestApprovals()
{
    return $this->hasMany(RequestApproval::class);
}

public function role()
{
    return $this->belongsTo(Role::class);
}
}


