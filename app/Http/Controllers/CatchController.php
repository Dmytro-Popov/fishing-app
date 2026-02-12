<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatchController extends Controller
{
    /**
     * Display a listing of catches.
     */
    public function index()
    {
        return view('catches.index');
    }

    /**
     * Show the form for creating a new catch.
     */
    public function create()
    {
        return view('catches.create');
    }

    /**
     * Store a newly created catch in storage.
     */
    public function store(Request $request)
    {
        return 'Catch saved! (temporary message)';
    }

    /**
     * Display the specified catch.
     */
    public function show(string $id)
    {
        return view('catches.show', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified catch.
     */
    public function edit(string $id)
    {
        return view('catches.edit', ['id' => $id]);
    }

    /**
     * Update the specified catch in storage.
     */
    public function update(Request $request, string $id)
    {
        return "Catch #{$id} updated! (temporary message)";
    }

    /**
     * Remove the specified catch from storage.
     */
    public function destroy(string $id)
    {
        return "Catch #{$id} deleted! (temporary message)";
    }
}
