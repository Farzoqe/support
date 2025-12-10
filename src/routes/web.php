<?php

use Farzoqe\Support\Http\Controllers\SupportTicketController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::resources(['support-tickets' => SupportTicketController::class,]);
});
