<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        /** @var User $user */
        $user = auth()->user();
        return ProductResource::collection($user->products()->get());
    }

    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        /** @var Product $product */
        $product = Product::query()->create($data);
        $product->user()->associate(auth()->user());
        $product->save();
        return ProductResource::make($product->fresh());
    }

    public function show(Request $request, Product $product)
    {
        return ProductResource::make($product);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request);
        return ProductResource::make($product);
    }

    public function destroy(Request $request, Product $product)
    {
        $product->delete();
    }
}
