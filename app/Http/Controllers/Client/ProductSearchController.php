<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sector;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSearchController extends Controller
{
    public function publicAllProducts(Request $request)
    {
        $query = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images']);

        // Filtering
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());
        $sectors = Sector::all();

        return view('home.products_listing', compact('allProducts', 'sectors'));
    }

    public function publicNgisProducts(Request $request)
    {
        $query = Product::whereHas('user', function($q) {
            $q->where('type', 'china');
        })->with(['user.verifications', 'sector', 'branch', 'category', 'images', 'user.country']);

        // Filtering
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());
        $sectors = Sector::all();
        
        // Fetch NGIS users (offices)
        $ngisUsers = \App\Models\User::where('type', 'china')->with('country')->get();

        return view('home.ngis_products', compact('allProducts', 'sectors', 'ngisUsers'));
    }

    public function publicFactoryProducts(Request $request)
    {
        $query = Product::whereHas('user', function($q) {
            $q->where('type', 'factory');
        })->with(['user.verifications', 'sector', 'branch', 'category', 'images', 'user.country']);

        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());
        $sectors = Sector::all();

        return view('home.factory_products', compact('allProducts', 'sectors'));
    }

    public function publicSupplierProducts(Request $request)
    {
        $query = Product::whereHas('user', function($q) {
            $q->where('type', 'company');
        })->with(['user.verifications', 'sector', 'branch', 'category', 'images', 'user.country']);

        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());
        $sectors = Sector::all();

        return view('home.supplier_products', compact('allProducts', 'sectors'));
    }

    public function publicContact()
    {
        return view('home.contact');
    }

    public function publicShipping()
    {
        return view('home.shipping');
    }

    public function index(Request $request)
    {
        $query = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images']);

        // Filtering
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());

        // Recommended Products (based on client's selected sectors)
        $userSectors = Auth::user()->sectors->pluck('id');
        $recommendedProducts = Product::whereIn('sector_id', $userSectors)
            ->with(['user', 'sector', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $sectors = Sector::all();

        return view('client.products.index', compact('allProducts', 'recommendedProducts', 'sectors'));
    }

    public function show($id)
    {
        $product = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images'])->findOrFail($id);

        // Related Products (same sector, excluding current)
        $relatedProducts = Product::where('sector_id', $product->sector_id)
            ->where('id', '!=', $product->id)
            ->with(['user', 'sector', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $view = 'client.products.show';
        if ($product->vehicle_group === 'light') {
            $view = 'client.products.show_light';
        } elseif ($product->vehicle_group === 'heavy') {
            $view = 'client.products.show_heavy';
        }

        return view($view, compact('product', 'relatedProducts'));
    }

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

    public function publicProducts(Request $request)
    {
        $query = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images']);

        // Filtering
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $allProducts = $query->latest()->paginate(12)->appends($request->all());

        // For public, we can either show no recommended products or show some general latest products
        // Exclude NGIS (china) products from the general showcase
        $recommendedProducts = Product::whereHas('user', function($q) {
            $q->where('type', '!=', 'china');
        })
        ->with(['user.verifications', 'sector', 'images'])
        ->latest()
        ->take(6)
        ->get();

        // NGIS (China) Products
        $ngisProducts = Product::whereHas('user', function($q) {
            $q->where('type', 'china');
        })
        ->with(['user.verifications', 'sector', 'images', 'user.country'])
        ->latest()
        ->take(10)
        ->get();

        $sectors = Sector::all();

        return view('welcome', compact('allProducts', 'recommendedProducts', 'ngisProducts', 'sectors'));
    }

    public function publicShow($id)
    {
        $product = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images'])->findOrFail($id);

        $relatedProducts = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images'])
            ->where('sector_id', $product->sector_id)
            ->where('id', '!=', $product->id)
            ->take(5)
            ->get();

        $view = 'home.product_details';
        if ($product->vehicle_group === 'light') {
            $view = 'home.product_details_light';
        } elseif ($product->vehicle_group === 'heavy') {
            $view = 'home.product_details_heavy';
        }

        return view($view, compact('product', 'relatedProducts'));
    }

    public function publicProfile(Request $request, $id)
    {
        $user = \App\Models\User::with(['verifications', 'country', 'news' => function($q) {
            $q->latest();
        }])->findOrFail($id);
        
        $query = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images'])
            ->where('user_id', $id);

        // Filtering
        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->sector_id);
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $perPage = $user->profile_products_count ?? 12;
        $allProducts = $query->latest()->paginate($perPage)->appends($request->all());
        $sectors = Sector::all();

        return view('home.profile_details', compact('user', 'allProducts', 'sectors'));
    }

    public function editProfile($id)
    {
        $user = \App\Models\User::with('news')->findOrFail($id);
        
        // Ensure only owner can edit
        if (Auth::id() != $user->id) {
            return redirect()->route('home.profile', $id)->with('error', 'Unauthorized');
        }

        $query = Product::with(['user.verifications', 'sector', 'branch', 'category', 'images'])
            ->where('user_id', $id);
        
        $allProducts = $query->latest()->paginate($user->profile_products_count ?? 12);
        $sectors = Sector::all();

        return view('home.profile_edit', compact('user', 'allProducts', 'sectors'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Ensure only owner can edit
        if (Auth::id() != $user->id) {
            return redirect()->route('home.profile', $id)->with('error', 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'profile_video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480', // Max 20MB video
            'about_ar' => 'nullable|string',
            'about_en' => 'nullable|string',
            'profile_products_count' => 'required|integer|min:1|max:50',
            
            // News/Ad validation
            'news_type' => 'nullable|required_with:news_title_ar|in:news,advertisement,promotion',
            'news_title_ar' => 'nullable|required_with:news_content_ar|string|max:255',
            'news_title_en' => 'nullable|string|max:255',
            'news_content_ar' => 'nullable|required_with:news_title_ar|string',
            'news_content_en' => 'nullable|string',
            'news_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'news_video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:256000', // Support up to 250MB
        ]);

        $data = $request->only(['name', 'about_ar', 'about_en', 'profile_products_count']);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        // Handle Gallery Images
        if ($request->hasFile('gallery_images')) {
            $gallery = $user->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $image->store('galleries', 'public');
            }
            $data['gallery_images'] = $gallery;
        }

        // Handle Profile Video
        if ($request->hasFile('profile_video')) {
            if ($user->profile_video) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_video);
            }
            $videoPath = $request->file('profile_video')->store('videos', 'public');
            $data['profile_video'] = $videoPath;
        }

        $user->update($data);

        // Handle News/Ad Creation
        if ($request->filled('news_title_ar') && $request->filled('news_content_ar')) {
            $newsImages = [];
            if ($request->hasFile('news_images')) {
                foreach ($request->file('news_images') as $image) {
                    $newsImages[] = $image->store('news', 'public');
                }
            }

            $newsVideo = null;
            if ($request->hasFile('news_video')) {
                $newsVideo = $request->file('news_video')->store('news_videos', 'public');
            }

            \App\Models\UserNews::create([
                'user_id' => $user->id,
                'type' => $request->news_type,
                'title_ar' => $request->news_title_ar,
                'title_en' => $request->news_title_en,
                'content_ar' => $request->news_content_ar,
                'content_en' => $request->news_content_en,
                'images' => $newsImages,
                'video' => $newsVideo,
            ]);
        }

        return redirect()->route('home.profile', $id)->with('success', 'Profile updated successfully');
    }
}
