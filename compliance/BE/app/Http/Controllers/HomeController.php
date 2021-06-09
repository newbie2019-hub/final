<?php

namespace App\Http\Controllers;

use App\Models\Home;
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
}
