<?php

namespace App\Livewire;

use App\Models\FocusArea;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\Programschedule;
use App\Models\Exercise;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Http\Request;


class StudentPage extends Component
{
    use WithPagination;

    public $name,$program,$preparation,$execution,$instructor,$goal;
    public $selectedprogram;
    public $selects = [];
    public $selectedItems = [];
    public $sunday_start,$monday_start,$tuesday_start,$wednesday_start,$thursday_start,$friday_start,$saturday_start,$sunday_end,$monday_end,$tuesday_end,$wednesday_end,$thursday_end,$friday_end,$saturday_end;
    public $dropdownVisible = false;
    public $showModal = false;
    public $selectedRecommend;
    public $confirmingEnrollment = false;
    public $selectedProgramId;

    public function render()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        
        $suggestedInstructors = null;
        if (!is_null($profile)) {
            $profile_goals = explode(",", $profile->goal);
            $profile_areas = explode(",", $profile->area);
            $focus_area_ids = FocusArea::whereIn('name', $profile_areas)->pluck('id');
        } else {
            $profile_goals = null;
            $profile_areas = null;
            $focus_area_ids = null;
        }
    
        $profile_level = $profile->level ?? null;
        $suggestedCoaches = [];
        if (!$profile) {
            $recommends = Schedule::where('status', 'Available')->paginate(2);
            $suggestions = null;
            $recommendedClasses = null;
        } else {
            $recommends = Schedule::where('status', 'Available')
                ->where(function ($query) use ($profile_goals, $profile_level) {
                    $query->whereIn('goal', $profile_goals)
                        ->where('level', $profile_level);
                })
                ->orWhere('user_id', function ($query) use ($profile) {
                    $query->select('id')
                        ->from('users')
                        ->where('expertise', $profile->area);
                })
                ->paginate(2);
            
            // Exercise Recommendations
            $suggestions = Exercise::whereIn('focus_area', $focus_area_ids)
                ->paginate(3, ['*'], 'suggestionPage')
                ->through(function ($exercise) use ($profile) {
                    $exerciseDetails = $this->calculateExerciseParameters($exercise, $profile);
                    
                    return [
                        'exercise' => $exercise,
                        'reps' => $exerciseDetails['reps'],
                        'sets' => $exerciseDetails['sets'],
                        'intensity' => $exerciseDetails['intensity'],
                        'focus_area_name' => $exercise->focusArea->name
                    ];
                });

                $recommendedClasses = Schedule::where('status', 'Available')
                ->where(function ($query) use ($profile_goals, $profile_level) {
                    $query->whereIn('goal', $profile_goals)
                        ->where('level', $profile_level);
                })
                ->orWhere('user_id', function ($query) use ($profile) {
                    $query->select('id')
                        ->from('users')
                        ->where('expertise', $profile->area);
                })
                ->get();
    
            // Suggested Instructors based on profile
            $suggestedInstructors = User::where('role', 'instructor')
                ->get();

            $suggestedCoaches = User::where('role', 'instructor')
                ->whereHas('specialization', function ($query) use ($profile_goals) {
                    $query->whereIn('goal', $profile_goals);
                })
                ->paginate(2, ['*'], 'coachPage');
        }
        
        $exercises = Programschedule::get();
        return view('livewire.student-page', compact('recommends', 'exercises', 'profile', 'suggestions', 'suggestedCoaches', 'recommendedClasses'));
    }
    public function viewRecommend($recommendId)
    {
        $this->selectedRecommend = Schedule::with(['user', 'student'])->find($recommendId);
        $this->showModal = true;
    }

    public function enrollConfirm($recommendId)
    {
    $this->selectedProgramId = $recommendId;
    $this->confirmingEnrollment = true;
    }


    public function enroll($recommendId)
    {
        $enroll = Schedule::find($recommendId);
            if ($enroll) {
                $enroll->update([
                    'status' => 'Waiting for Approval',
                    'student_id' => auth()->user()->id,
                ]);
            }
        session()->flash('success', 'You have successfully enrolled!');
        $this->confirmingEnrollment = false;
        $this->selectedProgramId = null;
        return $this->refreshPage();
    }
    
    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }
    // calculate exercise
    private function calculateExerciseParameters($exercise, $profile)
    {
        // Goal-based parameter calculation
        $baseReps = 10; 
        $baseSets = 3; 

        // Parse goals if it's a string
        $goals = is_string($profile->goal) ? explode(',', $profile->goal) : $profile->goal;
        
        $primaryGoal = is_array($goals) ? $goals[0] : $goals;

        switch ($primaryGoal) {
            case 'Weight Loss':
                return [
                    'reps' => $baseReps + 2,
                    'sets' => $baseSets + 1,
                    'intensity' => 'High'
                ];
            
            case 'Muscle Gain':
                return [
                    'reps' => $baseReps - 2,
                    'sets' => $baseSets + 2,
                    'intensity' => 'Moderate to High'
                ];
            
            case 'Endurance':
                return [
                    'reps' => $baseReps + 5,
                    'sets' => $baseSets,
                    'intensity' => 'Moderate'
                ];
            
            case 'Flexibility':
                return [
                    'reps' => $baseReps,
                    'sets' => $baseSets - 1,
                    'intensity' => 'Low'
                ];
            
            default:
                return [
                    'reps' => $baseReps,
                    'sets' => $baseSets,
                    'intensity' => 'Moderate'
                ];
        }
    }
    
}
