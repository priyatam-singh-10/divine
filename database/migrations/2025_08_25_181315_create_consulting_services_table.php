<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consulting_services', function (Blueprint $table) {
        $table->id();
        $table->string('name');            // Student/Visitor Name
        $table->string('email');           // Email
        $table->string('phone');           // Phone Number
        $table->string('service')->default('Consultation'); // Services (default value)
        $table->string('address')->nullable(); // Address
        $table->date('date');             // Selected Date
        $table->time('time'); 
          $table->string('status')->nullable();               // Selected Time
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulting_services');
    }
};
