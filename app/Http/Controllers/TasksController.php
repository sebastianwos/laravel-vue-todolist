<?php

namespace App\Http\Controllers;

use App\Task;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tasks.app');
    }

    /**
     * Get JSON tasks from DB for current logged user
     * @return mixed
     */
    public function getTasks(){
        $user = Auth::user();
        return $user->tasks()->orderBy('end_date', 'desc')->get();
    }

    /**
     * Toggles the task status
     * @param Request $request
     * @return array
     */
    public function toggleStatus(Request $request){
        $task = Task::where(['id' => $request->input('id'), 'user_id' => Auth::user()->id ])->firstOrFail();
        $task->toggleStatus();
        return ['success' => 1];
    }

    /**
     * Deletes the task
     * @param Request $request
     * @return array
     */
    public function deleteTask(Request $request){
        $task = Task::where(['id' => $request->input('id'), 'user_id' => Auth::user()->id])->firstOrFail();
        $task->deleteTask();
        return ['success' => 1];
    }

    /**
     * Adds Task to database as not completed
     * @param Request $request
     * @return array
     */
    public function addTask(Request $request){

        $this->validate($request, [
            'body' => 'required',
            'date' => 'required'
        ]);

        $user = Auth::user();
        $user->addTask(Task::create([
            'user_id' => $user->id,
            'body' => $request->input('body'),
            'end_date' => Carbon::parse($request->input('date'))->format('Y-m-d')]
        ));
        return ['success' => 1];
    }




}
