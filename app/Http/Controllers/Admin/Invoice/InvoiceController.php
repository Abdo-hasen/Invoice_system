<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use App\Models\Invoice_Detail;
use App\Exports\InvoicesExport;
use App\Http\Traits\GetProducts;
use App\Notifications\NewInvoice;
use App\Http\Traits\RedirectTrait;
use App\Models\Invoice_Attachment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Invoices\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    use FileTrait;
    use RedirectTrait;

    public function index()
    {
        $invoices = Invoice::with("section")->paginate();
        return view("Admin.pages.invoices.index", compact("invoices"));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('details', 'attachments', 'section');
        return view("Admin.pages.invoices.show", compact("invoice"));
    }

    public function create()
    {
        $sections = Section::get();
        return view("Admin.pages.invoices.create", compact("sections"));
    }

    public function store(StoreInvoiceRequest $request)
    {
        Invoice::create([
            "invoice_number" => $request->invoice_number,
            "invoice_date" => $request->invoice_date,
            "due_date" => $request->due_date,
            "section_id" => $request->section_id,
            "product" => $request->product,
            "amount_collection" => $request->amount_collection,
            "amount_commission" => $request->amount_commission,
            "discount" => $request->discount,
            "rate_vat" => $request->rate_vat,
            "value_vat" => $request->value_vat,
            "total" => $request->total,
            "note" => $request->note,
        ]);

        $invoice_id = Invoice::latest()->first()->id;
        Invoice_Detail::create([
            "invoice_id" => $invoice_id,
            "invoice_number" => $request->invoice_number,
            "section_id" => $request->section_id,
            "product" => $request->product,
            "note" => $request->note,
            "user" => auth()->user()->name,
        ]);

        if ($request->hasFile("file")) {
            //upload file
            $file_name = $this->uploadFile(Invoice::PATH . $request->invoice_number, $request->file); //$request->file : file name of input

            Invoice_Attachment::create([
                "invoice_id" => $invoice_id,
                "invoice_number" => $request->invoice_number,
                "file_name" => $file_name,
                "created_by" => auth()->user()->name,
            ]);
        }


        $user = User::find(1); 
        Notification::send($user, new NewInvoice($invoice_id)); 

        return $this->redirect("Invoice Has Been Created Successfully", "admin.invoices.index");


    }

    public function edit(Invoice $invoice)
    {
        $sections = Section::get();
        return view("Admin.pages.invoices.edit", compact("invoice", "sections"));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update([
            "invoice_number" => $request->invoice_number,
            "invoice_date" => $request->invoice_date,
            "due_date" => $request->due_date,
            "section_id" => $request->section_id,
            "product" => $request->product,
            "amount_collection" => $request->amount_collection,
            "amount_commission" => $request->amount_commission,
            "discount" => $request->discount,
            "rate_vat" => $request->rate_vat,
            "value_vat" => $request->value_vat,
            "total" => $request->total,
            "note" => $request->note,
        ]);

      
        $invoice_details = Invoice_Detail::where("invoice_id", $invoice->id)->get();
        foreach ($invoice_details as $detail) {
            $detail->update([
                "invoice_number" => $request->invoice_number,
                "product" => $request->product,
                "section_id" => $request->section_id,
                "value_vat" => $request->value_vat,
                "note" => $request->note,
                "user" => auth()->user()->name,
            ]);
        }

        $invoice_attachments = Invoice_Attachment::where("invoice_id", $invoice->id)->get();
        foreach ($invoice_attachments as $attachment) {
            $attachment->update([
                "invoice_number" => $request->invoice_number,
            ]);
        }

        return $this->redirect("Invoice Has Been Updated Successfully", "admin.invoices.index");
    }

    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrfail($request->invoice_id);

        // طريقه فعاله لو عايز تعمل كذا حاجه ف الكنترولر ميز ب id
        if ($request->id_page == 2) { //archive
            $invoice->delete();
            return $this->redirect("Invoice Has Been Archived Successfully", "admin.archives.index");
        } else {
            $this->deleteFolder($invoice->invoice_number);
            $invoice->forceDelete();
            return $this->redirect("Invoice Has Been Deleted Successfully", "admin.invoices.index");
        }

    }

    public function print(Invoice $invoice) {
        $invoice->load("section");
        return view("Admin.pages.invoices.print", compact("invoice"));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'Invoices.xlsx');
    }

    // single respons
    public function getProducts(Section $section)
    {
        $products = Product::where("section_id", $section->id)->pluck("name", "id");
        return json_encode($products);
    }

    public function markAll()
    {
        $userUnreadNotifications = auth()->user()->unreadNotifications;

        if ($userUnreadNotifications) {
            $userUnreadNotifications->markAsRead();
            return back();
        }
    }

}


