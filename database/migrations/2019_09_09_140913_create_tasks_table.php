<?php
//Nome do ficheiro vai conter: Data_create_"nome da tabela"_table
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     * Cria a tabela "tasks" com todas as colunas definidas abaixo
     * @return void
     */
    public function up()
    {
        //Conteúdos da tabela
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            /* Timestamps criam 2 colunas:
             *  - created_at - Quando criado
             *  - updated_at - Quando atualizado
             */ 
            //Inserir mais, caso haja
        });
    }

    /**
     * Reverse the migrations.
     * Ao contrário de criar, elimina a tabela "tasks", caso ela exista
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
