<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Returns all listings.
    public function getAll()
    {
        return view('listing.list', [
            'lists' => Listing::latest()->filter(request(['tag', 'search']),)->paginate(5)
        ]);
    }

    // Returns listing detail.
    public function getOne(Listing $id)
    {
        return view('listing.show', [
            'listing' => $id
        ]);
    }

    // Show create Form.
    public function create()
    {
        return view('listing.create');
    }

    // Store listing data.
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos ', 'public');
        }

        $formFields['created_by'] = auth()->id();

        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // Show Edit Form.
    public function edit(listing $listing)
    {
        return view('listing.edit', ['listing' => $listing]);
    }

    // Update listing data.
    public function update(Request $request, Listing $listing)
    {

        // Check if the user logged in created this listing.
        if ($listing->created_by != auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos ', 'public');
        }

        $listing->update($formFields);
        return back()->with('message', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        // Check if the user logged in created this listing.
        if ($listing->created_by != auth()->id()) {
            abort(403, 'Unauthorized Action!');
        }

        $listing->delete();
        return redirect('/')->with('message', 'List deleted successfully.');
    }

    // Show Manage Listing Page.
    public function manage()
    {
        return view('listing.manage', [
            'lists' => auth()->user()->listings
        ]);
    }

    // Returns logged in users listing.
    public function getMyLists()
    {
        return view('listing.manage', [
            'lists' => auth()->user()->listings
        ]);
    }
}
