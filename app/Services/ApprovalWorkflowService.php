<?php
// app/Services/ApprovalWorkflowService.php
namespace App\Services;

use App\Models\Request;
use App\Models\ApprovalStep;
use App\Models\RequestApproval;

class ApprovalWorkflowService
{
    public function initiateApprovalProcess(Request $request)
    {
        $workflow = $request->workflow;
        
        if (!$workflow) {
            $workflow = ApprovalWorkflow::where('is_active', true)->first();
            $request->update(['approval_workflow_id' => $workflow->id]);
        }
        
        $firstStep = $workflow->steps()->orderBy('order')->first();
        
        $this->createApprovalRecord($request, $firstStep);
        
        $request->update([
            'status' => 'in_review',
            'current_approval_step_id' => $firstStep->id
        ]);
    }
    
    public function processApproval(Request $request, $action, $comment = null)
    {
        $currentApproval = $request->approvals()
            ->where('status', 'pending')
            ->first();
            
        if (!$currentApproval) {
            throw new \Exception('No pending approval found');
        }
        
        $currentApproval->update([
            'status' => $action,
            'comment' => $comment,
            'action_at' => now(),
            'user_id' => auth()->id()
        ]);
        
        if ($action === 'rejected') {
            $request->update(['status' => 'rejected']);
            return;
        }
        
        $nextStep = $this->getNextStep($currentApproval->approvalStep);
        
        if ($nextStep) {
            $this->createApprovalRecord($request, $nextStep);
            $request->update(['current_approval_step_id' => $nextStep->id]);
        } else {
            $request->update(['status' => 'approved']);
        }
    }
    
    protected function createApprovalRecord(Request $request, ApprovalStep $step)
    {
        RequestApproval::create([
            'request_id' => $request->id,
            'approval_step_id' => $step->id,
            'status' => 'pending'
        ]);
    }
    
    protected function getNextStep(ApprovalStep $currentStep)
    {
        return ApprovalStep::where('workflow_id', $currentStep->workflow_id)
            ->where('order', '>', $currentStep->order)
            ->orderBy('order')
            ->first();
    }
}