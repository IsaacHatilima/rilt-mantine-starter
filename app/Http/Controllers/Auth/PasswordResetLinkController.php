<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    public function __construct(private readonly ForgotPasswordAction $forgotPasswordAction) {}

    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        $this->forgotPasswordAction->execute($request);

        return back()->with('status', __('Password reset link sent. Please check your email.'));
    }
}
