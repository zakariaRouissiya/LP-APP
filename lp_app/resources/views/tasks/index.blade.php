<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    @vite(['resources/js/index.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-white text-light">

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">🗂️ Liste des Tâches</h3>
                <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#taskModal">
                    + Nouvelle Tâche
                </button>
            </div>

            
            <form method="GET" action="{{ route('tasks.index') }}" class="mb-4">
                <div class="d-flex align-items-center">
                    <select name="category" class="form-select me-2">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" class="form-select me-2">
                        <option value="">Tous les statuts</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                    </select>
                    <input type="text" name="title" class="form-control me-2" placeholder="Rechercher par titre" value="{{ request('title') }}">
                    <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>

            
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col">Priorité</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Date de terminaison</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->category->name ?? 'Non catégorisé' }}</td>
                                <td>
                                    @if ($task->priority === 'élevée')
                                        <span class="badge bg-primary">Élevée</span>
                                    @elseif ($task->priority === 'moyenne')
                                        <span class="badge bg-info">Moyenne</span>
                                    @else
                                        <span class="badge bg-secondary">Faible</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($task->completed)
                                        <span class="badge bg-success">Terminée</span>
                                    @else
                                        <span class="badge bg-warning">En cours</span>
                                    @endif
                                </td>
                                <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if ($task->completed_at)
                                        {{ $task->completed_at->format('d/m/Y H:i') }}
                                    @else
                                        -------------------
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if (!$task->completed)
                                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-check-circle"></i> Terminer
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#taskDetailsModal{{ $task->id }}">
                                            <i class="bi bi-eye"></i> Détails
                                        </button>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Ajouter une Tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        
                        <div class="col-md-6">
                            <label for="title" class="form-label">Titre de la tâche</label>
                            <input type="text" name="title" id="title" class="form-control border-dark" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Catégorie</label>
                            <select name="category_id" id="category_id" class="form-select border-dark">
                                <option value="">Non catégorisé</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        
                        <div class="col-md-6">
                            <label for="priority" class="form-label">Priorité</label>
                            <select name="priority" id="priority" class="form-select border-dark">
                                <option value="faible">Faible</option>
                                <option value="moyenne" selected>Moyenne</option>
                                <option value="élevée">Élevée</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($tasks as $task)
<div class="modal fade" id="taskDetailsModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskDetailsModalLabel{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-sm">
            <div class="modal-header">
                <h5 class="modal-title" id="taskDetailsModalLabel{{ $task->id }}">Détails de la Tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p><strong>Titre :</strong> {{ $task->title }}</p>
                <p><strong>Catégorie :</strong> {{ $task->category->name ?? 'Non catégorisé' }}</p>
                <p><strong>Priorité :</strong> {{ ucfirst($task->priority) }}</p>
                <p><strong>Statut :</strong> {{ $task->completed ? 'Terminée' : 'En cours' }}</p>
                <p><strong>Date de création :</strong> {{ $task->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Date de terminaison :</strong> 
                    @if ($task->completed_at)
                        {{ $task->completed_at->format('d/m/Y H:i') }}
                    @else
                        -------------------
                    @endif
                </p>
                <p><strong>Période consommée :</strong> 
                    @if ($task->completed_at)
                        {{ $task->created_at->diffForHumans($task->completed_at, true) }}
                    @else
                        -------------------
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
