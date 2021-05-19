<?php

namespace Modules\Todo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Todo\Models\Todo;
use Illuminate\View\View;
use Modules\Todo\Services\Todo\TodoServiceInterface;

class TodoController extends Controller
{
    /**
     * @var TodoServiceInterface
     */
    protected TodoServiceInterface $service;

    public function __construct(TodoServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = $this->service->all();
        return View::component('TodosPage', ['todos' => $todos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return View::component('CreateTodoPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(int $todo_id)
    {
        $todo = $this->service->find($todo_id);
        return View::component('TodoPage', ['data' => $todo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $todo_id)
    {
        $todo = $this->service->find($todo_id);
        return View::component('EditTodoPage', ['data', $todo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $todo_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $todo_id)
    {
        //
    }
}
