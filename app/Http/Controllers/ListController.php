<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{
    
    public function index()
    {
        $item = Item::all();
        return view('list', compact('item'));
    }
    
    public function create(request $request)
    {
        $item = new Item;
        $item->item = $request->text;
        $item->save();
        return redirect('/list');
    }
    
    public function delete(request $request) 
    {
        Item::where('id',$request->id)->delete();
        return redirect('/list');
        //return $request->all();
    }
    
    public function update(request $request) 
    {
        $item = Item::find($request->id);
        $item->item = $request->get('item');
        $item->save();
        return redirect('/list');
    }
    
}
