<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        try {
            // Update name and email
            $user->fill($request->validated());

            // Reset email verification if the email has changed
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $this->handleAvatarUpload($user, $request->file('avatar'));
            }

            // Save the updated user information
            $user->save();

            // Log the avatar path for debugging
            \Log::info('Avatar Path in Database:', ['user_id' => $user->id, 'avatar' => $user->avatar]);

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Illuminate\Database\QueryException $e) {
            // Log query exception details
            \Log::error('Query Exception during profile update.', [
                'query' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'error' => $e->getMessage(),
            ]);

            // Return with a user-friendly error message
            return back()->withErrors(['error' => 'An error occurred while updating the profile. Please try again.']);
        } catch (\Exception $e) {
            // Log unexpected errors
            \Log::error('Unexpected error during profile update.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Validate the password for account deletion
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        try {
            // Log out the user
            Auth::logout();

            // Delete the avatar file if it exists
            $this->deleteAvatarIfExists($user);

            // Delete the user account
            $user->delete();

            // Invalidate and regenerate the session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            \Log::info('User account deleted successfully.', ['user_id' => $user->id]);

            return Redirect::to('/');
        } catch (\Exception $e) {
            // Log error details
            \Log::error('Error occurred while deleting account.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors(['error' => 'An error occurred while deleting your account. Please try again.']);
        }
    }

    /**
     * Handle avatar upload and update the user's avatar path.
     *
     * @param $user
     * @param \Illuminate\Http\UploadedFile $avatar
     * @return void
     */
    private function handleAvatarUpload($user, $avatar): void
    {
        try {
            // Delete old avatar if it exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
                \Log::info('Old avatar deleted successfully.', ['user_id' => $user->id, 'avatar' => $user->avatar]);
            }

            // Store the new avatar and set the path
            $avatarPath = $avatar->store('avatars', 'public');
            $user->avatar = $avatarPath;

            \Log::info('New avatar uploaded successfully.', ['user_id' => $user->id, 'avatar_path' => $avatarPath]);
        } catch (\Exception $e) {
            \Log::error('Error during avatar upload.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Re-throw the exception to handle it in the calling method
        }
    }

    /**
     * Delete the user's avatar file if it exists.
     *
     * @param $user
     * @return void
     */
    private function deleteAvatarIfExists($user): void
    {
        try {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
                \Log::info('Avatar deleted successfully.', ['user_id' => $user->id]);
            }
        } catch (\Exception $e) {
            \Log::error('Error occurred while deleting avatar.', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}