<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager</title>
    <link rel="icon" href="<?= base_url('favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>')">
</head>
<body class="d-flex vh-100">

<!-- Menu Lateral -->
<aside class="sidebar d-flex flex-column p-4 shadow-sm">
    <a href="/tasks" class="d-flex align-items-center text-dark text-decoration-none mb-5 mt-2">
        <i class="bi bi-check-square text-primary fs-4 me-2"></i>
        <span class="fs-5 fw-bold">TaskManager</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/tasks" class="nav-link active d-flex align-items-center">
                <i class="bi bi-card-list"></i> Tarefas
            </a>
        </li>
        <li>
            <a href="/tasks/new" class="nav-link d-flex align-items-center">
                <i class="bi bi-plus-lg"></i> Nova tarefa
            </a>
        </li>
    </ul>
</aside>

<!-- Conteúdo Principal -->
<main class="flex-grow-1 p-5 overflow-auto">
    <div class="container-fluid px-0 max-w-5xl">

        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Tarefas</h2>
                <p class="text-secondary mb-0">Gerencie suas tarefas.</p>
            </div>

            <a href="/tasks/new" class="btn btn-primary px-4 py-2 fw-medium rounded-3 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i> Nova tarefa
            </a>
        </div>

        <!-- Formulário de Busca -->
        <div class="col-md-5 mb-3 mb-md-0">
            <div class="input-group shadow-sm rounded-3">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="inputBusca" class="form-control border-start-0 ps-0" placeholder="Filtrar tarefas na tela...">
            </div>
        </div>

        <!-- Alerta de Sucesso (Exibido após create, update ou delete) -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tabela de Tarefas -->
        <div class="card-table shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th class="w-50">Título</th>
                    <th class="text-center">Status</th>
                    <th class="text-end pe-4">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($tasks) && is_array($tasks)): ?>
                    <?php foreach($tasks as $task): ?>
                        <tr>
                            <!-- Coluna: Título e Descrição -->
                            <td>
                                <div class="fw-bold text-dark fs-6"><?= esc($task['title']) ?></div>
                                <div class="text-secondary small mt-1"><?= esc($task['description'] ?? 'Sem descrição') ?></div>
                            </td>

                            <!-- Coluna: Status com Badge -->
                            <td class="text-center align-middle">
                                <?php
                                $badgeClass = 'text-bg-secondary';
                                $statusLabel = 'Pendente';

                                if ($task['status'] === 'em andamento') {
                                    $badgeClass = 'text-bg-warning';
                                    $statusLabel = 'Em andamento';
                                } elseif ($task['status'] === 'concluída') {
                                    $badgeClass = 'text-bg-success';
                                    $statusLabel = 'Concluída';
                                }
                                ?>
                                <span class="badge rounded-pill <?= $badgeClass ?> px-3 py-2 fs-6 fw-medium shadow-sm">
                                    <?= $statusLabel ?>
                                </span>
                            </td>

                            <!-- Coluna: Ações (Editar e Excluir) -->
                            <td class="text-end pe-4">
                                <!-- Botão de Editar -->
                                <a href="/tasks/edit/<?= $task['id'] ?>" class="btn btn-link text-primary p-0 me-3 fs-5 btn-action" title="Editar tarefa">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <!-- Botão que aciona o Modal de Exclusão -->
                                <button type="button" class="btn btn-link text-danger p-0 fs-5 btn-action" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $task['id'] ?>" title="Excluir tarefa">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <!-- Modal de Confirmação Exclusivo para esta Tarefa -->
                                <div class="modal fade" id="deleteModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $task['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">

                                            <!-- Cabeçalho do Modal -->
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h1 class="modal-title fs-5 text-danger fw-bold" id="deleteModalLabel<?= $task['id'] ?>">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirmar Exclusão
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>

                                            <!-- Corpo do Modal -->
                                            <div class="modal-body text-start py-4 text-dark">
                                                Você tem certeza que deseja excluir a tarefa <strong>"<?= esc($task['title']) ?>"</strong>?<br>
                                                <span class="text-muted small">Esta ação não poderá ser desfeita.</span>
                                            </div>

                                            <!-- Rodapé com os Botões -->
                                            <div class="modal-footer border-top-0 pt-0">
                                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>

                                                <form action="<?= base_url('tasks/delete/' . $task['id']) ?>" method="POST" class="m-0 p-0">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger px-4 shadow-sm">
                                                        Sim
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-5 text-secondary">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-muted"></i>
                            Nenhuma tarefa cadastrada. Clique em "Nova tarefa" para começar.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/js/filtro_index.js') ?>"></script>
</body>
</html>