<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Get & Show all listings
    public function index() {
        // dd(request());
        // foreach(Listing::all() as $list) {
        //     return $list;
        // }

        return view('listings.index', [
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }


    //Show Create Form
    public function create() {
        return view('listings.create');
    }

    //Store Listing Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')], //so rule:unique('tableName', 'field where it should be unique')
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'], //this means that it must be formatted as an email
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
            /*
            so this first checks if a logo has been uploaded. if it has, then it requests the logo and
            stores it in a newly created logos folder in the public route (set in config/) filesystems.php
            'default' => env('FILESYSTEM_DISK', 'public'),
            which sets the storage path as app/public
            the formFields adds the path to the logo to the db
            */
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //Show edit form
    public function edit(Listing $listing) {
        //make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        return view('listings.edit', ['listing' => $listing]); //return a view (the resources/views/listing/edit.blade.php) and send the $listing (pulled from Listing edit button) to the page as variable listing
    }
    //Show single listing
    public function show(Listing $listing) {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Update listing Data
    public function update(Request $request, Listing $listing) {

        //make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
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

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing created successfully!');
    }

    //Delete Listing
    public function delete(Listing $listing) {
        //make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing has been deleted successfully.');
    }

    //Manage Listing
    public function manage() {
        return view('listings.manage', ['listings' => auth()->user()->listing()->get()]);
        //So using eloquent, this checks the authenticated/session->grabs the user info->grabs the lisitngs associated
        //with the user -> returns the listings
    }

    // //Show single listings
    // public function show($id) {
    //     return view('listings.show', [
    //         $listing = Listing::find($id)
    //         // 'listing' => $listing
    //     ]);
    // }
}
