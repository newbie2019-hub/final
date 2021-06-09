<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Models\Reservation;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index() {
        return response()->json( Reservation::with(['user', 'home', 'home.event', 'home.rate'])->get());
    }

    public function filter_reservation(Request $request){
        $reservation = Reservation::with(['user', 'home', 'home.rate'])->whereBetween('start_date', [$request->start_date, $request->end_date])->orWhereBetween('end_date', [$request->start_date, $request->end_date])->get();
        return response()->json($reservation);
    }

    public function setPaid($id){
        $res = Reservation::find($id);
        if($res){
            $res->update(['status' => 'Paid']);
            return response()->json(['msg' => 'Update successful']);
        }
    }

    public function setCancelled($id){
        $res = Reservation::find($id);
        if($res){
            $res->update(['status' => 'Cancelled']);
            return response()->json(['msg' => 'Update successful']);
        }
    }
    public function destroy($id){
        Reservation::destroy($id);
        return response()->json(['msg' => 'Record deleted successfully']);
    }
}
