<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view("Admin.pages.reports.invoicesReports");
    }

    public function search(Request $request)
    {
        $status = $request->status;
        $start_at = $request->start_at;
        $end_at = $request->end_at;

        //search with invoice status
        if ($request->radio == 1) {
            
            if (empty($request->start_at && $request->end_at)) {
                $invoices = Invoice::where("status", $request->status)
                ->with("section")
                ->get();
                return view("Admin.pages.reports.invoicesReports", compact("invoices", "status"));

            } else {    
                $invoices = Invoice::where("status", $request->status)
                ->whereBetween("invoice_date", [$start_at, $end_at])
                ->with("section")
                ->get();
                return view("Admin.pages.reports.invoicesReports", compact("invoices", "status","start_at","end_at"));
            }
        }
        //search with invoice Number
        else {
            $invoices = Invoice::where("invoice_number", $request->invoice_number)
            ->with("section")
            ->get();
            return view("Admin.pages.reports.invoicesReports", compact("invoices"));
        }
    }

}
