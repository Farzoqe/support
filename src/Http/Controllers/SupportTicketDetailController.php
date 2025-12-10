<?php

namespace Farzoqe\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Farzoqe\Support\Models\SupportTicketDetail;
use Illuminate\Http\Request;

class SupportTicketDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('SupportTicketDetails/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SupportTicketDetail $supportTicketDetail)
    {
        return inertia('SupportTicketDetails/Create', compact('supportTicketDetail'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supportTicketDetail = SupportTicketDetail::getInstance();
        $supportTicketDetail->fill($request->only([]))->save();
        return successful();
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicketDetail $supportTicketDetail)
    {
        return inertia("SupportTicketDetails/Show", compact('supportTicketDetail'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicketDetail $supportTicketDetail)
    {
        return $this->create($supportTicketDetail);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportTicketDetail $supportTicketDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicketDetail $supportTicketDetail)
    {
        \Gate::authorize('user-item', $supportTicketDetail);
        $supportTicketDetail->delete();
        return successful("Deleted!");
    }
}
