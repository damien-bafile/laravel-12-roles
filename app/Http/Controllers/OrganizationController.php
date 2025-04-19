<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    // Show form for creating an organization
    public function create()
    {
        return view('organizations.create');
    }

    // Store a new organization
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:organizations|max:255',
            'description' => 'nullable|max:500',
        ]);

        Organization::create($request->only(['name', 'description']));

        return redirect()->route('organizations.index')->with('success', 'Organization created successfully!');
    }

    // Show form for editing an organization
    public function edit(Organization $organization)
    {
        return view('organizations.edit', compact('organization'));
    }

    // Update an organization
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|max:255|unique:organizations,name,' . $organization->id,
            'description' => 'nullable|max:500',
        ]);

        $organization->update($request->only(['name', 'description']));

        return redirect()->route('organizations.index')->with('success', 'Organization updated successfully!');
    }

    // Assign users to an organization
    public function assignUsers(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ]);

        $organization = Organization::findOrFail($request->organization_id);
        $organization->users()->sync($request->user_id); // Assign multiple users to the organization

        return redirect()->back()->with('success', 'Users assigned to organization successfully!');
    }
}
