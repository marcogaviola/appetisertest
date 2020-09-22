<?php

namespace App\Http\Controllers;

use App\Event;

class EventsController extends Controller
{
    public function store()
    {
        $event = Event::create($this->validateRequest());
        return response()->json($event, 201);
    }

    private function validateRequest()
    {
        return request()->validate([
            "description" => "required",
            "from_date" => "required",
            "to_date" => "required",
            "days_covered" => "required",
        ]);
    }
}
