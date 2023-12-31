<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Status;
use App\Models\Store;
use App\Models\Transaction;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Store::where('user_id', auth()->user()->id)->count() == 0){
            return redirect()->route('staff.store.create');
        }
        $user = auth()->user();
        $products = Product::with('category')->where('store_id', $user->store->id)
            ->when(request('search'), function($query){
                $query->where('name', 'LIKE', '%'.request('search').'%');
            })->when(request('status'), function($query){
                $query->where('status_id', request('status'));
            })->when(request('category'), function($query){
                $query->where('category_id', request('category'));
            })->orderBy('id', 'DESC')
            ->paginate(10);
        $categories = Category::all();
        $statuses = Status::whereIn('id', [1,2])->get();
        return view('staff.product.index', compact(['products', 'categories', 'statuses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('staff.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $image =  $request->file('image')->store('/public/images/products');
        Product::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'amount'=>$request->amount,
            'image'=>Storage::url($image),
            'description'=>$request->description,
            'status_id'=>$request->status,
            'store_id'=>auth()->user()->store->id,
            'category_id'=>$request->category,
        ]);

        Session::flash('message', 'Producto creado exitosamente.');

        return redirect()->route('staff.products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $category = Category::find($product->category_id);
        return view('staff.product.show', compact(['product', 'category']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('staff.product.edit', compact(['product', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if($request->image){
            $image =  $request->file('image')->store('/public/images/products');
            $product->update([
                'name'=>$request->name,
                'price'=>$request->price,
                'amount'=>$request->amount,
                'image'=>Storage::url($image),
                'description'=>$request->description,
                'status_id'=>$request->status,
                'store_id'=>auth()->user()->store->id,
                'category_id'=>$request->category,
            ]);
    
        }else {
            $product->update([
                'name'=>$request->name,
                'price'=>$request->price,
                'amount'=>$request->amount,
                // 'image'=>Storage::url($image),
                'description'=>$request->description,
                'status_id'=>$request->status,
                'store_id'=>auth()->user()->store->id,
                'category_id'=>$request->category,
            ]);
        }

        Session::flash('message', 'Producto actualizado correctamente');
        return redirect()->route('staff.products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function getAll(){
        $products = Product::with('category')
            ->when(request('limit'), function($query){
            $query->inRandomOrder()->limit(request('limit'));
        })->where('status_id', 1)
        ->get();

        return response($products);
    }

    public function showProduct(Product $product){
        return view('client.product', compact('product'));
    }

    public function showProducts(){

        $categories = Category::select('categories.id', 'categories.name')
        ->withCount(['products'=>function($query){
            $query->where('status_id',1);
        }])->get();

        $products = Product::inRandomOrder()
            ->limit(20)
            ->with('category:id,name')
            ->where('status_id', 1)
            ->get();

        return view('client.shop', compact(['categories', 'products']));
    }

    public function showProductsByCategories(){

        $products = Product::when(!empty(request('categories')), function($query){
            $query->whereIn('category_id', request('categories'));
        })->when(!empty(request('sort')), function($query){
            if(request('sort')=='desc'){
                $query->orderBy('price', 'DESC');
            }else{
                $query->orderBy('price', 'ASC');
            }
        })->inRandomOrder()
        ->where('status_id', 1)
        ->limit(20)
        ->with('category:id,name')
        ->get();

        return response($products);
    }

    public function showProductByCategory(Category $category){

        $products = Product::where('category_id', $category->id)
            ->where('status_id', 1)
            ->get();

        $count = Category::where('id', $category->id)
            ->withCount(['products'=>function($query){
                $query->where('status_id', 1);
            }])
            ->get();

        return view('client.products-by-category', compact(['products', 'category', 'count']));
    }

    public function showProductsByStore(Store $store){
        $products = Product::where('store_id', $store->id)
            ->where('status_id', 1)
            ->get();
        return view('client.products-by-stores', compact(['products', 'store']));
    }

    public function search(){
        $products = Product::select(['id', 'name', 'price', 'image'])
            ->where('status_id', 1)
            ->when(request('search'), function($query){
                $query->where('name', 'LIKE', '%'.request('search').'%');
            })->limit(10)
            ->get();

        return response($products);
    }

    public function payment(Product $product){

        if(auth()->check()){

            if (request('transaction')) {
                $transaction = request('transaction');
            } else {
                $transaction = Transaction::create([
                    'user_id'=>auth()->user()->id,
                    'store_id'=>$product->store_id,
                    'product_id'=>$product->id,
                    'status_id'=>2,
                    'amount'=>1,
                    'pay'=>$product->price,
                ]);
            }

            return view('client.payment', compact(['product', 'transaction']));

        }
        return redirect()->route('login');

    }
}
