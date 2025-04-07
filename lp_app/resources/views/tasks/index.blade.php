<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 25px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-danger-custom {
            background-color: #dc3545;
            color: white;
            border-radius: 25px;
            font-weight: bold;
        }

        .btn-danger-custom:hover {
            background-color: #c82333;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .btn-complete {
            background-color: #28a745;
            color: white;
            border-radius: 25px;
            font-weight: bold;
        }

        .btn-complete:hover {
            background-color: #218838;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .header {
            font-size: 2rem;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .table {
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .modal-content {
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 2px solid #007bff;
        }

        .modal-title {
            font-weight: 600;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h1 class="header">Liste des Tâches</h1>

        <div class="text-end mb-3">
            <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#taskModal">Ajouter une Nouvelle Tâche</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>
                                @if ($task->completed)
                                    <span class="badge bg-success">Terminée</span>
                                @else
                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-complete">Marquer comme terminée</button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger-custom">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">Ajouter une Tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de la tâche</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
