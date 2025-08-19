<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use DateTime;

class ReportController extends Controller
{
    /**
     * Display the view for all report options.
     */
    public function AminAllReports(){
        return view('admin.backend.report.all_report');
    }

    /**
     * Search for orders by a specific date.
     */
    public function AminSearchByDate(Request $request){
        $date = new DateTime($request->date);
        $formatDate = $date->format('d F Y');

        $orderDate = Order::where('order_date',$formatDate)->latest()->get();
        return view('admin.backend.report.search_by_date',compact('orderDate','formatDate'));
    }

    /**
     * Search for orders by a specific month and year.
     */
    public function AminSearchByMonth(Request $request){
        $month = $request->month;
        $years = $request->year_name;

        $orderMonth = Order::where('order_month',$month)->where('order_year',$years)->latest()->get();
        return view('admin.backend.report.search_by_month',compact('orderMonth','month','years'));
    }
     
    /**
     * Search for orders by a specific year.
     */
    public function AminSearchByYear(Request $request){ 
        $years = $request->year;

        $orderYear = Order::where('order_year',$years)->latest()->get();
        return view('admin.backend.report.search_by_year',compact('orderYear','years'));
    }
}