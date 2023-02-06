<?php

namespace App\Http\Controllers;


use App\Events\newOrderAddedEvent;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderItem;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     //* @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()->where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();

        return view('order.index', ['orders' => $orders]);
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
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     //* @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {

        $order = Session::get('order');
        $user = auth()->user();
        DB::beginTransaction();

        $new_order = Order::query()->create([
            'user_id' => $user->id,
            'total_price' => Session::get('total_price')
        ]);
        if(!$new_order){
            DB::rollBack();
            return redirect()->route('order.show_current', ['message' => 'Error occurred, please try again.']);
        }
        foreach ($order as $item){
            $additions = '';
            foreach ($item[1]['additions'] as $addition){
                $additions = $additions.$addition.', ';
            }
            if(strlen($additions) > 0){
                $additions = substr($additions,0,strlen($additions) - 1);
            }
            $item = OrderItem::query()->create([
                'name' => $item['name'],
                'type' => $item['type'],
                'price' => $item['price'],
                'path' => $item['path'],
                'amount' => $item[0]['amount'],
                'additions' => $additions,
                'order_id' => $new_order->id
            ]);
            if(!$item){
                DB::rollBack();
                return redirect()->route('order.show_current', ['message' => 'Error occurred, please try again.']);
            }
        }

        DB::commit();
        event(new newOrderAddedEvent($user, $order, $new_order->total_price));
        return redirect()->route('order.show_current', ['message' => 'Your order is made successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function increaseAmount(Request $request){
        $order = Session::get('order');

        foreach ($order as &$o){
            if($o['name'] == $request->product_name){
                $o[0]['amount'] += 1;
            }
        }
        Session::put('order', $order);
        return redirect()->route('order.show_current');
    }

    public function decreaseAmount(Request $request){
        $order = Session::get('order');
        foreach ($order as &$o){
            if($o['name'] == $request->product_name){
                $o[0]['amount']--;
            }
        }
        Session::put('order', $order);
        return redirect()->route('order.show_current');
    }

    public function removeProduct(Request $request){
        $order = Session::get('order');
        for($i = 0;$i<count($order);$i++){
            if($order[$i]['name'] == $request->product_name){
                unset($order[$i]);
                $order = array_values($order);
            }
        }
        Session::put('order', $order);
        return redirect()->route('order.show_current');
    }

    public function showCurrentOrder(Request $request){
        $total_price = 0;
        $orders =  Session::get('order');
        if($orders){
            foreach($orders as $o){

                $total_price += ($o[0]['amount'] * $o['price']);
            }
        }

        $message = '';
        if($request->message){
            $message = $request->message;
        }

        Session::put('total_price', $total_price);
        return view('order.show_current', [
            'order_items' => $orders,
            'total_price' => $total_price,
            'message' => $message]);
    }

}
