<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Class constructor to initialize middleware for request authorization and permissions.
     *
     * Applies authentication middleware to all controller actions to ensure only authenticated users have access.
     * Configures specific permission checks for various actions within the controller:
     * - 'view-product', 'create-product', 'edit-product', 'delete-product' for 'index' and 'show' methods.
     * - 'create-product' for 'create' and 'store' methods.
     * - 'edit-product' for 'edit' and 'update' methods.
     * - 'delete-product' for the 'destroy' method.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-product|create-product|edit-product|delete-product', ['only' => ['index','show']]);
        $this->middleware('permission:create-product', ['only' => ['create','store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    /**
     * Displays a list of products.
     *
     * @return View Returns a view containing a paginated list of the latest products.
     */
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(3)
        ]);
    }

    /**
     * Displays the form for creating a new product.
     *
     * @return View Returns the view for the product creation form.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Handles the storage of a newly created product.
     *
     * @param StoreProductRequest $request The incoming request instance containing the product data.
     * @return RedirectResponse Returns a redirect response to the products index route with a success message.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->all());
        return redirect()->route('products.index')
                ->withSuccess('New product is added successfully.');
    }

    /**
     * Displays the details of the specified product.
     *
     * @param Product $product The product instance to be displayed.
     * @return View Returns a view instance representing the product details page.
     */
    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Displays the form for editing the specified product.
     *
     * @param Product $product The product entity to be edited.
     * @return View Returns the view for editing the product, with the product data passed to it.
     */
    public function edit(Product $product): View
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Updates the specified product with the provided data.
     *
     * @param UpdateProductRequest $request The incoming request instance containing the updated product data.
     * @param Product $product The product instance to be updated.
     * @return RedirectResponse Returns a redirect response back to the previous page with a success message.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->all());
        return redirect()->back()->
            withSuccess('Product is updated successfully.');
    }

    /**
     * Handles the deletion of a specified product.
     *
     * @param Product $product The product instance to be deleted.
     * @return RedirectResponse Returns a redirect response to the products index route with a success message.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
                ->withSuccess('Product is deleted successfully.');
    }
}
