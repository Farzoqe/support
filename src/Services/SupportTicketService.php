<?php

namespace Farzoqe\Support\Services;

use Farzoqe\Support\Models\SupportTicket;
use Illuminate\Support\Facades\Storage;

class SupportTicketService
{
    public function __construct(private SupportTicket $supportTicket)
    {
    }

    function addDetails($description, $attachments)
    {
        if ($attachments) {
            $description .= "<br><br>Attachments:";
        }
        foreach ($attachments ?: [] as $file) {
            $url = Storage::url(($file->store('uploads')));
            $name = $file->getClientOriginalName();
            $description .= "<br><a target='_blank' href='$url'>$name</a>";
        }
        $this->supportTicket->details()->create([
            'details' => $description,
            'user_id' => auth()->id(),
        ]);
    }

    function updateStatus()
    {
        $supportTicket = $this->supportTicket;
        if ($supportTicket->user_id == auth()->id()) {
            $supportTicket->status = 'Open';
        } else {
            $supportTicket->status = 'Awaiting Customer Reply';
        }
        $supportTicket->save();
    }
}
