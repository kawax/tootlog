<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\Status\ExportCsvJob;

class ExportController extends Controller
{
    public function csv(Request $request)
    {
        dispatch((new ExportCsvJob(auth()->user())));

        return back()->with('export', 'Sending files, please wait...');
    }
}
