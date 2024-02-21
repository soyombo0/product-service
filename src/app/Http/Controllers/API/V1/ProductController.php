<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Products"},
     *     operationId="getProducts",
     *     summary="Get list of products",
     *     description="Returns list of products",
     *     @OA\Response(response="200", description="An example endpoint"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     * )
     */
    public function index(Request $request, Product $product)
    {
        /** @var User $user */
        $user = auth()->user();
        return ProductResource::collection($user->products()->get());
    }
    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Products"},
     *     operationId="postProducts",
     *     summary="Store product",
     *     description="Store in a product in app",
     *     @OA\Response(response="200", description="An example endpoint"),
     *     @OA\RequestBody(required=true, @OA\JsonContent(@OA\Property(property="name", type="string"))),
     * )
     */
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();
        /** @var Product $product */
        $product = Product::query()->create($data);
        $product->user()->associate(auth()->user());
        $product->save();
        return ProductResource::make($product->fresh());
    }
    /**
     * @OA\Get(
     *     path="/product/{id}",
     *     tags={"Products"},
     *     operationId="showProducts",
     *     summary="Get a certain product",
     *     description="Get a certain product in app",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function show(Request $request, Product $product)
    {
        return ProductResource::make($product);
    }
    /**
     * @OA\Put(
     *     path="/product/{id}",
     *     tags={"Products"},
     *     operationId="updateProducts",
     *     summary="Update a certain product",
     *     description="Update a certain product in app",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request);
        return ProductResource::make($product);
    }
    /**
     * @OA\Delete(
     *     path="/product/{id}",
     *     tags={"Products"},
     *     operationId="deleteProducts",
     *     summary="Delete a certain product",
     *     description="Delete a certain product in app",
     *     @OA\Response(response="200", description="An example endpoint")
     * )
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();
    }
}
