<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $categories = category::all();
        return view('home', compact('categories'));
    }

    public function index()
    {
        try {
            // Fetch all task
            $category = category::all();

            if ($category->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No category found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'task retrieved successfully',
                'data' => $category
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors and return a 400 response
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request',
                'errors' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'updated_by' => 'required|integer',
                'created_by' => 'required|integer',
            ]);

            // Create a new user with the validated data
            $category = category::create([
                'name' => $validatedData['name'],
                'updated_by' => $validatedData['updated_by'],
                'created_by' => $validatedData['created_by'],
            ]);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'category created successfully',
                'data' => $category
            ], 201); // 201 Created status

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors (e.g. email or username already exists)
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'errors' => $e->errors(), // This will return field-specific validation errors
            ], 422); // 422 Unprocessable Entity

        } catch (\Exception $e) {
            // Handle other exceptions and return a 400 Bad Request response
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request',
                'errors' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       try {
            // Fetch a single user by its ID
            $category = category::find($id);

            if ($category) {
                // Return success response with task data
                return response()->json([
                    'status' => 'success',
                    'message' => 'task is found',
                    'data' => $category
                ], 200); // 200 OK status
            } else {
                // Return error response if task not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'category not found'
                ], 404); // 404 Not Found status
            }

        } catch (\Exception $e) {
            // Handle other potential errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        try {
            // Find the user by ID
            $category = category::find($id);

            // Check if user exists
            if (!$category) {
                // Return error response if user not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404); // 404 Not Found status
            }

            // Update the user with validated data
            $category->fill($validatedData);

            $category->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $category
            ], 200); // 200 OK status

        } catch (\Exception $e) {
            // Handle other potential errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the cate$category by ID
            $category = category::find($id);

            // Check if cate$category exists
            if (!$category) {
                // Return error response if cate$category not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'category not found'
                ], 404); // 404 Not Found status
            }

            // Delete the cate$category
            $category->delete();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'cate$category deleted successfully'
            ], 200); // 200 OK status

        } catch (\Exception $e) {
            // Handle other potential errors
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred',
                'errors' => $e->getMessage(),
            ], 500); // 500 Internal Server Error status
        }
    }
}
