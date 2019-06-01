<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Jobs\Status\ExportCsvJob;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
    public function csv(Request $request)
    {
        ExportCsvJob::dispatch($request->user());

        return back()->with('export', 'Sending files, please wait...');
    }
}
