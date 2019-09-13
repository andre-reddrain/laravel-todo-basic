<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Task;

class TaskController extends Controller
{
    /**
     * Vai criar uma Tarefa
     * 
     * param $request - Inputs enviados pelo Post
     */
    public function addTask(Request $request){
        //dd($request);   //Vai fazer o "Dump and Die" e vai mostrar no ecrã o Request

        //Validator vai fazer as validações pretendidas
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',   //Validação de Max Length & null
        ]);

        //Se o validator falhar, dá return para a página inicial com o erro que o validator recolheu.
        //Este erro é depois imprimido para a página inicial, no @include do tasks.blade.php
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);   //É enviado o validator, que contém o erro
        }
        //Caso não haja nenhum erro nas validações, vai fazer o Post de uma Task
        $task = new Task;               //Criação de um objeto Task
        $task->name = $request->name;   //Nome da task vai ser o nome vindo do Request
        $task->save();                  //Guarda a task na base de dados
        return redirect('/');           //Vai redirecionar para a página inicial
    }

    /**
     * Vai eliminar uma Tarefa
     * 
     * param $task - Task a ser apagada
     */
    public function deleteTask(Task $task){
        //dd($task);              //Vai fazer o "Dump and Die" e vai mostrar no ecrã a Task
        $task->delete();        //Apaga a Task selecionada
        return redirect('/');   //Redireciona para a página inicial
    }

    /**
     * Vai buscar e devolver todas as Tarefas
     */
    public function getAllTasks(){
        //Vai devolver as tasks existentes na base de dados, com a criteria de organização
        //de Criação crescente (Os mais antigos em cima, os novos em baixo)
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    }
}