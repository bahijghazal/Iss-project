<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Helpers\AuditLogHelper;


class ProductController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']); // only logged-in users can access
    }

    public function index() {
        $products = Product::paginate(10);

        // Log
        AuditLogHelper::log('Viewed product list');

        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'private');
        }

        $product = Product::create($data);

        AuditLogHelper::log('Created a product', [
            'product_id' => $product->id,
            'name' => $product->name,
        ]);
       

        return redirect()->route('products.index')->with('success', 'Product created!');
    }


    public function edit(Product $product) {
        return view('products.edit', compact('product'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        AuditLogHelper::log('Updated a product', [
            'product_id' => $product->id,
            'changes' => $data,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated!');
    }


    public function destroy(Product $product) {
        AuditLogHelper::log('product_deleted', [
        'product_id' => $product->id,
        'name' => $product->name,
    ]);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted!');

    }

    public function displayImage($filename)
    {
        $path = "products/" . $filename;

        if (!Storage::disk('private')->exists($path)) {
            AuditLogHelper::log('file_missing', [
            'filename' => $filename
        ]);
            abort(404);
        }

        $file = Storage::disk('private')->get($path);
        $type = Storage::disk('private')->mimeType($path);

        return response($file)->header('Content-Type', $type);
    }

}

