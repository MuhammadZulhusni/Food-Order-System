<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Using the Gd driver for image manipulation

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function AllCategory()
    {
        // Retrieve all categories, ordered by the latest created
        $category = Category::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function AddCategory()
    {
        return view('admin.backend.category.add_category');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function StoreCategory(Request $request)
    {
        // Check if an image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            // Initialize ImageManager with the GD driver
            $manager = new ImageManager(new Driver());
            // Generate a unique name for the image
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            // Read the image and resize it to 300x300, then save to public path
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/category/'.$name_gen));
            // Construct the URL for the saved image
            $save_url = 'upload/category/'.$name_gen;

            // Create a new category record in the database
            Category::create([
                'category_name' => $request->category_name,
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.category')->with($notification);
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int  $id
     */
    public function EditCategory($id)
    {
        // Find the category by its ID
        $category = Category::find($id);
        return view('admin.backend.category.edit_category', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function UpdateCategory(Request $request)
    {
        $cat_id = $request->id;

        // Check if a new image file was uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            // Initialize ImageManager with the GD driver
            $manager = new ImageManager(new Driver());
            // Generate a unique name for the image
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            // Read the image and resize it to 300x300, then save to public path
            $img = $manager->read($image);
            $img->resize(300,300)->save(public_path('upload/category/'.$name_gen));
            // Construct the URL for the saved image
            $save_url = 'upload/category/'.$name_gen;

            // Update the category record with the new image and name
            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
                'image' => $save_url,
            ]);

            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);

        } else {
            // Update the category record with only the new name (no new image)
            Category::find($cat_id)->update([
                'category_name' => $request->category_name,
            ]);
            // Prepare a success notification
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.category')->with($notification);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int  $id
     */
    public function DeleteCategory($id)
    {
        // Find the category by its ID
        $item = Category::find($id);
        // Get the image path
        $img = $item->image;
        // Delete the image file from the server
        unlink($img);

        // Delete the category record from the database
        Category::find($id)->delete();

        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}