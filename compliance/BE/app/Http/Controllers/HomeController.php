<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Gallery;
use App\Models\Home;
use App\Models\Rates;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return response()->json(Home::with(['event', 'gallery', 'rate'])->get());
    }

    public function destroy($id){
        $event = Home::with(['event', 'gallery', 'rate'])->where('id', $id)->first();
        $this->deleteFileFromServer($event->gallery->image);
        Home::where('id', $id)->delete();

        return response()->json(['msg' => 'Event deleted successfully!'], 200);
    }

    public function deleteFileFromServer($filename){
        $filePath = public_path().'/uploads/'.$filename;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }
    public function update(Request $request, $id){
        
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $home = Home::where('events_id', $id)->first();

        if($home){

            $event = Events::where('id', $home->events_id)->first();
            $event->update(['title' => $request->title, 'description' => $request->description]);

            $rate = Rates::where('id', $home->rates_id)->first();
            $rate->update(['rate' => $request->rate]);

            if($request->image){
                $gallery = Gallery::where('id', $home->gallery_id)->first();
                $gallery->update(['image' => $request->image]);
            };

            return response()->json(['msg' => 'Event updated successfully!'], 200);
        }
        else {
            return response()->json(['msg' => 'Event not found'], 401);
        }

    }
}
