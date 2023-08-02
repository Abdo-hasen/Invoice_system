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
        Schema::create('invoice__details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("invoice_id")->constrained("invoices")->onDelete("cascade");
            $table->string("invoice_number");
            $table->string("product");
            $table->string("section_id");
            $table->string("status")->default("un paid");//paid - non paid
            $table->enum("value_status",[1,2,3])->default(2); //1 for paid - 2 un paid - 3 partita paid
            $table->text("note")->nullable();
            $table->date("payment_date")->nullable();
            $table->string("user");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice__details');
    }
};
