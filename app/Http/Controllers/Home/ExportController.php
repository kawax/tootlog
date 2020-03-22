<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Jobs\Status\ExportCsvJob;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function csv(Request $request)
    {
        ExportCsvJob::dispatchAfterResponse($request->user());

        return back()->with('export', 'Sending files, please wait...');
    }
}
