<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $tasks = $user->tasks()->with('category')->paginate(10); 
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',
            'title.max' => 'O título não pode ter mais que 255 caracteres.',
            'description.string' => 'A descrição deve ser um texto.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada é inválida.',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $user = User::find(Auth::user()->id);
        $task = $user->tasks()->with('category')->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $task = $user->tasks()->findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'sometimes|exists:categories,id',
        ], [
            'title.string' => 'O título deve ser um texto.',
            'title.max' => 'O título não pode ter mais que 255 caracteres.',
            'description.string' => 'A descrição deve ser um texto.',
            'category_id.exists' => 'A categoria selecionada é inválida.',
        ]);

        $task->update($request->only(['title', 'description', 'category_id']));

        return response()->json($task);
    }

    public function destroy($id)
    {
        $user = User::find(Auth::user()->id);
        $task = $user->tasks()->findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
