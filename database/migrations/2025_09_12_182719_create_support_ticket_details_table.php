<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('support_ticket_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->index();
            $table->foreignIdFor(\Farzoqe\Support\Models\SupportTicket::class)->index();
            $table->text('details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_details');
    }
};
