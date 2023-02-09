<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreAdditionRequest;
use App\Models\Snack;
use App\Http\Requests\StoreSnackRequest;
use App\Http\Requests\UpdateSnackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SnackController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Snack::class, 'snack');
    }


    public function index(Request $request)
    {
        $alert = false;
        if($request->show_alert == 1){
            $alert = 'Product added to your bag!';
        }
        return view('snacks.index', ['products' => Snack::all(), 'alert' => $alert]);
    }

    /**
     * Show the form for creating a new resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('snacks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSnackRequest  $request
     //* @return \Illuminate\Http\Response
     */
    public function store(StoreSnackRequest $request)
    {


        if($path = Storage::put('public/Images', $request->snack_photo)){
            $path = substr($path,7,strlen($path));
            Snack::query()->create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'weight' => $request->weight,
                'description' => $request->description,
                'path' => $path
            ]);
        }else{
            return redirect()->route('snack.create', ['error' => 'Error occurred']);
        }
        return redirect()->route('snack.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Snack  $snack
     //* @return \Illuminate\Http\Response
     */
    public function show(Snack $snack)
    {
        return view('snacks.show', ['snack' => $snack, 'additions' => $snack->additions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Snack  $snack
     //* @return \Illuminate\Http\Response
     */
    public function edit(Snack $snack)
    {
        return view('snacks.edit', ['snack' => $snack]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSnackRequest  $request
     * @param  \App\Models\Snack  $snack
     //* @return \Illuminate\Http\Response
     */
    public function update(UpdateSnackRequest $request, Snack $snack)
    {
        if($request->new_snack_photo){
            if(Storage::delete('public/'.$snack->path) && $path = Storage::put('public/Images', $request->new_snack_photo)){
                $path = substr($path,7,strlen($path));
                $snack->update([
                    'name' => $request->new_name,
                    'type' => $request->new_type,
                    'price' => $request->new_price,
                    'weight' => $request->new_weight,
                    'description' => $request->new_description,
                    'path' => $path
                ]);
            }
        }else{
            $snack->update([
                'name' => $request->new_name,
                'type' => $request->new_type,
                'price' => $request->new_price,
                'weight' => $request->new_weight,
                'description' => $request->new_description,
            ]);
        }
        return redirect()->route('snack.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Snack  $snack
     //* @return \Illuminate\Http\Response
     */
    public function destroy(Snack $snack)
    {
        $snack->delete();
        return redirect()->route('snack.index');
    }

    public function getAllProducts(){
        return Snack::all();
    }

    public function addProductToOrder(Snack $snack){
        $order = Session::get('order');
        if($order){
            foreach($order as $o){
                if($o['id'] == $snack->id && $o['name'] == $snack->name){
                    return ['status' => false];
                }
            }
        }

        if($snack->additions && count($snack->additions) > 0){
            return ['status' => 'additions'];
        }
        $product = $snack->toArray();
        $product[] = ["amount" => 1];
        $product[] = ["additions" => []];
        $order[] = $product;
        Session::put('order', $order);
        return ['status' => true];
    }

    public function addAddition(StoreAdditionRequest $request){
        $snack = Snack::query()->where('id', $request->product_id)->first();

        $snack->additions()->create([
            'name' => $request->name
        ]);

        return redirect()->route('addition.index', ['table' => 'snacks']);
    }

    public function addProductWithAdditionsToOrder(Request $request, Snack $snack){
        $order = Session::get('order');
        $additions = [];

        foreach ($snack->additions as $addition){
            $id = ($addition->id);
            if($request->$id == true){
                $additions[] = $addition->name;
            }
        }

        $product = $snack->toArray();
        $add_price = 0;

        if(count($additions) > 3){
            $add_price = (count($additions) - 3) * 0.3;
        }

        $product['price'] += $add_price;
        $product[] = ["amount" => 1];
        $product[] = ["additions" => $additions];
        $order[] = $product;

        Session::put('order', $order);

        return redirect()->route('snack.index', ['show_alert' => true]);


    }
}
