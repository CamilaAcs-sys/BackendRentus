<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // $reports = Report::included()->get();
        // return response()->json($reports);

        $reports = Report::included()->filter()->get();
        return response()->json($reports);
    }

    public function show(Report $report)
    {
        //
    }

    public function edit(Report $report)
    {
        //
    }

    public function update(Request $request, Report $report)
    {
        //
    }

    public function destroy(Report $report)
    {
        //
    }
}
