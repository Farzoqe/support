<?php

namespace Farzoqe\Support\Models;

use Farzoqe\Support\Traits\GetsInstance;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SupportTicketDetail extends Model
{
    use GetsInstance;

    protected $guarded = [];

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
