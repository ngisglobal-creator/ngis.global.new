<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Sector;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewProductNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::with(['sector', 'branch', 'category', 'images'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $viewPath = 'factory.products.index';
        if ($user->type == 'company') {
            $viewPath = 'company.products.index';
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.index';
        }

        return view($viewPath, compact('products', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.products.create';
        if ($user->type == 'company') {
            $viewPath = 'company.products.create';
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'));
    }

    public function createCarton()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.products.create';
        if ($user->type == 'company') {
            $viewPath = 'company.products.create';
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'))->with('mode', 'carton');
    }

    public function createSpecial()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.products.create';
        if ($user->type == 'company') {
            $viewPath = 'company.products.create';
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'))->with('mode', 'special');
    }

    public function carCreate()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.cars.create';
        if ($user->type == 'company') {
            $viewPath = 'company.cars.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'));
    }

    public function carCreateLight()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.cars.create';
        if ($user->type == 'company') {
            $viewPath = 'company.cars.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'))->with('mode', 'light');
    }

    public function carCreateHeavy()
    {
        $user = Auth::user();
        $sectors = $user->sectors;
        $allSectors = Sector::all();

        $viewPath = 'factory.cars.create';
        if ($user->type == 'company') {
            $viewPath = 'company.cars.create';
        }

        return view($viewPath, compact('sectors', 'allSectors', 'user'))->with('mode', 'heavy');
    }

    public function show(Product $product)
    {
        $user = Auth::user();
        if ($product->user_id !== $user->id && $user->type !== 'global_forwarding' && !$user->hasRole('admin')) {
            abort(403);
        }

        $product->load(['sector', 'branch', 'category', 'images']);

        $viewBase = $product->vehicle_group ? 'show_vehicle' : 'show';

        $viewPath = 'products.' . $viewBase;
        if ($user->type == 'factory') {
            $viewPath = 'factory.products.' . $viewBase;
        } elseif ($user->type == 'company') {
            $viewPath = 'company.products.' . $viewBase;
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.' . $viewBase;
        } else {
            // Default to factory view for global_forwarding or other types
            $viewPath = 'factory.products.' . $viewBase;
        }

        return view($viewPath, compact('product', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'currency_code' => 'required|string|max:10',
            'custom_info' => 'nullable|string',
            'product_catalog' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp,heic|max:5120',
            'piece_weight' => 'nullable|numeric|min:0',
            'product_piece_count' => 'nullable|integer|min:0',
            'carton_length' => 'nullable|numeric|min:0',
            'carton_height' => 'nullable|numeric|min:0',
            'carton_width' => 'nullable|numeric|min:0',
            'carton_volume_cbm' => 'nullable|numeric|min:0',
            'total_weight' => 'nullable|numeric|min:0',
            'total_cbm' => 'nullable|numeric|min:0',
            'custom_order_id' => 'nullable|exists:custom_sourcing_orders,id',
        ]);

        $unitCbm = $request->carton_volume_cbm ?? 0;
        $qty = $request->product_piece_count ?? 0;
        $unitWeight = $request->piece_weight ?? 0;

        $cartonCbm = $unitCbm * $qty;
        $cartonWeight = $unitWeight * $qty;

        $data = [
            'user_id' => Auth::id(),
            'sector_id' => $request->sector_id,
            'branch_id' => $request->branch_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'min_order_quantity' => $request->min_order_quantity,
            'currency_code' => $request->currency_code,
            'custom_info' => $request->custom_info,
            'product_catalog' => $request->product_catalog,
            'piece_weight' => $request->piece_weight,
            'product_piece_count' => $request->product_piece_count,
            'carton_length' => $request->carton_length,
            'carton_height' => $request->carton_height,
            'carton_width' => $request->carton_width,
            'carton_volume_cbm' => $request->carton_volume_cbm,
            'total_cbm' => $cartonCbm,
            'total_weight' => $cartonWeight,
            'cbm_1_capacity' => ($cartonCbm > 0) ? floor(1 / $cartonCbm) : 0,
            'container_20ft_capacity' => ($cartonCbm > 0) ? floor(28 / $cartonCbm) : 0,
            'container_40ft_capacity' => ($cartonCbm > 0) ? floor(40 / $cartonCbm) : 0,
            'container_40hq_capacity' => ($cartonCbm > 0) ? floor(68 / $cartonCbm) : 0,
            'container_45ft_capacity' => ($cartonCbm > 0) ? floor(78 / $cartonCbm) : 0,
            'custom_order_id' => $request->custom_order_id,
        ];

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Notify Admins
        $admins = User::where('type', 'admin')->get();
        Notification::send($admins, new NewProductNotification($product, Auth::user()));

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('Product added successfully.'),
                'product' => $product
            ]);
        }

        return redirect()->route('products.index')->with('success', __('Product added successfully.'));
    }

    public function edit(Product $product)
    {
        $user = Auth::user();
        if ($product->user_id !== $user->id) {
            abort(403);
        }

        $product->load(['sector', 'branch', 'category', 'images']);
        $sectors = $user->sectors;
        $allSectors = Sector::all();
        $branches = Branch::where('sector_id', $product->sector_id)->get();
        $categories = Category::where('branch_id', $product->branch_id)->get();

        $viewPath = 'factory.products.edit';
        if ($user->type == 'company') {
            $viewPath = 'company.products.edit';
        } elseif ($user->type == 'china') {
            $viewPath = 'china.products.edit';
        }

        return view($viewPath, compact('product', 'sectors', 'allSectors', 'branches', 'categories', 'user'));
    }

    public function update(Request $request, Product $product)
    {
        $user = Auth::user();
        if ($product->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'currency_code' => 'required|string|max:10',
            'custom_info' => 'nullable|string',
            'product_catalog' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'piece_weight' => 'nullable|numeric|min:0',
            'product_piece_count' => 'nullable|integer|min:0',
            'carton_length' => 'nullable|numeric|min:0',
            'carton_height' => 'nullable|numeric|min:0',
            'carton_width' => 'nullable|numeric|min:0',
            'carton_volume_cbm' => 'nullable|numeric|min:0',
            'total_weight' => 'nullable|numeric|min:0',
            'total_cbm' => 'nullable|numeric|min:0',
        ]);

        $unitCbm = $request->carton_volume_cbm ?? 0;
        $qty = $request->product_piece_count ?? 0;
        $unitWeight = $request->piece_weight ?? 0;

        $cartonCbm = $unitCbm * $qty;
        $cartonWeight = $unitWeight * $qty;

        $data = [
            'sector_id' => $request->sector_id,
            'branch_id' => $request->branch_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'min_order_quantity' => $request->min_order_quantity,
            'currency_code' => $request->currency_code,
            'custom_info' => $request->has('custom_info') ? $request->custom_info : $product->custom_info,
            'product_catalog' => $request->has('product_catalog') ? $request->product_catalog : $product->product_catalog,
            'piece_weight' => $request->piece_weight,
            'product_piece_count' => $request->product_piece_count,
            'carton_length' => $request->carton_length,
            'carton_height' => $request->carton_height,
            'carton_width' => $request->carton_width,
            'carton_volume_cbm' => $request->carton_volume_cbm,
            'total_cbm' => $cartonCbm,
            'total_weight' => $cartonWeight,
            'cbm_1_capacity' => ($cartonCbm > 0) ? floor(1 / $cartonCbm) : 0,
            'container_20ft_capacity' => ($cartonCbm > 0) ? floor(28 / $cartonCbm) : 0,
            'container_40ft_capacity' => ($cartonCbm > 0) ? floor(40 / $cartonCbm) : 0,
            'container_40hq_capacity' => ($cartonCbm > 0) ? floor(68 / $cartonCbm) : 0,
            'container_45ft_capacity' => ($cartonCbm > 0) ? floor(78 / $cartonCbm) : 0,
        ];

        $product->update($data);

        // Handle new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Handle deleted images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', __('Product deleted successfully.'));
    }

    // AJAX methods for dynamic dropdowns
    public function getBranches($sector_id)
    {
        $branches = Branch::where('sector_id', $sector_id)->get();
        return response()->json($branches);
    }

    public function getCategories($branch_id)
    {
        $categories = Category::where('branch_id', $branch_id)->get();
        return response()->json($categories);
    }

    public function quickStoreSector(Request $request)
    {
        $request->validate([
            'sector_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
        ]);

        // 1. Create Sector
        $sector = Sector::create([
            'name_ar' => $request->sector_name,
            'name_en' => $request->sector_name,
            'name_zh' => $request->sector_name,
        ]);

        // 2. Create Branch
        $branch = Branch::create([
            'sector_id' => $sector->id,
            'name_ar' => $request->branch_name,
            'name_en' => $request->branch_name,
            'name_zh' => $request->branch_name,
        ]);

        // 3. Create Category
        $category = Category::create([
            'branch_id' => $branch->id,
            'name_ar' => $request->category_name,
            'name_en' => $request->category_name,
            'name_zh' => $request->category_name,
        ]);

        // 4. Assign Sector to User
        Auth::user()->sectors()->attach($sector->id);

        return response()->json([
            'success' => true,
            'sector' => $sector,
            'branch' => $branch,
            'category' => $category
        ]);
    }

    public function quickStoreBranch(Request $request)
    {
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'branch_name' => 'required|string|max:255',
        ]);

        $branch = Branch::create([
            'sector_id' => $request->sector_id,
            'name_ar' => $request->branch_name,
            'name_en' => $request->branch_name,
            'name_zh' => $request->branch_name,
        ]);

        return response()->json([
            'success' => true,
            'branch' => $branch
        ]);
    }

    public function quickStoreCategory(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'branch_id' => $request->branch_id,
            'name_ar' => $request->category_name,
            'name_en' => $request->category_name,
            'name_zh' => $request->category_name,
        ]);

        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }
    public function storeVehicle(Request $request)
    {
        // Validation with all technical fields
        $request->validate([
            'sector_id' => 'required|exists:sectors,id',
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric',
            'currency_code' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|array|min:1',
            // Technical fields
            'piece_weight' => 'nullable|numeric',
            'product_piece_count' => 'nullable|integer',
            'carton_length' => 'nullable|numeric',
            'carton_width' => 'nullable|numeric',
            'carton_height' => 'nullable|numeric',
            'carton_volume_cbm' => 'nullable|numeric',
            'total_cbm' => 'nullable|numeric',
            'total_weight' => 'nullable|numeric',
            // Capacities
            'cap_20ft' => 'nullable|numeric',
            'cap_40ft' => 'nullable|numeric',
            'cap_40hq' => 'nullable|numeric',
            'cap_45ft' => 'nullable|numeric',
            'custom_order_id' => 'nullable|exists:custom_sourcing_orders,id',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'sector_id' => $request->sector_id,
            'branch_id' => $request->branch_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'currency_code' => $request->currency_code,
            'description' => $request->description,
            'piece_weight' => $request->piece_weight,
            'product_piece_count' => $request->product_piece_count,
            'carton_length' => $request->carton_length,
            'carton_width' => $request->carton_width,
            'carton_height' => $request->carton_height,
            'carton_volume_cbm' => $request->carton_volume_cbm,
            'total_cbm' => $request->total_cbm,
            'total_weight' => $request->total_weight,
            'container_20ft_capacity' => $request->cap_20ft,
            'container_40ft_capacity' => $request->cap_40ft,
            'container_40hq_capacity' => $request->cap_40hq,
            'container_45ft_capacity' => $request->cap_45ft,
            'min_order_quantity' => $request->min_order_quantity ?? 1,
            'custom_order_id' => $request->custom_order_id,
        ];
        
        // Capture JSON logistics if sent
        if($request->has('logistics_details')) {
            $logistics = json_decode($request->logistics_details, true);
            $data['logistics_details'] = $logistics;
            $data['vehicle_group'] = $logistics['vehicle_group'] ?? null;
        }

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ المنتج بنجاح وتوجيهه إلى قائمة المنتجات العامة.',
            'product' => $product
        ]);
    }
}
