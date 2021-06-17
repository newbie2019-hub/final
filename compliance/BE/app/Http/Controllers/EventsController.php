<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Gallery;
use App\Models\Home;
use App\Models\Rates;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function store(Request $request){
        
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $event = Events::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $gallery = Gallery::create([
            'image' => $request->image
        ]);

        $rate = Rates::create([
            'rate' => $request->rate
        ]);

        Home::create([
            'events_id' => $event->id,
            'gallery_id' => $gallery->id,
            'rates_id' => $rate->id,
        ]);
           
        return response()->json(['msg' => 'Success'], 200);
    }


    public function destroy($id){
        $info = Gallery::where('id', $id)->first();
        $this->deleteFileFromServer($info['featuredImage']);
        Gallery::destroy($id);
    }

    public function deleteFileFromServer($filename){
        $filePath = public_path().'/uploads/'.$filename;
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return;
    }

    public function uploadFeaturedImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
}
