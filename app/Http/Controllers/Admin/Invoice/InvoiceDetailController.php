<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Traits\RedirectTrait;
use App\Models\Invoice;
use App\Models\Invoice_Detail;
use Illuminate\Http\Request;

class InvoiceDetailController extends Controller
{
    use RedirectTrait;

    public function editStatus(Invoice $invoice)
    {
        $invoice->load("section");
        return view("Admin.pages.invoices_details.edit", compact("invoice"));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        if($request->payment_status == "paid")
        {
            $invoice->update([
                "status" => $request->payment_status ,
                "value_status" =>  1,
                "payment_date" => $request->payment_date ,
            ]);

            Invoice_Detail::create([
                "invoice_id" => $invoice->id,
                "invoice_number" => $request->invoice_number,
                "product" => $request->product,
                "section_id" => $request->section_id,
                "value_vat" => $request->value_vat,
                "status" => $request->payment_status ,
                "value_status" =>  1,
                "payment_date" => $request->payment_date ,
                "note" => $request->note,
                "user" => auth()->user()->name, 
            ]);
        }
        else //partial paid
        {
            $invoice->update([
                "status" => $request->payment_status ,
                "value_status" =>  3,
                "payment_date" => $request->payment_date ,
            ]);

            Invoice_Detail::create([
                "invoice_id" => $invoice->id,
                "invoice_number" => $request->invoice_number,
                "product" => $request->product,
                "section_id" => $request->section_id,
                "value_vat" => $request->value_vat,
                "status" => $request->payment_status ,
                "value_status" =>  3,
                "payment_date" => $request->payment_date ,
                "note" => $request->note,
                "user" => auth()->user()->name, 
            ]);
        }


        return $this->redirect("Payment Status Has Been Updated Successfully", "admin.invoices.index");

    }

    public function paid()
    {
        $invoices = Invoice::where("value_status",1)->get();
        return view("Admin.pages.invoices_payment.paid_invoices",compact("invoices"));
    }

    public function unPaid()
    {
        $invoices = Invoice::where("value_status",2)->get();
        return view("Admin.pages.invoices_payment.unpaid_invoices",compact("invoices"));
    }

    public function partialPaid()
    {
        $invoices = Invoice::where("value_status",3)->get();
        return view("Admin.pages.invoices_payment.partial_paid_invoices",compact("invoices"));
    }

}
