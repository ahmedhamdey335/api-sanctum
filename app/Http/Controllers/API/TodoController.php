<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Todo;
use Validator;
use App\Http\Resources\TodoResource;
use Illuminate\Http\JsonResponse;

class TodoController extends BaseController
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $todos = Todo::all();
        return $this->sendResponse(TodoResource::collection($todos), 'Todos retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'work' => 'required',
            'duedate' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $todo = Todo::create($input);
        return $this->sendResponse(new TodoResource($todo), 'Todo created successfully.');
    } 

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $todo = Todo::find($id);
        if (is_null($todo)) {
            return $this->sendError('Todo not found.');
        }
        return $this->sendResponse(new TodoResource($todo), 'Todo retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo): JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'work' => 'required',
            'duedate' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $todo->name = $input['name'];
        $todo->work = $input['work'];
        $todo->duedate = $input['duedate'];
        $todo->save();
        return $this->sendResponse(new TodoResource($todo), 'Todo updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $todo->delete();
        return $this->sendResponse([], 'Todo deleted successfully.');
    }
}