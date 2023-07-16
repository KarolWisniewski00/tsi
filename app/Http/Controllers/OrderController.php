<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        return view('order.index');
    }
    public function create(){
        return view('order.create');
    }
    public function store(request $request){
    }
    public function show($slug){
        return view();
    }
    public function edit($slug){
        return view();
    }
    public function update(request $request,$slug){
        
    }
    public function delete($slug){
        //if ($result) {
        //    return redirect()->route('')->with('success', 'Utworzono nowy samochód!');
        //} else {
        //    return redirect()->route('')->with('fail', 'Nie udało się utworzyć nowego samochodu!');
        //}
    }
}
