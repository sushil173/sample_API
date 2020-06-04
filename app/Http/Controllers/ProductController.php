<?php

namespace App\Http\Controllers;

use DB;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'qty.regex' =>'Quantity must be integer.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'qty' => 'required|regex:/^\d+$/',
            'virtual' => 'required'
        ],$messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(["error" => TRUE, "message" => $errors], 400);
        } 
        DB::beginTransaction();
        try{
        $product= Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'qty' => $request->qty,
            'virtual' => $request->virtual
        ]);
        DB::commit();
        return response(["error" => false, "data" => $product, "message" => "Product saved "], 200);
        } catch(\Exception $e){
            DB::rollBack();
            return response(["error" => True, "data" => Null, "message" => "Product saving failed: ". $e ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
