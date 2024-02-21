<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        return OrderResource::collection($user->orders()->get());
    }

    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        /** @var Order $order */
        $order = Order::query()->create($data);
        $order->user()->associate(auth()->user());
        $order->save();
        return OrderResource::make($order->fresh());
    }


    public function show(Request $request, Order $order)
    {
        return OrderResource::make($order);
    }


    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());
        return OrderResource::make($order);
    }


    public function destroy(Request $request,Order $order)
    {
        $order->delete();
    }
}
