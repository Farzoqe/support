<?php

namespace Farzoqe\Support\Traits;

use Farzoqe\Support\Models\SupportTicket;

trait HasSupportTickets
{
    function support_tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
}
