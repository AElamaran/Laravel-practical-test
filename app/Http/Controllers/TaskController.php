<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   
    public function index()
    {
        $tasks = Task::with('category')->get();

        return response()->json($tasks);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', 
        ]);

       
        $task = Task::create($validated);

        
        return response()->json($task, 201);
    }

   
    public function show($id)
    {
       
        $task = Task::with('category')->findOrFail($id);
        return response()->json($task);
    }

  
    public function update(Request $request, $id)
    {
        
        $task = Task::find($id);

       
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
        ]);

        
        $task->update($validated);

        
        return response()->json($task,201);
    }

    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
