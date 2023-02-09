<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Http\Requests\StoreDrinkRequest;
use App\Http\Requests\UpdateDrinkRequest;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DrinkController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Drink::class, 'drink');
    }

    public function index()
    {
        return view('drinks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('drinks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDrinkRequest  $request
     //* @return \Illuminate\Http\Response
     */
    public function store(StoreDrinkRequest $request)
    {


        if($path = Storage::put('public/Images', $request->drink_photo)){
            $path = substr($path,7,strlen($path));
            Drink::query()->create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'weight' => $request->weight,
                'description' => $request->description,
                'path' => $path
            ]);
        }else{
            return redirect()->route('drink.create', ['err' => 'Error occurred']);
        }
        return redirect()->route('drink.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function show(Drink $drink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Drink  $drink
     //* @return \Illuminate\Http\Response
     */
    public function edit(Drink $drink)
    {
        return view('drinks.edit', ['drink' => $drink]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDrinkRequest  $request
     * @param  \App\Models\Drink  $drink
     //* @return \Illuminate\Http\Response
     */
    public function update(UpdateDrinkRequest $request, Drink $drink)
    {
        if($request->new_drink_photo){
            if( Storage::delete('public/'.$drink->path) && $path = Storage::put('public/Images', $request->new_drink_photo) ){
                $path = substr($path,7,strlen($path));
                $drink->update([
                    'name' => $request->new_name,
                    'type' => $request->new_type,
                    'price' => $request->new_price,
                    'weight' => $request->new_weight,
                    'description' => $request->new_description,
                    'path' => $path
                ]);
            }
        }else{
            $drink->update([
                'name' => $request->new_name,
                'type' => $request->new_type,
                'price' => $request->new_price,
                'weight' => $request->new_weight,
                'description' => $request->new_description,
            ]);
        }
        return redirect()->route('drink.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drink  $drink
     //* @return \Illuminate\Http\Response
     */
    public function destroy(Drink $drink)
    {
        $drink->delete();
        return redirect()->route('drink.index');
    }

    public function getAllProducts(){
        return Drink::all();
    }

    public function addProductToOrder(Drink $drink){
        $order = Session::get('order');
        if($order){
            foreach($order as $o){
                if($o['id'] == $drink->id && $o['name'] == $drink->name){
                    return ['status' => false];
                }
            }
        }

        $product = $drink->toArray();
        $product[] = ["amount" => 1];
        $product[] = ["additions" => []];
        $order[] = $product;
        Session::put('order', $order);
        return ['status' => true];
    }
}
