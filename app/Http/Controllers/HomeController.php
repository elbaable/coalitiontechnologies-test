<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function task(){
        $tasks = Task::orderBy('priority', 'asc')->get();
        return view('task')->with(compact('tasks'));
    }

    public function add_task(Request $request){
        $dataInput['name'] = $request->name;
        $last = Task::orderBy('priority', 'desc')->first();
        if($last){
            $dataInput['priority'] = $last->priority + 1;
        }else{
            $dataInput['priority'] = 0;
        }
        Task::create($dataInput);
        return redirect('/');
    }

    public function update_task(Request $request){
        $dataInput['name'] = $request->name;
        Task::where('id', $request->id)->update($dataInput);
        return redirect('/');
    }

    public function delete_task(Request $request){
        Task::where('id', $request->id)->delete();
    }

    public function update_priority(Request $request){
        $array = $request->priorityArray;
        for($i = 0; $i < count($array); $i++){
            $dataUpdate['priority'] = $i;
            Task::where('id', $array[$i])->update($dataUpdate);
        }
    }
}
