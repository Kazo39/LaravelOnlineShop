<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdditionRequest;
use App\Models\Food;
use App\Http\Requests\StoreFoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alert = false;
        if($request->show_alert == 1){
            $alert = 'Product added to your bag!';
        }
        return view('food.index', ['products' => Food::all(), 'alert' => $alert]);
    }

    /**
     * Show the form for creating a new resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->is_admin){
            return redirect()->route('food.index');
        }
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFoodRequest  $request
     //* @return \Illuminate\Http\Response
     */
    public function store(StoreFoodRequest $request)
    {
        if(!auth()->user()->is_admin){
            return redirect()->route('food.index');
        }

        if($path = Storage::put('public/Images', $request->meal_photo)){
            $path = substr($path,7,strlen($path));
            Food::query()->create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'weight' => $request->weight,
                'description' => $request->description,
                'path' => $path
            ]);
        }else{
            return redirect()->route('food.create', ['err' => 'Error occurred']);
        }
        return redirect()->route('food.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     //* @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        return view('food.show', ['food' => $food, 'additions' => $food->additions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     //* @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        return view('food.edit', ['food' => $food]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFoodRequest  $request
     * @param  \App\Models\Food  $food
     //* @return \Illuminate\Http\Response
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        if($request->new_meal_photo){
            if( Storage::delete('public/'.$food->path) && ($path = Storage::put('public/Images', $request->new_meal_photo)) ){
                $path = substr($path,7,strlen($path));
                $food->update([
                    'name' => $request->new_name,
                    'type' => $request->new_type,
                    'price' => $request->new_price,
                    'weight' => $request->new_weight,
                    'description' => $request->new_description,
                    'path' => $path
                ]);
            }
        }else{
            $food->update([
                'name' => $request->new_name,
                'type' => $request->new_type,
                'price' => $request->new_price,
                'weight' => $request->new_weight,
                'description' => $request->new_description,
            ]);
        }
        return redirect()->route('food.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     //* @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('food.index');
    }

    public function getAllProducts(){
        return Food::all();
    }

    public function addProductToOrder(Food $food){
        $order = Session::get('order');
        if($order){
            foreach($order as $o){
                if($o['id'] == $food->id && $o['name'] == $food->name){
                    return ['status' => false];
                }
            }
        }

        if(count($food->additions) > 0){
            return ['status' => 'additions'];
        }

        $product = $food->toArray();
        $product[] = ["amount" => 1];
        $product[] = ["additions" => []];
        $order[] = $product;
        Session::put('order', $order);
        return ['status' => true];
    }

    public function addAddition(StoreAdditionRequest $request){
        $food = Food::query()->where('id', $request->product_id)->get();
        foreach ($food as $f){
            $foodM = $f;
        }

        $foodM->additions()->create([
           'name' => $request->name,
        ]);

        return redirect()->route('addition.index', ['table' => 'food']);
    }

    public function addProductWithAdditionsToOrder(Request $request, Food $food){
        $order = Session::get('order');
        $additions = [];
        foreach ($food->additions as $addition){
            $id = ($addition->id);
            if($request->$id == true){
                $additions[] = $addition->name;
           }
        }
        $product = $food->toArray();

        $add_price = 0;
        if(count($additions) > 3){
            $add_price = (count($additions) - 3) * 0.3;
        }
        $product['price'] += $add_price;

        $product[] = ["amount" => 1];
        $product[] = ["additions" => $additions];
        $order[] = $product;

        Session::put('order', $order);

        return redirect()->route('food.index', ['show_alert' => true]);


    }

}
