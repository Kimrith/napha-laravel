<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings and governance overview.
     */
    public function index(Request $request): View
    {
        $user = $request->user() ?? auth()->user();

        $term = [
            'name' => Setting::get('term_name', 'Fall Semester 2026'),
            'week' => Setting::get('term_week', 'Week 8'),
            'startDate' => Setting::get('term_start_date', '2026-08-25'),
            'endDate' => Setting::get('term_end_date', '2026-12-18'),
            'gradingDeadline' => Setting::get('term_grading_deadline', '2026-12-24'),
        ];

        return view('settings.index', [
            'user' => $user,
            'term' => $term,
        ]);
    }

    /**
     * Update the authenticated user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Please enter your current password.',
            'current_password.current_password' => 'The current password you provided is incorrect.',
            'password.required' => 'Please provide a new password.',
            'password.min' => 'The new password must be at least 8 characters long.',
            'password.confirmed' => 'The new password confirmation does not match.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Your password has been updated successfully.');
    }

    /**
     * Update system academic term dates and configuration.
     */
    public function updateTerm(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'term_name' => ['required', 'string', 'max:100'],
            'term_week' => ['required', 'string', 'max:50'],
            'term_start_date' => ['nullable', 'date'],
            'term_end_date' => ['nullable', 'date'],
        ]);

        Setting::set('term_name', $validated['term_name'], 'academic');
        Setting::set('term_week', $validated['term_week'], 'academic');

        if (! empty($validated['term_start_date'])) {
            Setting::set('term_start_date', $validated['term_start_date'], 'academic');
        }

        if (! empty($validated['term_end_date'])) {
            Setting::set('term_end_date', $validated['term_end_date'], 'academic');
        }

        return redirect()->route('settings.index')
            ->with('success', 'Academic term configuration saved successfully.');
    }
}
