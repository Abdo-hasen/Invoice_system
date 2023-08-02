<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class AdminController extends Controller
{
    public function index()
    {

        $sum = number_format(Invoice::sum("total"), 2); //comma after 2 numbers
        $count = Invoice::count();

        $paid_sum = number_format(Invoice::where("value_status", 1)->sum("total"), 2);
        $paid_count = Invoice::where("value_status", 1)->count();

        $partial_sum = number_format(Invoice::where("value_status", 3)->sum("total"), 2);
        $partial_count = Invoice::where("value_status", 3)->count();

        $unpaid_sum = number_format(Invoice::where("value_status", 2)->sum("total"), 2);
        $unpaid_count = Invoice::where("value_status", 2)->count();

        if ($paid_count == 0) {
            $paid_percentage = 0;
        } else {
            $paid_percentage = ($paid_count / $count) * 100;
        }

        if ($partial_count == 0) {
            $partial_percentage = 0;
        } else {
            $partial_percentage = ($partial_count / $count) * 100;
        }

        if ($unpaid_count == 0) {
            $unpaid_percentage = 0;
        } else {
            $unpaid_percentage = ($unpaid_count / $count) * 100;
        }

        //=================Charts=====================

        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 350, 'height' => 200])
        ->datasets([
            [
                "label" => 'Unpaid', //above label
                'backgroundColor' => ['#ec5858'],
                'data' => [$unpaid_percentage]
            ],
            [
                "label" => 'Paid',
                'backgroundColor' => ['#81b214'],
                'data' => [$paid_percentage]
            ],
            [
                "label" => 'Partial paid',
                'backgroundColor' => ['#ff9642'],
                'data' => [$partial_percentage]
            ],


        ])
        ->options([]);



        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['Unpaid', 'Paid', 'Partial paid']) 
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214', '#ff9642'],
                    'data' => [$unpaid_percentage, $paid_percentage, $partial_percentage],
                ],
            ])
            ->options([]);

        return view("Admin.index", compact("sum", "count", "paid_sum", "paid_count", "partial_sum", "partial_count", "unpaid_sum", "unpaid_count", "paid_percentage", "partial_percentage", "unpaid_percentage","chartjs_2","chartjs"));
    }
}
