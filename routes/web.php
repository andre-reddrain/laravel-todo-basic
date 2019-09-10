<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Task;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    /**
     * Show Task Dashboard
     */
    Route::get('/', function () {
        //Vai devolver as tasks existentes na base de dados, com a criteria de organização
        //de Criação crescente (Os mais antigos em cima, os novos em baixo)
        return view('tasks', [
            'tasks' => Task::orderBy('created_at', 'asc')->get()
        ]);
    });
    /**
     * Add New Task
     * Request vai receber todos os parâmetros existentes na página, em forma de array.
     * Para visualizar um Request, descomentar a linha de baixo
     */
    Route::post('/task', function (Request $request) {

        dd($request);   //Vai fazer o "Dump and Die" e vai mostrar no ecrã o Request

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
    });
    /**
     * Delete Task
     * Vai receber a task a partir do botão de delete da página inicial.
     * Quando o botão é clicado, vai realizar este método.
     */
    Route::delete('/task/{task}', function (Task $task) {
        //dd($task);              //Vai fazer o "Dump and Die" e vai mostrar no ecrã a Task
        $task->delete();        //Apaga a Task selecionada
        return redirect('/');   //Redireciona para a página inicial
    });
});