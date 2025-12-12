<?php

namespace Farzoqe\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use Farzoqe\Support\Models\SupportTicket;
use Farzoqe\Support\Services\SupportTicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('can-support')) {
            $tickets = SupportTicket::latest();
        } else {
            $tickets = auth()->user()->support_tickets();
        }
        $tickets = $tickets->with('detail.user')->get();
        return inertia('SupportTickets/Index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(SupportTicket $supportTicket)
    {
        Gate::authorize('user-item', $supportTicket);
        $supportTicket->load("details.user");
        $ticket = $supportTicket;
        return inertia('SupportTickets/Create', compact('ticket'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supportTicket = SupportTicket::getInstance();
        $supportTicket->fill($request->only([
            'subject'
        ]))->save();
        $supportTicket->user_id = auth()->id();
        $supportTicket->save();
        $service = new SupportTicketService($supportTicket);
        $service->addDetails($request->description, $request->attachments);
        return redirect('/support-tickets')->with('success', 'Your ticket has been created successfully. One of your agents will be in touch soon.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        $statuses = array_column(SupportTicketStatusEnum::cases(), 'value');
        $statuses = array_combine($statuses, $statuses);
        $ticket = $supportTicket;
        $ticket->load("details.user");
        return inertia("SupportTickets/Show", compact('ticket', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SupportTicket $supportTicket)
    {
        return $this->create($supportTicket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'details' => 'required'
        ]);
        $service = new SupportTicketService($supportTicket);
        $service->addDetails($request->details, $request->attachments);
        $service->updateStatus();

        return successful();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $supportTicket)
    {
        Gate::authorize('user-item', $supportTicket);
        $supportTicket->delete();
        return successful("Deleted!");
    }

    function changeStatus(Request $request, SupportTicket $supportTicket)
    {
        $supportTicket->status = $request->status;
        $supportTicket->save();
        return successful();
    }

    function sendLoginLink(Request $request, SupportTicket $supportTicket)
    {
        $loginToken = auth()->user()->login_tokens()->create([
            'token' => uuid_create()
        ]);

        $supportTicket->details()->create([
            'details' => "<a href='$loginToken->login_url'>" . __('Click here to login') . "</a>. " . __('Only valid for :days days', ['days' => 3]) . ".",
            'user_id' => auth()->id(),
        ]);
        return successful();
    }
}
