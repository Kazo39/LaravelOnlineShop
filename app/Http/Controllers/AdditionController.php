<?php

namespace App\Http\Controllers;

use App\Models\Addition;
use App\Http\Requests\StoreAdditionRequest;
use App\Http\Requests\UpdateAdditionRequest;
use App\Models\Food;
use App\Models\Snack;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class AdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $additions = [];
        if($request->table == 'food'){
            $products = Food::all();
            foreach ($products as $f){
                $add = $f->additions;
                if(count($add) > 0){
                    foreach ($add as $a){
                        $additions[] = $a;
                    }
                }
            }
        }else{
            $products = Snack::all();
            foreach ($products as $s){
                $add = $s->additions;
                if(count($add) > 0){
                    foreach ($add as $a){
                        $additions[] = $a;
                    }
                }
            }
        }

        return view($request->table.'.additions', ['additions'=>$additions, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdditionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function show(Addition $addition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function edit(Addition $addition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdditionRequest  $request
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdditionRequest $request, Addition $addition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addition  $addition
     //* @return \Illuminate\Http\Response
     */
    public function destroy(Addition $addition)
    {
        $addition->delete();
        return redirect(\Illuminate\Support\Facades\Session::previousUrl());
    }
}
