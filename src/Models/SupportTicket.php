<?php

namespace Farzoqe\Support\Models;

use App\Models\User;
use Farzoqe\Support\Traits\GetsInstance;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use GetsInstance;

    const STATUSES = [
        "Open",
        "Closed",
        "Awaiting Customer Reply",
        "Paused",
        "On-Hold",
    ];
    protected $guarded = [];

    function details()
    {
        return $this->hasMany(SupportTicketDetail::class)->latest();
    }

    function detail()
    {
        return $this->hasOne(SupportTicketDetail::class)->latest();
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
