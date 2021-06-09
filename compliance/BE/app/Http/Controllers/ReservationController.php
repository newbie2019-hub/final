<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\Record;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function check_reservation(Request $request){
        $reservation = Reservation::where('status', '!=', "Cancelled")->whereBetween('start_date', [$request->start_date, $request->end_date])->WhereBetween('end_date', [$request->start_date, $request->end_date])->get(['start_date', 'end_date']);
        if($reservation->isEmpty()){
          return response()->json(['data' => 'No results found'], 200);
        }
        else
        {
          return response()->json(['data' => $reservation], 200);
        }
    }

    public function index(){
        return response()->json(Home::with(['event', 'gallery', 'rate'])->get());
    }

    public function reserve(Request $request) {
        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'home_id' => $request->home_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending'
        ]);

        Record::create([
            'user_id' => $request->user_id,
            'reservation_id' => $reservation->id
        ]);

        return response()->json(['message' => 'Reservation successful']);
    }
}
