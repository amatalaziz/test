<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestApprovalsTable extends Migration
{
    public function up()
    {
        Schema::create('request_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->onDelete('cascade');
            $table->foreignId('approval_step_id')->constrained('approval_steps')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('comment')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->timestamps();
            
            // فهارس إضافية لتحسين الأداء
            $table->index(['request_id', 'approval_step_id']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_approvals');
    }
}