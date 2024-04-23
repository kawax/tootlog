<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Jobs\Status\ExportCsvJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        ExportCsvJob::dispatch($request->user());

        return back()->with('export', 'Sending files, please wait...');
    }
}
