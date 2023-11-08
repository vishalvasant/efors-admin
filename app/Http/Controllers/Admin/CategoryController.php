<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use File;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        return view('modules.categories.index')
            ->with([
                'categories' => Category::query()
                    ->when($search, fn ($query) => $query->where('name', 'like', "%".$search."%"))
                    ->simplePaginate(10)
            ]);
    }

    public function create()
    {
        return view('modules.categories.edit')
            ->with([
                'action' => route('categories.store'),
                'method' => null,
                'data' => null
            ]);
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active');

        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $filename = date("hhmmss").'.'.$image->getClientOriginalExtension();
            $save_path = './uploads/event/';
            $path = $save_path.$filename;
            $public_path = 'uploads/event/'.$filename;
        
            // Make the user a folder and set permissions
            File::makeDirectory($save_path, $mode = 0755, true, true);
        
            // Save the file to the server
            Image::make($image)->resize(300, 300)->save($save_path.$filename);
        
            // Save the public image path
            // $event->image = $public_path;
            // $event->save();
        }
        $validated['img_url'] = $public_path;

        $category = Category::create($validated);

        return redirect()
            ->route('categories.edit', $category)
            ->withNotify('success', $category->getAttribute('name'));
    }

    public function show(Category $category)
    {
        return view('modules.categories.edit')
            ->with([
                'action' => null,
                'method' => null,
                'data' => $category
            ]);
    }

    public function edit(Category $category)
    {
        return view('modules.categories.edit')
            ->with([
                'action' => route('categories.update', $category),
                'method' => "PUT",
                'data' => $category
            ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        $validated['active'] = $request->has('active');
        $public_path = "";
        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $filename = 'image.'.$image->getClientOriginalExtension();
            $save_path = './uploads/event/';
            $path = $save_path.$filename;
            $public_path = 'uploads/event/'.$filename;
        
            // Make the user a folder and set permissions
            File::makeDirectory($save_path, $mode = 0755, true, true);
        
            // Save the file to the server
            Image::make($image)->resize(300, 300)->save($save_path.$filename);
        
            // Save the public image path
            // $event->image = $public_path;
            // $event->save();
        }
        $validated['img_url'] = $public_path;

        $category->update($validated);

        return back()->withNotify('info', $category->getAttribute('name'));
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return response('OK');
        }
        return response()->setStatusCode('204');
    }
}
