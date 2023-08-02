<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Traits\RedirectTrait;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use RedirectTrait;

    public function index()
    {
        $products = Product::with("section")->paginate();
        return view("Admin.pages.products.index",compact("products"));
    }

    public function create()
    {
        $sections = Section::get();
        return view("Admin.pages.products.create",compact("sections"));
    }

    public function store(StoreProductRequest $request)
    {
        Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "section_id" => $request->section_id,
        ]);

        return $this->redirect("Product Has Been Created Successfully","admin.products.index");

    }

    public function edit(Product $product)
    {
        $sections = Section::get();
        return view("Admin.pages.products.edit",compact("product","sections"));
    }

    public function update(UpdateProductRequest $request , Product $product)
    {
        $product->update([
            "name" => $request->name,
            "description" => $request->description,
            "section_id" => $request->section_id,
        ]);

        return $this->redirect("Section Has Been Updated Successfully","admin.products.index");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return $this->redirect("Product Has Been Deleted Successfully","admin.products.index");
    }


}

