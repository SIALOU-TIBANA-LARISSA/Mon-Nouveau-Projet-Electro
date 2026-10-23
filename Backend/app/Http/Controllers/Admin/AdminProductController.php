<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductExample;


class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,avif|max:2048',
            'examples.*' => 'mimes:jpg,jpeg,png,avif|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'promo_price' => 'nullable|numeric|lt:price',

        ]);

    $imagePath = '/images/products/default.avif';

    if ($request->hasFile('image')) {

    $file = $request->file('image');

    $fileName = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('images/products'), $fileName);

    $imagePath = '/images/products/' . $fileName;
   }


        $product = Product::create([
    'name' => $request->name,
    'slug' => Str::slug($request->name),
    'sku' => strtoupper(Str::random(8)), // ✅ génération automatique
    'price' => $request->price,
    'description' => $request->description,
    'category_id' => $request->category_id,
    'is_published' => true,
    'stock_quantity' => 10,
    'main_image_url' => $imagePath,
    'promo_price' => $request->promo_price,

     ]);


     // 🔹 GESTION STL
if ($request->hasFile('stl_file')) {

    $stl = $request->file('stl_file');
    $stlName = time().'_stl.'.$stl->getClientOriginalExtension();
    $stl->move(public_path('stl'), $stlName);

    $product->stl_path = 'stl/'.$stlName;
}

// 🔹 GESTION SVG
if ($request->hasFile('svg_file')) {

    $svg = $request->file('svg_file');
    $svgName = time().'_svg.'.$svg->getClientOriginalExtension();
    $svg->move(public_path('svg'), $svgName);

    $product->svg_path = 'svg/'.$svgName;
}
// 🔹 GESTION DXF
if ($request->hasFile('dxf_file')) {

    $dxf = $request->file('dxf_file');
    $dxfName = time().'_dxf.'.$dxf->getClientOriginalExtension();
    $dxf->move(public_path('dxf'), $dxfName);

    $product->dxf_path = 'dxf/'.$dxfName;
}


$product->save();

     // Upload des images exemples
if ($request->hasFile('examples')) {

    foreach ($request->file('examples') as $file) {

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/customization-examples'), $fileName);

        ProductExample::create([
            'product_id' => $product->id,
            'image_path' => '/images/customization-examples/' . $fileName,
        ]);
    }
}


     // Création automatique du dossier d'exemples
$slug = Str::slug($request->name);

$examplePath = public_path('images/customization-examples/' . $slug);

if (!file_exists($examplePath)) {
    mkdir($examplePath, 0777, true);
}




        return redirect()->route('admin.products')
            ->with('success', 'Produit ajouté avec succès');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $product->sku ?? strtoupper(Str::random(8)),
            'price' => $request->price,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'stock_quantity' => $request->stock_quantity,
            'promo_price' => $request->promo_price,
        ]);

        if ($request->hasFile('examples')) {

    foreach ($request->file('examples') as $file) {

        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/customization-examples'), $fileName);

        \App\Models\ProductExample::create([
            'product_id' => $product->id,
            'image_path' => '/images/customization-examples/' . $fileName,
        ]);
    }

        }

        // 🔹 UPDATE STL
if ($request->hasFile('stl_file')) {

    if ($product->stl_path && file_exists(public_path($product->stl_path))) {
        unlink(public_path($product->stl_path));
    }

    $stl = $request->file('stl_file');
    $stlName = time().'_stl.'.$stl->getClientOriginalExtension();
    $stl->move(public_path('stl'), $stlName);

    $product->stl_path = 'stl/'.$stlName;
}

// 🔹 UPDATE SVG
if ($request->hasFile('svg_file')) {

    if ($product->svg_path && file_exists(public_path($product->svg_path))) {
        unlink(public_path($product->svg_path));
    }

    $svg = $request->file('svg_file');
    $svgName = time().'_svg.'.$svg->getClientOriginalExtension();
    $svg->move(public_path('svg'), $svgName);

    $product->svg_path = 'svg/'.$svgName;
}

// 🔹 UPDATE DXF
if ($request->hasFile('dxf_file')) {

    if ($product->dxf_path && file_exists(public_path($product->dxf_path))) {
        unlink(public_path($product->dxf_path));
    }

    $dxf = $request->file('dxf_file');
    $dxfName = time().'_dxf.'.$dxf->getClientOriginalExtension();
    $dxf->move(public_path('dxf'), $dxfName);

    $product->dxf_path = 'dxf/'.$dxfName;
}


// 🔹 UPDATE IMAGE PRINCIPALE
if ($request->hasFile('main_image')) {

    if ($product->main_image_url && file_exists(public_path($product->main_image_url))) {
        unlink(public_path($product->main_image_url));
    }

    $file = $request->file('main_image');
    $fileName = time().'_'.$file->getClientOriginalName();
    $file->move(public_path('images/products'), $fileName);

    $product->main_image_url = '/images/products/'.$fileName;
}

$product->save();
        
    return redirect()->route('admin.products')
            ->with('success', 'Produit modifié avec succès');
    }

    public function destroy(Product $product)
    {
    if ($product->orderItems()->count() > 0) {
        return redirect()->route('admin.products')
            ->with('error', 'Impossible de supprimer ce produit car il est utilisé dans une commande.');
    }

    $product->delete();

    return redirect()->route('admin.products')
        ->with('success', 'Produit supprimé avec succès');
}

 public function deleteExample($id)
{
    $example = ProductExample::findOrFail($id);

    if ($example->image_path && file_exists(public_path($example->image_path))) {
        unlink(public_path($example->image_path));
    }

    $example->delete();

    return redirect()->back()->with('success', 'Image supprimée avec succès');
}


}  