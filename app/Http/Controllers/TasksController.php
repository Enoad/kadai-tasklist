<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

use Illuminate\Support\Facades\Auth;                        // 追加
use App\Models\User;           //追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        // dashboardビューでそれらを表示
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
        
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
           'content' => 'required|max:255',
        ]);
        
        
        
        // タスクを作成
        
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = auth()->id(); 
        $task->save();
        

        // メインに飛ぶ
        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (\Auth::check()) {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
         }

        // タスク詳細ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
        return view('tasks.show', [
            'task' => $task,
        ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
         if (\Auth::check()) {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
         }

        // タスク編集ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
        return view('tasks.edit', [
            'task' => $task,
        ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
           'content' => 'required|max:255',
        ]);
        
               // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // タスクを更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        // メインに飛ばす
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        

        // トップページへリダイレクトさせる
        return redirect('/dashboard');
    }
}
