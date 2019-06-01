<?php

namespace App\Http\Controllers\Api;

use App\Model\Status;
use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * 非表示
     *
     * @param  Status  $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(Status $status)
    {
        $this->authorize('hide', $status);

        $status->delete();

        return response()->json(['message' => 'ok']);
    }

    /**
     * 表示
     *
     * @param  string  $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $status)
    {
        /**
         * @var Status $sta
         */
        $sta = Status::withTrashed()->find($status);

        $this->authorize('hide', $sta);

        $sta->restore();

        return response()->json(['message' => 'ok']);
    }
}
