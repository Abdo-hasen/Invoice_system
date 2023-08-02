<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Traits\FileTrait;
use App\Http\Traits\RedirectTrait;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceArchiveController extends Controller
{
    use RedirectTrait;
    use FileTrait;

    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view("Admin.pages.invoices_archives.index", compact("invoices"));
    }

    // return invoice from archives to invoices
    public function update(Request $request)
    {
        $invoice = Invoice::withTrashed()->where("id", $request->invoice_id)->restore();
        //    dd($invoice); // 1 - restore return number of affected rows
        return $this->redirect("Invoice Has Been Moved To Invoices Successfully ", "admin.invoices.index");
    }

    public function destroy(Request $request)
    {
        $invoice = Invoice::withTrashed()->where("id", $request->invoice_id)->first();

        $this->deleteFolder($invoice->invoice_number);
        $invoice->forceDelete();
        return $this->redirect("Invoice Has Been Deleted Successfully", "admin.archives.index");

    }
}
