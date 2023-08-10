<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Traits\FileTrait;
use App\Http\Traits\RedirectTrait;
use App\Models\Invoice_Attachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\InvoicesDetails\StoreInvoiceDetailRequest;

class InvoiceAttachmentController extends Controller
{
    use FileTrait;
    use RedirectTrait;
       
    public function store(StoreInvoiceDetailRequest $request)
    {
        $file_name = $this->uploadFile(Invoice::PATH, $request->file);

        Invoice_Attachment::create([
                "invoice_id" => $request->invoice_id,
                "invoice_number" => $request->invoice_number,
                "file_name" => $file_name,
                "created_by" => auth()->user()->name
        ]);

        alert()->success("Attachment Has Been Uploaded Successfully");
        return redirect()->back();

    }

    public function openFile(Invoice_Attachment $attachment)
    {
        $file = Storage::disk('public_uploads')->path($attachment->file_name); // to get path of file
        return response()->file($file); 
    }

    public function downloadFile(Invoice_Attachment $attachment)
    {
        $file = Storage::disk('public_uploads')->path($attachment->file_name); 
        return response()->download($file);
    }

    public function destroy(Request $request)
    {
        $invoice_attachment = Invoice_Attachment::findOrfail($request->id_file);
        $this->deleteFile($request->invoice_number.'/'.$request->file_name); 
        $invoice_attachment->delete();
        alert()->success("Attachment Has Been Deleted Successfully");
        return redirect()->back();
    }
  



}
