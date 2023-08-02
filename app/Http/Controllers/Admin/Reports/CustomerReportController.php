<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        $sections = Section::get();
        return view("Admin.pages.reports.customerReports", compact("sections"));
    }

    public function search(Request $request)
    {
        $start_at = $request->start_at;
        $end_at = $request->end_at;
        $product = $request->product;
        $sections = Section::get();
        $Section = Section::findOrfail($request->section_id);
        $section = $Section->name;

        if (empty($start_at && $end_at)) {
            $invoices = Invoice::where([
                "section_id" => $request->section_id, 
                "product" => $request->product, 
            ])
            ->with("section")
            ->get();
            
            return view("Admin.pages.reports.customerReports", compact("invoices", "section", "product", "sections"));

        } else { //search with Dates

            $invoices = Invoice::where([
                "section_id" => $request->section_id,
                "product" => $request->product,
            ])
            ->whereBetween("invoice_date", [$start_at, $end_at])
            ->with("section")
            ->get();
         
            return view("Admin.pages.reports.customerReports", compact("invoices", "section", "product", "sections", "start_at", "end_at"));
        }
    }
}
