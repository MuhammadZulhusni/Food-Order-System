<?php

namespace App\Http\Controllers\Client;

use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Models\Category; 
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use App\Models\Gllery;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;


class RestaurantController extends Controller
{
    /**
     * Display a listing of all menu items.
     */
    public function AllMenu()
    {
        $id = Auth::guard('client')->id();
        $menu = Menu::where('client_id',$id)->orderBy('id','desc')->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function AddMenu()
    {
        return view('client.backend.menu.add_menu');
    }

    /**
     * Store a newly created menu item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function StoreMenu(Request $request)
    {
        // Check if an image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            // Generate a unique name for the image
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            // Read, resize, and save the image
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            // Construct the URL for the saved image
            $save_url = 'upload/menu/' . $name_gen;

            // Create a new menu item record in the database
            Menu::create([
                'menu_name' => $request->menu_name,
                'client_id' => Auth::guard('client')->id(),
                'image' => $save_url,
            ]);
        }

        $notification = [
            'message' => 'Menu Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.menu')->with($notification);
    }

    /**
     * Show the form for editing the specified menu item.
     *
     * @param  int  $id
     */
    public function EditMenu($id)
    {
        // Find the menu item by its ID
        $menu = Menu::find($id);
        return view('client.backend.menu.edit_menu', compact('menu'));
    }

    /**
     * Update the specified menu item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function UpdateMenu(Request $request)
    {
        $menu_id = $request->id;

        // Handle image update if a new image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            // Update the menu item record with the new image and name
            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);
        } else {
            // Update the menu item record with only the new name (no new image)
            Menu::find($menu_id)->update([
                'menu_name' => $request->menu_name,
            ]);
        }

        $notification = [
            'message' => 'Menu Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.menu')->with($notification);
    }

    /**
     * Remove the specified menu item from storage.
     *
     * @param  int  $id
     */
    public function DeleteMenu($id)
    {
        // Find the menu item by its ID
        $item = Menu::find($id);
        $img = $item->image;
        // Delete the image file from the server
        if (file_exists($img)) {
            unlink($img);
        }

        // Delete the menu item record from the database
        Menu::find($id)->delete();

        $notification = [
            'message' => 'Menu Delete Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

     /**
     * Display a list of all products.
     */
    public function AllProduct()
    {
        $id = Auth::guard('client')->id();
        $product = Product::where('client_id',$id)->orderBy('id','desc')->get();
        return view('client.backend.product.all_product', compact('product'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function AddProduct()
    {
        $id = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::where('client_id',$id)->latest()->get();
        return view('client.backend.product.add_product', compact('category', 'city', 'menu'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function StoreProduct(Request $request)
    {
        $pcode = IdGenerator::generate(['table' => 'products', 'field' => 'code', 'length' => 5, 'prefix' => 'PC']);
        $save_url = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;
        }

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
            'client_id' => Auth::guard('client')->id(),
            'most_populer' => $request->most_populer,
            'best_seller' => $request->best_seller,
            'status' => 1,
            'created_at' => Carbon::now(),
            'image' => $save_url,
        ]);

        $notification = [
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.product')->with($notification);
    }

    /**
     * Show the form for editing a product.
     */
    public function EditProduct($id)
    {
        $cid = Auth::guard('client')->id();
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::where('client_id',$cid)->latest()->get();
        $product = Product::find($id);
        return view('client.backend.product.edit_product', compact('category', 'city', 'menu', 'product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function UpdateProduct(Request $request)
    {
        $pro_id = $request->id;
        $product = Product::find($pro_id);

        if ($request->file('image')) {
            // Delete old image if it exists
            if (File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            // Upload and save new image
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/product/' . $name_gen));
            $save_url = 'upload/product/' . $name_gen;
            
            // Update product with new image
            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
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
            // Update product without changing the image
            $product->update([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ', '-', $request->name)),
                'category_id' => $request->category_id,
                'city_id' => $request->city_id,
                'menu_id' => $request->menu_id,
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

        return redirect()->route('all.product')->with($notification);
    }

    /**
     * Remove the specified product from storage.
     */
    public function DeleteProduct($id)
    {
        $item = Product::findOrFail($id);
        
        // Delete the image file if it exists
        if (File::exists(public_path($item->image))) {
            File::delete(public_path($item->image));
        }

        $item->delete();

        $notification = [
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * change product status.
     */
    public function ChangeStatus(Request $request){
        $product = Product::find($request->product_id);
        $product->status = $request->status;
        $product->save();
        return response()->json(['success' => 'Status Change Successfully']);
    }

    /**
     * Display a list of all gallery items.
     */
    public function AllGallery()
    {
        $cid = Auth::guard('client')->id();
        $gallery = Gllery::where('client_id',$cid)->latest()->get();
        return view('client.backend.gallery.all_gallery', compact('gallery'));
    }

    /**
     * Display the form for adding a new gallery item.
     * @return \Illuminate\View\View
     */
    public function AddGallery(){ 
        return view('client.backend.gallery.add_gallery' );
    } 

    /**
     * Store new gallery images.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreGallery(Request $request){

        $images = $request->file('gallery_img');

        // Loop through each uploaded image
        foreach ($images as $gimg) {

            // Use ImageManager to process and save the image
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$gimg->getClientOriginalExtension();
            $img = $manager->read($gimg);
            $img->resize(500,500)->save(public_path('upload/gallery/'.$name_gen));
            $save_url = 'upload/gallery/'.$name_gen;

            // Insert a new record into the database
            Gllery::insert([
                'client_id' => Auth::guard('client')->id(),
                'gallery_img' => $save_url,
            ]); 
        } // end foreach

        $notification = array(
            'message' => 'Gallery Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.gallery')->with($notification);

    }

    /**
     * Display the form for editing a specific gallery item.
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function EditGallery($id){
        $gallery = Gllery::find($id);
        return view('client.backend.gallery.edit_gallery',compact('gallery'));
     }

     /**
      * Update an existing gallery item.
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\RedirectResponse
      */
     public function UpdateGallery(Request $request){

        $gallery_id = $request->id;

        // Check if a new image file was uploaded
        if ($request->hasFile('gallery_img')) {
            $image = $request->file('gallery_img');
            
            // Process and save the new image
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(500,500)->save(public_path('upload/gallery/'.$name_gen));
            $save_url = 'upload/gallery/'.$name_gen;

            $gallery = Gllery::find($gallery_id);

            // Delete the old image file
            if ($gallery->gallery_img) {
                $img = $gallery->gallery_img;
                unlink($img);
            }

            // Update the database record with the new image URL
            $gallery->update([
                'gallery_img' => $save_url,
            ]);
 
            $notification = array(
                'message' => 'Menu Updated Successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('all.gallery')->with($notification);

        } else {

            $notification = array(
                'message' => 'No Image Selected for Update',
                'alert-type' => 'warning'
            );
    
            return redirect()->back()->with($notification); 
        } 
    }

    /**
     * Delete a gallery item and its associated image file.
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function DeleteGallery($id){
        $item = Gllery::find($id);
        $img = $item->gallery_img;

        // Delete the physical image file
        unlink($img);

        // Delete the database record
        Gllery::find($id)->delete();

        $notification = array(
            'message' => 'Gallery Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}