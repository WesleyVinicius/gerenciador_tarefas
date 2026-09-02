<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Tasks;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class TasksController extends BaseController
{
    protected $tasksModel;

    // Método para inicialização do Controller conforme a documentação do CI4
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->tasksModel = new Tasks();
    }

    // Lista todas as tarefas
    public function index()
    {
        $data['tasks'] = $this->tasksModel->findAll();
        return view('tasks/index', $data);
    }

    // Mostra o formulário de cadastro
    public function new()
    {
        return view('tasks/new');
    }

    // Salva uma nova tarefa
    public function create()
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
        ];

        try {
            // Verifica se os campos obrigatórios estão preenchidos
            if(!$this->tasksModel->save($data)){
                return redirect()->back()->withInput()->with('errors', $this->tasksModel->errors());
            }

            return redirect()->to('/tasks')->with('success', 'Tarefa salva com sucesso!');

        } catch (\Exception $e) {

            return redirect()->back()->withInput()
                ->with('error', 'Ocorreu um erro ao tentar salvar a tarefa.');

        }
    }

    // Mostra o formulário de edição
    public function edit($id)
    {
        $tasks = $this->tasksModel->find($id);

        // Se o usuário tentar acessar um id que não existe
        if (!$tasks) {
            throw PageNotFoundException::forPageNotFound('Tarefa não encontrada');
        }

        $data['tasks'] = $tasks;

        return view('tasks/edit', $data);
    }

    // Atualiza uma tarefa existente
    public function update($id)
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
        ];

        try {
            // Verifica se os campos obrigatórios estão preenchidos
            if (!$this->tasksModel->update($id, $data)) {
                return redirect()->back()->withInput()->with('errors', $this->tasksModel->errors());
            }

            return redirect()->to('/tasks')->with('success', 'Tarefa atualizada com sucesso!');

        } catch (\Exception $e) {

            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao tentar atualizar a tarefa.');

        }
    }

    // Exclui uma tarefa
    public function delete($id)
    {
        try {
            $this->tasksModel->delete($id);

            return redirect()->to('/tasks')
                ->with('success', 'Tarefa excluída com sucesso!');

        } catch (\Exception $e) {

            return redirect()->to('/tasks')
                ->with('error', 'Não foi possível excluir esta tarefa.');
        }
    }
}