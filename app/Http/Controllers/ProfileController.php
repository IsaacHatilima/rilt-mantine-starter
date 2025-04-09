<?php

namespace App\Http\Controllers;

use App\Actions\Auth\DeleteAccountAction;
use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\Auth\CurrentPasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly UpdateProfileAction $profileManagerAction,
        private readonly DeleteAccountAction $deleteAccountAction
    ) {}

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $this->authorize('update', auth()->user()->profile);

        try {
            $this->profileManagerAction->execute($request);
        } catch (Throwable $e) {
            report($e);

            return back()->withErrors([
                'error' => 'Profile update failed. Please try again later.',
            ]);
        }

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(CurrentPasswordRequest $request): RedirectResponse
    {
        $this->authorize('delete', auth()->user()->profile);

        $this->deleteAccountAction->delete($request);

        return Redirect::to('/');
    }
}
