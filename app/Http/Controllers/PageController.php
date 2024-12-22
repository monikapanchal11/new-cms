<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::whereNull('parent_id')->get();  // Get top-level pages (no parent)
    
        $pages = $this->loadChildren($pages);
    
        return response()->json($pages);
    }
    
    private function loadChildren($pages)
    {
        return $pages->map(function ($page) {
            $page->children = $this->loadChildren($page->children);  
            return $page;
        });
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:pages,id',
            'slug' => 'required|string',
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);

        $page = Page::create($validated);
        return response()->json($page);
    }

    // public function show($id)
    // {
    //     $page = Page::with('children')->findOrFail($id);
    //     return response()->json($page);
    // }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:pages,id',
            'slug' => 'required|string',
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);

        $page->update($validated);
        return response()->json($page);
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Page deleted successfully']);
    }

    public function show($slug)
    {
        // Split the slug by "/" to get the nested structure
        $slugs = explode('/', $slug);
    
        // Start with the first slug
        $page = null;
    
        foreach ($slugs as $slugPart) {
            $page = Page::where('slug', $slugPart)
                ->when($page, function ($query) use ($page) {
                    $query->where('parent_id', $page->id);
                })
                ->first();
    
            if (!$page) {
                abort(404); // Page not found
            }
        }
    
        $page->children = $this->getChildren($page->id);
  
        return response()->json($page);
    }
    
    protected function getChildren($parentId)
    {
        return Page::where('parent_id', $parentId)
                   ->get();
    }
    
}

