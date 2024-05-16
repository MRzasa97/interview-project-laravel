<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkTimeRequest;
use App\Services\Interfaces\WorkTimeServiceInterface;
use Illuminate\Http\Request;

class WorkTimeController extends Controller
{
    public function __construct(
        public readonly WorkTimeServiceInterface $workTimeService
    )
    {
    }

    public function register(WorkTimeRequest $request)
    {
        $message = $this->workTimeService->registerWorkTime($request->all());
        
        return response()->json(['message' => $message], 200);
    }

    public function summary(WorkTimeRequest $request)
    {
        $message = $this->workTimeService->getWorkTimeSummary(
            $request->input('employee_id'),
            $request->input('date')
        );

        return response()->json($message, 200);
    }
}
