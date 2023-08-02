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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_number");//big number- string not integer ex :26262626
            $table->date("invoice_date");
            $table->date("due_date");
            $table->date("payment_date")->nullable();
            $table->foreignId("section_id")->constrained("sections")->onDelete("cascade");
            $table->string("product");
            $table->decimal("amount_collection")->nullable();
            $table->decimal("amount_commission");
            $table->decimal("discount");
            $table->string("rate_vat");//rate value added tax : نسبه الضريبه المضافه مثلا = 14% - percentage : string
            $table->decimal("value_vat");
            $table->decimal("total");
            $table->string("status")->default("un paid");//paid - partial paid
            $table->enum("value_status",[1,2,3])->default(2); //1 for paid - 2 un paid - 3 partita paid
            $table->text("note")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};


############################################################
/*
    // عشان لما اعوز استدعي كل الفواتير المدفوعه استدعيها مثلا ب 1 مش مدفوعه فبتبقي اسهل واسرع 
    $table->integer("value_status"); 

    // بربط كل بنك او سيطشن بفواتيره 
    طب ليه معملتش كده مع البروديكت ؟
    لاني اولا بختار بروديكت ب ajax ثانيا هو مربوط ب سيكشن
    
        $table->string("product");
        $table->foreignId("section_id")->constrained("sections")->onDelete("cascade");

    // لو فيه علاقه بين حدولين لازم تراعي الترتيب يعني مينفعش اربط جدول بجدول لسه متعملش 
ولو اتحط ف الموقف ده غير تاريخ ميجراشن واعمل ميجريت فريش 

// nullable dont write it in fillable - بس لو كتبتها مدخلتهاش ف الفورم عادي

//ليه شال user من جدول فواتير ؟
عشان يحطها في التفاصيل

*/
