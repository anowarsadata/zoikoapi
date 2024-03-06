<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response; // Import the Response class
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /** For all pages */
    /*
    public function index()
    {
        $pages = Page::all(); // Retrieve all pages from the database
        return response()->json($pages, Response::HTTP_OK); // Return the data as JSON
    }
    */
    /** End */
    /** For single page */
    public function index($id)
    {
        $pages = Page::find($id); // Retrieve all pages from the database
        return response()->json($pages, Response::HTTP_OK); // Return the data as JSON
    }
    /** End */

//page
public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    // Create a new page instance with the validated data
    $page = new Page([
        'title' => $validatedData['title'],
        'content' => $validatedData['content'],
    ]);

    $page->save(); // Save the new page to the database

    return response()->json($page, Response::HTTP_CREATED); // Return the new page as JSON
}

//delete
public function destroy($id)
{
    $page = Page::find($id);

    if (!$page) {
        return response()->json(['message' => 'Page not found'], Response::HTTP_NOT_FOUND);
    }

    $page->delete();
    return response()->json(['message' => 'Page deleted'], Response::HTTP_OK);
}
}
