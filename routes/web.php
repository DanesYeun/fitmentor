<?php

use App\Livewire\StudentProgress;
use Illuminate\Support\Facades\Route;
use App\Livewire\InstructorManager;
use App\Livewire\ProgramManager;
use App\Livewire\ProgramPage;
use App\Livewire\StaffManager;
use App\Livewire\StudentManager;
use App\Livewire\StudentProgram;
use App\Livewire\InstructorSchedule;
use App\Livewire\Pending;
use App\Livewire\Approved;
use App\Livewire\Available;
use App\Livewire\StudentProfiling;
use App\Livewire\Staff;
use App\Livewire\StaffProgram;
use App\Livewire\ExercisePage;
use App\Livewire\Records;
use App\Livewire\Instructor;
use App\Livewire\StaffEdit;
use App\Livewire\InstructorEdit;
use App\Livewire\ExerciseEdit;
use App\Livewire\ProgramEdit;
use App\Livewire\ExerciseMaker;
use App\Livewire\ProgramMaker;
use App\Livewire\RecommendPage;
use App\Livewire\AdminProgram;
use App\Livewire\FocusAreaPage;
use App\Livewire\StaffProfiling;
use App\Livewire\FocusAreaEdit;
use App\Livewire\FocusAreaMaker;
use App\Livewire\ScheduleEdit;

use App\Models\User;

Route::get('/', function () {
    return view('livewire.welcome-page');
})->middleware('guest')->name('home');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/instructor-manager', InstructorManager::class)->name('instructor-manager');
    Route::get('/instructor-schedule', InstructorSchedule::class)->name('instructor-schedule');
    Route::get('/pending', Pending::class)->name('pending');
    Route::get('/approved', Approved::class)->name('approved');
    Route::get('/available', Available::class)->name('available');
    Route::get('/program', ProgramPage::class)->name('program');
    Route::get('/admin-program', AdminProgram::class)->name('admin-program');
    Route::get('/staff-manager', StaffManager::class)->name('staff-manager');
    Route::get('/student-manager', StudentManager::class)->name('student-manager');
    Route::get('/student-program', StudentProgram::class)->name('student-program');
    Route::get('/studednt-progress', StudentProgress::class)->name('student-progress');
    Route::get('/profiling', StudentProfiling::class)->name('profiling');
    Route::get('/staff', Staff::class)->name('staff');
    Route::get('/staff-program', StaffProgram::class)->name('staff-program');
    Route::get('/records', Records::class)->name('records');
    Route::get('/instructor', Instructor::class)->name('instructor');
    Route::get('/staff/edit/{user}', StaffEdit::class)->name('staff.edit');
    Route::get('/instructor/edit/{user}', InstructorEdit::class)->name('instructor.edit');
    Route::get('/exercise/edit/{exercise}', ExerciseEdit::class)->name('exercise.edit');
    Route::get('/program/edit/{program}', ProgramEdit::class)->name('program.edit');
    Route::get('/exercise-manager', ExercisePage::class)->name('exercise');
    Route::get('/focus-area', FocusAreaPage::class)->name('focus-area');
    Route::get('/focus-area/edit/{id}', FocusAreaEdit::class)->name('focus.area.edit');
    Route::get('/focus-area-maker', FocusAreaMaker::class)->name('focus-area-maker');
    Route::get('/exercise-maker', ExerciseMaker::class)->name('exercise-maker');
    Route::get('/program-maker', ProgramMaker::class)->name('program-maker');
    Route::get('/recommendations', RecommendPage::class)->name('recommend');
    Route::get('/staff-profiling', StaffProfiling::class)->name('staff-profiling');
    Route::get('/schedule/edit/{id}', ScheduleEdit::class)->name('schedule.edit');
    Route::get('/instructor-profiling', StaffProfiling::class)->name('instructor-profiling');

});
