<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all Users
            $users = User::all();

            if ($users->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No users found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => $users
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
                'email' => 'required|email|unique:users,email',
                'username' => 'required|string|max:255|unique:users,username',
                'password' => 'required|string|min:6'
            ]);

            // Create a new user with the validated data
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => bcrypt($validatedData['password']), // Hash the password
            ]);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'data' => $user
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
            $user = User::find($id);

            if ($user) {
                // Return success response with user data
                return response()->json([
                    'status' => 'success',
                    'message' => 'User is found',
                    'data' => $user
                ], 200); // 200 OK status
            } else {
                // Return error response if user not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
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
            'email' => 'nullable|email|unique:users,email,' . $id,
            'username' => 'nullable|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6'
        ]);

        try {
            // Find the user by ID
            $user = User::find($id);

            // Check if user exists
            if (!$user) {
                // Return error response if user not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404); // 404 Not Found status
            }

            // Update the user with validated data
            $user->fill($validatedData);

            // Only hash the password if it's provided
            if (isset($validatedData['password'])) {
                $user->password = bcrypt($validatedData['password']);
            }

            $user->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
                'data' => $user
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
            // Find the user by ID
            $user = User::find($id);

            // Check if user exists
            if (!$user) {
                // Return error response if user not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found'
                ], 404); // 404 Not Found status
            }

            // Delete the user
            $user->delete();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully'
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
