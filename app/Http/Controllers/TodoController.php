<?php
namespace App\Http\Controllers;
use App\Models\todo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query =Todo::query();
        if ($request->has('completed')) {
            $isCompleted = filter_var($request->query('completed'), FILTER_VALIDATE_BOOLEAN);
            $query->where('completed', $isCompleted);
        }
   
        return response()->json($query->get());

    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'completed'   => 'boolean'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = $validator->validated();
    $data['completed'] = $data['completed'] ?? false;

    $todo = Todo::create($data);

    return response()->json($todo, 201);
}

    public function show($id)
    {
        return response()->json(Todo::findOrFail($id));
    }
    public function update(Request $request, $id)
{
    $todo = Todo::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'title'       => 'sometimes|required|string|max:255',
        'description' => 'sometimes|nullable|string',
        'completed'   => 'sometimes|boolean',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $data = $validator->validated();
    $todo->update($data);

    return response()->json($todo, 200);
}

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json(null, 204);
    }
    public function markAsComplete($id)
{
    $todo = Todo::findOrFail($id);
    $todo->completed = true;
    $todo->save();

    return response()->json($todo);
}
}