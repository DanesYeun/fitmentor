<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\Request;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     * @return User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Handle profile picture upload
        $imagePath = null;
        if (isset($input['profile_picture'])) {
            $imagePath = Storage::disk('public')->put('profile-photos', $input['profile_picture']);
        }

        return User::create([
            'name' => ucwords($input['name']),
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'profile_photo_path' => $imagePath,
            'role' => "student"
        ]);
    }
}
