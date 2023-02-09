<?php

namespace App\Http\Controllers;

use App\Models\Other;
use App\Http\Requests\StoreOtherRequest;
use App\Http\Requests\UpdateOtherRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class OtherController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Other::class, 'other');
    }

    public function index()
    {
        return view('other.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('other.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOtherRequest  $request
     //* @return \Illuminate\Http\Response
     */
    public function store(StoreOtherRequest $request)
    {


        if($path = Storage::put('public/Images', $request->product_photo)){
            $path = substr($path,7,strlen($path));
            Other::query()->create([
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'description' => $request->description,
                'path' => $path
            ]);
        }else{
            return redirect()->route('other.create', ['err' => 'Error occurred']);
        }
        return redirect()->route('other.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function show(Other $other)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Other  $other
     //* @return \Illuminate\Http\Response
     */
    public function edit(Other $other)
    {
        return view('other.edit', ['other' => $other]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOtherRequest  $request
     * @param  \App\Models\Other  $other
     //* @return \Illuminate\Http\Response
     */
    public function update(UpdateOtherRequest $request, Other $other)
    {
        if($request->new_product_photo){
            if(Storage::delete('public/'.$other->path)){
                if($path = Storage::put('public/Images', $request->new_product_photo)){
                    $path = substr($path,7,strlen($path));
                    $other->update([
                        'name' => $request->new_name,
                        'type' => $request->new_type,
                        'price' => $request->new_price,
                        'description' => $request->new_description,
                        'path' => $path
                    ]);
                }
            }
        }else{
            $other->update([
                'name' => $request->new_name,
                'type' => $request->new_type,
                'price' => $request->new_price,
                'description' => $request->new_description,
            ]);
        }
        return redirect()->route('other.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Other  $other
     //* @return \Illuminate\Http\Response
     */
    public function destroy(Other $other)
    {
        $other->delete();
        return redirect()->route('other.index');
    }

    public function getAllProducts(){
        return Other::all();
    }

    public function addProductToOrder(Other $other){
        $order = Session::get('order');
        if($order){
            foreach($order as $o){
                if($o['id'] == $other->id && $o['name'] == $other->name){
                    return ['status' => false];
                }
            }
        }

        $product = $other->toArray();
        $product[] = ["amount" => 1];
        $product[] = ["additions" => []];
        $order[] = $product;
        Session::put('order', $order);
        return ['status' => true];
    }
}
