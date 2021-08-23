<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\AdminRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Contracts\Repositories\BlogCommentRepositoryInterface;
use App\Repositories\BlogCommentRepository;
use App\Contracts\Repositories\BlogImageRepositoryInterface;
use App\Repositories\BlogImageRepository;
use App\Contracts\Repositories\BlogLikeRepositoryInterface;
use App\Repositories\BlogLikeRepository;
use App\Contracts\Repositories\BlogRepositoryInterface;
use App\Repositories\BlogRepository;
use App\Contracts\Repositories\BlogTagRepositoryInterface;
use App\Repositories\BlogTagRepository;
use App\Contracts\Repositories\ChatMessageImageRepositoryInterface;
use App\Repositories\ChatMessageImageRepository;
use App\Contracts\Repositories\ChatMessageReadRepositoryInterface;
use App\Repositories\ChatMessageReadRepository;
use App\Contracts\Repositories\ChatMessageRepositoryInterface;
use App\Repositories\ChatMessageRepository;
use App\Contracts\Repositories\ChatRoomRepositoryInterface;
use App\Repositories\ChatRoomRepository;
use App\Contracts\Repositories\ChatRoomShareRepositoryInterface;
use App\Repositories\ChatRoomShareRepository;
use App\Contracts\Repositories\DepartmentRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Contracts\Repositories\DocumentFileRepositoryInterface;
use App\Repositories\DocumentFileRepository;
use App\Contracts\Repositories\DocumentFolderRepositoryInterface;
use App\Repositories\DocumentFolderRepository;
use App\Contracts\Repositories\DocumentShareRepositoryInterface;
use App\Repositories\DocumentShareRepository;
use App\Contracts\Repositories\FacialExpressionRepositoryInterface;
use App\Repositories\FacialExpressionRepository;
use App\Contracts\Repositories\LastReadRepositoryInterface;
use App\Repositories\LastReadRepository;
use App\Contracts\Repositories\MeetingDecisionRepositoryInterface;
use App\Repositories\MeetingDecisionRepository;
use App\Contracts\Repositories\MeetingMemberRepositoryInterface;
use App\Repositories\MeetingMemberRepository;
use App\Contracts\Repositories\MeetingPlaceRepositoryInterface;
use App\Repositories\MeetingPlaceRepository;
use App\Contracts\Repositories\MeetingRecordRepositoryInterface;
use App\Repositories\MeetingRecordRepository;
use App\Contracts\Repositories\PriorityRepositoryInterface;
use App\Repositories\PriorityRepository;
use App\Contracts\Repositories\ProgressRepositoryInterface;
use App\Repositories\ProgressRepository;
use App\Contracts\Repositories\ReactionRepositoryInterface;
use App\Repositories\ReactionRepository;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Repositories\RoleRepository;
use App\Contracts\Repositories\ScheduleRepositoryInterface;
use App\Repositories\ScheduleRepository;
use App\Contracts\Repositories\ScheduleShareRepositoryInterface;
use App\Repositories\ScheduleShareRepository;
use App\Contracts\Repositories\TagRepositoryInterface;
use App\Repositories\TagRepository;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
    $this->app->bind(BlogCommentRepositoryInterface::class, BlogCommentRepository::class);
    $this->app->bind(BlogImageRepositoryInterface::class, BlogImageRepository::class);
    $this->app->bind(BlogLikeRepositoryInterface::class, BlogLikeRepository::class);
    $this->app->bind(BlogRepositoryInterface::class, BlogRepository::class);
    $this->app->bind(BlogTagRepositoryInterface::class, BlogTagRepository::class);
    $this->app->bind(ChatMessageImageRepositoryInterface::class, ChatMessageImageRepository::class);
    $this->app->bind(ChatMessageReadRepositoryInterface::class, ChatMessageReadRepository::class);
    $this->app->bind(ChatMessageRepositoryInterface::class, ChatMessageRepository::class);
    $this->app->bind(ChatRoomRepositoryInterface::class, ChatRoomRepository::class);
    $this->app->bind(ChatRoomShareRepositoryInterface::class, ChatRoomShareRepository::class);
    $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
    $this->app->bind(DocumentFileRepositoryInterface::class, DocumentFileRepository::class);
    $this->app->bind(DocumentFolderRepositoryInterface::class, DocumentFolderRepository::class);
    $this->app->bind(DocumentShareRepositoryInterface::class, DocumentShareRepository::class);
    $this->app->bind(FacialExpressionRepositoryInterface::class, FacialExpressionRepository::class);
    $this->app->bind(LastReadRepositoryInterface::class, LastReadRepository::class);
    $this->app->bind(MeetingDecisionRepositoryInterface::class, MeetingDecisionRepository::class);
    $this->app->bind(MeetingMemberRepositoryInterface::class, MeetingMemberRepository::class);
    $this->app->bind(MeetingPlaceRepositoryInterface::class, MeetingPlaceRepository::class);
    $this->app->bind(MeetingRecordRepositoryInterface::class, MeetingRecordRepository::class);
    $this->app->bind(PriorityRepositoryInterface::class, PriorityRepository::class);
    $this->app->bind(ProgressRepositoryInterface::class, ProgressRepository::class);
    $this->app->bind(ReactionRepositoryInterface::class, ReactionRepository::class);
    $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
    $this->app->bind(ScheduleShareRepositoryInterface::class, ScheduleShareRepository::class);
    $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    //
  }
}
