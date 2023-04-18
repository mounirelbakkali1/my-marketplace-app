<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Services\HandleDataLoading;

class ContactController extends Controller
{

    private HandleDataLoading $handleDataLoading;

    /**
     * @param HandleDataLoading $handleDataLoading
     */
    public function __construct(HandleDataLoading $handleDataLoading)
    {
        $this->handleDataLoading = $handleDataLoading;
    }


    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();
       return  $this->handleDataLoading->handleAction(function () use ($validated) {
            return Contact::create($validated);
        }, 'contact', 'creat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
