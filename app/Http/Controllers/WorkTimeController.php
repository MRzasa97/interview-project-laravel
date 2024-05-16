<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\WorkTimeServiceInterface;
use Illuminate\Http\Request;

class WorkTimeController extends Controller
{
    public function __construct(
        public readonly WorkTimeServiceInterface $workTimeService
    )
    {
    }

    public function register(Request $request)
    {
        $message = $this->workTimeService->registerWorkTime($request->all());
        
        return response()->json(['message' => $message], 200);
    }
}
