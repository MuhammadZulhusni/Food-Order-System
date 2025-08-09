<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;
use App\Models\Product;
use App\Models\City;
use App\Models\Client;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\Gllery; 
use App\Models\Banner;

class ManageController extends Controller
{
    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\View\View
     */
    public function AdminAllProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.product.all_product', compact('product'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function AdminAddProduct()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        return view('admin.backend.product.add_product', compact('category', 'city', 'menu', 'client'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AdminStoreProduct(Request $request)
    {
        // Generate a unique product code
        $pcode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 5, 'prefix' => 'PC']);

        // Handle image upload if a file is present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            // Create the new product with the uploaded image
            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'code' => $pcode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => $request->client_id,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
                'image' => $save_url,
            ]);
        } else {
            // Create the new product without an image
            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'code' => $pcode,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'client_id' => $request->client_id,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'status' => 1,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.all.product')->with($notification);
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function AdminEditProduct($id)
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        $product = Product::findOrFail($id);
        return view('admin.backend.product.edit_product', compact('category', 'city', 'menu', 'product', 'client'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AdminUpdateProduct(Request $request)
    {
        $pro_id = $request->id;
        $product = Product::findOrFail($pro_id);

        // Check if a new image has been uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            // Upload and save the new image
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;

            // Update the product with the new image
            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'client_id' => $request->client_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
                'image' => $save_url,
            ]);
        } else {
            // Update the product without changing the image
            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
                'client_id' => $request->client_id,
                'qty' => $request->qty,
                'size' => $request->size,
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'most_populer' => $request->most_populer,
                'best_seller' => $request->best_seller,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = [
            'message' => 'Product Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.all.product')->with($notification);
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function AdminDeleteProduct($id)
    {
        $item = Product::findOrFail($id);

        // Delete the associated image file from the server
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        // Delete the product from the database
        $item->delete();

        $notification = [
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    // FOR ALL Pending and Approve Restaurant method 
    /**
     * Display a list of pending restaurants (clients with status 0).
     *
     * @return \Illuminate\View\View
     */
    public function PendingRestaurant(){
        $client = Client::where('status',0)->get();
        return view('admin.backend.restaurant.pending_restaurant',compact('client')); 
    }

    /**
     * Change the status of a client (restaurant) via an AJAX request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ClientChangeStatus(Request $request){
        $client = Client::find($request->client_id);
        $client->status = $request->status;
        $client->save();
        return response()->json(['success' => 'Status Change Successfully']);
    }

    /**
     * Display a list of approved restaurants (clients with status 1).
     *
     * @return \Illuminate\View\View
     */
    public function ApproveRestaurant(){
        $client = Client::where('status',1)->get();
        return view('admin.backend.restaurant.approve_restaurant',compact('client')); 
    }

    // Display all banners
    public function AllBanner(){
        // Retrieve all banners from the database, ordered by the latest first
        $banner = Banner::latest()->get();
        return view('admin.backend.banner.all_banner',compact('banner'));
    }

    // Store a new banner
    public function BannerStore(Request $request){
        // Check if an image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            // Initialize the Image Manager with a Driver
            $manager = new ImageManager(new Driver());
            // Generate a unique name for the image file
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            // Read the image, resize it to 400x400, and save it to the specified public path
            $img = $manager->read($image);
            $img->resize(400,400)->save(public_path('upload/banner/'.$name_gen));
            // Construct the URL path to the saved image
            $save_url = 'upload/banner/'.$name_gen;

            // Create a new banner record in the database with the provided URL and image path
            Banner::create([
                'url' => $request->url,
                'image' => $save_url, 
            ]); 
        } 

        $notification = array(
            'message' => 'Banner Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    // Retrieve a specific banner for editing
    public function EditBanner($id){
        $banner = Banner::find($id);
        // If the banner is found, construct its full public asset URL
        if ($banner) {
            $banner->image = asset($banner->image);
        }
        // Return the banner data as a JSON response
        return response()->json($banner);
    }

    // Update an existing banner
    public function BannerUpdate(Request $request){
        $banner_id = $request->banner_id;

        // Check if a new image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            // Initialize the Image Manager
            $manager = new ImageManager(new Driver());
            // Generate a new unique name for the image
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            // Read the image, resize it, and save it
            $img = $manager->read($image);
            $img->resize(400,400)->save(public_path('upload/banner/'.$name_gen));
            $save_url = 'upload/banner/'.$name_gen;

            // Find and update the banner record with the new URL and image path
            Banner::find($banner_id)->update([
                'url' => $request->url,
                'image' => $save_url, 
            ]); 
            
            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);
        } else {
            // If no new image was uploaded, update only the URL
            Banner::find($banner_id)->update([
                'url' => $request->url, 
            ]); 

            $notification = array(
                'message' => 'Banner Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('all.banner')->with($notification);
        }
    }

    // Delete a banner
    public function DeleteBanner($id){
        // Find the banner by its ID
        $item = Banner::find($id);
        // Get the image path
        $img = $item->image;
        // Delete the image file from the server
        unlink($img);

        // Delete the banner record from the database
        Banner::find($id)->delete();

        // Prepare a success notification for the deletion
        $notification = array(
            'message' => 'Banner Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
