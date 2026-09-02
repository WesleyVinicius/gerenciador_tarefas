<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Nova Tarefa</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>)">
    <link rel="stylesheet" href="<?= base_url('assets/css/style-form.css') ?>">
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
            <a href="/tasks" class="nav-link d-flex align-items-center">
                <i class="bi bi-card-list"></i> Tarefas
            </a>
        </li>
        <li>
            <a href="/tasks/new" class="nav-link active d-flex align-items-center">
                <i class="bi bi-plus-lg"></i> Nova tarefa
            </a>
        </li>
    </ul>

    <div class="mt-auto">
        <a href="#" class="nav-link text-muted d-flex align-items-center">
            <i class="bi bi-box-arrow-right"></i> Sair
        </a>
    </div>
</aside>

<!-- Conteúdo Principal -->
<main class="flex-grow-1 p-5 overflow-auto">
    <div class="container-fluid px-0 max-w-5xl" style="max-width: 800px;">

        <!-- Cabeçalho -->
        <div class="mb-4 d-flex align-items-center">
            <a href="/tasks" class="btn btn-link text-secondary p-0 me-3 fs-4" title="Voltar">
                <i class="bi bi-arrow-left-short"></i>
            </a>
            <div>
                <h2 class="fw-bold mb-1">Criar Nova Tarefa</h2>
                <p class="text-secondary mb-0">Preencha os detalhes da tarefa abaixo.</p>
            </div>
        </div>

        <!-- Exibição de Erros de Validação -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-3 text-danger"></i>
                <div>
                    <h6 class="alert-heading fw-bold mb-1">Não foi possível salvar a tarefa:</h6>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulário -->
        <div class="card-form shadow-sm p-4 p-md-5">
            <form action="<?= base_url('tasks/create') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label for="title" class="form-label">Título da Tarefa <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" placeholder="Ex: Estudar para o teste técnico" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Descrição (Opcional)</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Adicione mais detalhes sobre o que precisa ser feito..."><?= old('description') ?></textarea>
                </div>

                <div class="mb-5">
                    <label for="status" class="form-label">Status Inicial</label>
                    <select class="form-select" id="status" name="status">
                        <option value="pendente" <?= old('status') === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em andamento" <?= old('status') === 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                        <option value="concluída" <?= old('status') === 'concluída' ? 'selected' : '' ?>>Concluída</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                    <a href="/tasks" class="btn btn-light px-4 border text-dark fw-medium shadow-sm">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 fw-medium shadow-sm">
                        <i class="bi bi-check-lg me-2"></i> Salvar Tarefa
                    </button>
                </div>
            </form>
        </div>

    </div>
</main>

<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>