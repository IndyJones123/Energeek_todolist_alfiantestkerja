<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Fetch all task
            $task = task::all();

            if ($task->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No task found',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'task retrieved successfully',
                'data' => $task
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
            'email' => 'required|email',
            'username' => 'required|string|max:255',
            'tasks' => 'required|array',
            'tasks.*.description' => 'required|string|max:255',
            'tasks.*.category_id' => 'required|integer|exists:categories,id',
        ]);

        // Check if user already exists
        $user = User::where('email', $validatedData['email'])
                    ->orWhere('username', $validatedData['username'])
                    ->first();

        if (!$user) {
            // Create a new user with the validated data
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'],
                'password' => bcrypt('no-password'), // Hash the password
            ]);

            $message = 'User created successfully';
        } else {
            $message = 'User already exists, tasks created successfully';
        }

        // Prepare tasks data with user ID and created_by fields
        $tasksData = array_map(function ($task) use ($user) {
            return [
                'description' => $task['description'],
                'category_id' => $task['category_id'],
                'user_id' => $user->id,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'created_at' => now(), // Set current timestamp
                'updated_at' => now(), // Set current timestamp
            ];
        }, $validatedData['tasks']);

        // Create multiple tasks
        $tasks = Task::insert($tasksData); // Use insert to handle bulk insert

        // Fetch the tasks for the specific user
        $tasks = Task::where('user_id', $user->id)
                     ->whereIn('description', array_column($validatedData['tasks'], 'description'))
                     ->get();


        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => [
                'user' => $user,
                'tasks' => $tasks
            ]
        ], 201); // 201 Created status

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $e->errors(),
        ], 422); // 422 Unprocessable Entity status

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
            $task = task::find($id);

            if ($task) {
                // Return success response with task data
                return response()->json([
                    'status' => 'success',
                    'message' => 'task is found',
                    'data' => $task
                ], 200); // 200 OK status
            } else {
                // Return error response if task not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'task not found'
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the user by ID
            $task = task::find($id);

            // Check if task exists
            if (!$task) {
                // Return error response if task not found
                return response()->json([
                    'status' => 'error',
                    'message' => 'task not found'
                ], 404); // 404 Not Found status
            }

            // Delete the task
            $task->delete();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'task deleted successfully'
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
