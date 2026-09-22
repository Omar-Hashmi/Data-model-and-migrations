<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EmailTemplate;
use App\Models\FollowUpReminder;
use App\Models\Lead;
use App\Models\PipelineStage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $pipelineStages = PipelineStage::query()
            ->withCount('leads')
            ->orderBy('position')
            ->get();

        $leads = Lead::query()
            ->select(['id', 'pipeline_stage_id', 'first_name', 'last_name', 'email', 'source', 'estimated_value', 'next_follow_up_at'])
            ->with('pipelineStage:id,name,color')
            ->withCount(['followUpReminders as pending_reminders_count' => fn ($query) => $query->where('status', 'pending')])
            ->latest()
            ->limit(6)
            ->get();

        $upcomingReminders = FollowUpReminder::query()
            ->select(['id', 'lead_id', 'contact_id', 'title', 'channel', 'due_at'])
            ->with(['lead:id,first_name,last_name', 'contact:id,first_name,last_name'])
            ->where('status', 'pending')
            ->orderBy('due_at')
            ->limit(4)
            ->get();

        $recentActivities = ActivityLog::query()
            ->select(['id', 'lead_id', 'contact_id', 'activity_type', 'subject', 'occurred_at'])
            ->with(['lead:id,first_name,last_name', 'contact:id,first_name,last_name'])
            ->latest('occurred_at')
            ->limit(4)
            ->get();

        return view('dashboard', [
            'pipelineStages' => $pipelineStages,
            'leads' => $leads,
            'upcomingReminders' => $upcomingReminders,
            'recentActivities' => $recentActivities,
            'leadCount' => Lead::query()->count(),
            'pipelineValue' => Lead::query()->sum('estimated_value'),
            'pendingReminderCount' => FollowUpReminder::query()->where('status', 'pending')->count(),
            'activeTemplateCount' => EmailTemplate::query()->where('is_active', true)->count(),
        ]);
    }
}
