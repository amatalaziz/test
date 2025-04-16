<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Seeder;
use App\Models\Request;
use App\Models\Approval;

class ApprovalSeeder extends Seeder
{
    public function run()
    {
        $requests = Request::all();
        $approvers = User::where('role', 'admin')->take(3)->get();
        
        foreach ($requests as $request) {
            foreach ($approvers as $index => $approver) {
                Approval::create([
                    'request_id' => $request->id,
                    'user_id' => $approver->id,
                    'level' => $index + 1,
                    'status' => $index === 0 ? 'pending' : 'pending'
                ]);
            }
        }
    }}