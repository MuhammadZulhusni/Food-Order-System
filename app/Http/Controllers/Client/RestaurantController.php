<?php

namespace App\Http\Controllers\Client;

use App\Models\City;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Models\Category; // Unused import
use Intervention\Image\Drivers\Gd\Driver;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class RestaurantController extends Controller
{
    /**
     * Display a listing of all menu items.
     */
    public function AllMenu()
    {
        // Retrieve all menu items, ordered by the latest created
        $menu = Menu::latest()->get();
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



    public function AllProduct(){
        $product = Product::latest()->get();
        return view('client.backend.product.all_product', compact('product'));
    } 

     public function AddProduct(){
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        return view('client.backend.product.add_product', compact('category','city','menu'));
    } 

    public function StoreProduct(Request $request){

        $pcode = IdGenerator::generate(['table' => 'products','field' => 'code', 'length' => 5, 'prefix' => 'PC']);  

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/product/'.$name_gen));
            $save_url = 'upload/product/'.$name_gen;

            Product::create([
                'name' => $request->name,
                'slug' => strtolower(str_replace(' ','-',$request->name)),
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
        } 

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.product')->with($notification);
    }
}