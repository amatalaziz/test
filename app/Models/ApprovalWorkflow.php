<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalWorkflow extends Model
{
    use HasFactory;
            
        public function steps()
        {
            return $this->hasMany(ApprovalStep::class)->orderBy('order');
        }

        public function requests()
        {
            return $this->hasMany(Request::class);
        }
}
