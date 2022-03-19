<?php

namespace App\Enums;

use App\Jobs\AdminCreateActivityJob;
use App\Jobs\UserCreateActivityJob;
use App\Jobs\MeetingRecordJoinedActivityJob;
use App\Jobs\ScheduleShareActivityJob;
use App\Jobs\MessageSentActivityJob;
use App\Jobs\MeetingPlaceCreateActivityJob;
use App\Jobs\DepartmentCreateActivityJob;
use App\Jobs\ProgressCreateActivityJob;

class Activity
{
  const ACTIVITY_JOBS = [
    // $routeName => $jobName
    'meetingRecord.store' => MeetingRecordJoinedActivityJob::class,
    'schedule.store' => ScheduleShareActivityJob::class,
    'chatMessage.store' => MessageSentActivityJob::class,
    // 'blogReport.store' => BlogReportActivityJob::class,
    // 'chatReport.store' => ChatReportActivityJob::class,
    'admin.user.store' => UserCreateActivityJob::class,
    'admin.admin.store' => AdminCreateActivityJob::class,
    'admin.meetingPlace.store' => MeetingPlaceCreateActivityJob::class,
    'admin.department.store' => DepartmentCreateActivityJob::class,
    'admin.progress.store' => ProgressCreateActivityJob::class,
  ];
}
