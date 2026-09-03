<?php

namespace App\Controllers\Api;

use App\Models\TaskModel;
use CodeIgniter\RESTful\ResourceController;

class TaskApiController extends ResourceController
{
    // Model e formato padrão configurados
    protected $modelName = TaskModel::class;
    protected $format = 'json';

    public function index()
    {
        try {
            // Lista todas as tarefas cadastradas
            $tasks = $this->model->findAll();
            return $this->respond($tasks);

        } catch (\Exception $e) {
            return $this->failServerError('Erro ao listar tarefas: ' . $e->getMessage());
        }
    }

    public function show($id = null)
    {
        try {
            $task = $this->model->find($id);

            // Se não encontrar o id, retorna mensagem
            if (!$task) {
                return $this->failNotFound("Tarefa com id {$id} não encontrada.");
            }

            return $this->respond($task);

        } catch (\Exception $e) {
            return $this->failServerError('Erro ao buscar tarefa: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {

            // Primeiro busca JSON, se não encontrar, busca via POST
            $data = $this->request->getJSON(true) ?? $this->request->getPost();

            // Salva os dados e já verifica se consegue salvar
            if (!$this->model->save($data)) {
                return $this->failValidationErrors($this->model->errors());
            }

            $id = $this->model->getInsertID();
            $task = $this->model->find($id);

            return $this->respondCreated($task);

        } catch (\Exception $e) {
            return $this->failServerError('Erro ao criar tarefa: ' . $e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {

            $task = $this->model->find($id);

            if (!$task) {
                return $this->failNotFound("Tarefa com id {$id} não encontrada.");
            }

            // Uso do getRawInput para garantir que requisições PUT que não venham como JSON
            $data = $this->request->getJSON(true) ?? $this->request->getRawInput();

            if (!$this->model->update($id, $data)) {
                return $this->failValidationErrors($this->model->errors());
            }

            return $this->respond($this->model->find($id));

        } catch (\Exception $e) {
            return $this->failServerError('Erro ao atualizar tarefa: ' . $e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $task = $this->model->find($id);

            if (!$task) {
                return $this->failNotFound("Tarefa com id {$id} não encontrada.");
            }

            $this->model->delete($id);
            return $this->respondDeleted(['id' => $id]);

        } catch (\Exception $e) {
            return $this->failServerError('Erro ao excluir tarefa: ' . $e->getMessage());
        }
    }
}