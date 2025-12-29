<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AgencyProfile;

class AgencyProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // Get existing profile or create an empty instance in memory
        $profile = $user->agencyProfile ?? new AgencyProfile();

        return view('settings.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'tax_id' => 'nullable|string',
            'bank_details' => 'nullable|string',
        ]);

        // Update or Create the profile
        AgencyProfile::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return back()->with('success', 'Company settings updated successfully.');
    }
}
