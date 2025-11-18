<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Departments</title>

    <!-- LOAD BOOTSTRAP -->
    <link rel="stylesheet" href="Assets/CSS/bootstrap.min.css">
</head>

<body class="container py-4">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">

        <a class="navbar-brand" href="index.php">Campus System</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=lecturer&action=index">Lecturers</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=department&action=index">Departments</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="index.php?controller=course&action=index">Courses</a>
                </li>

            </ul>
        </div>

    </div>
</nav>


<?php
$page = $page ?? 'index';
?>

<h3 class="mb-3">Departments List</h3>
<!-- =======================================
          FORM ADD & EDIT (Satu Tempat)
======================================= -->
<div class="card p-3 mb-4">
    <h4 class="mb-3">
        <?= isset($department) ? "Edit Department" : "Add Department" ?>
    </h4>

    <form action="index.php?controller=department&action=<?= isset($department) ? 'edit&id=' . $department['id'] : 'create' ?>" method="POST" class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Department Name</label>
            <input type="text" name="name" class="form-control" required
                   value="<?= isset($department) ? htmlspecialchars($department['name']) : '' ?>"
                   placeholder="Department Name">
        </div>

        <div class="col-md-4">
            <label class="form-label">Building</label>
            <input type="text" name="building" class="form-control" required
                   value="<?= isset($department) ? htmlspecialchars($department['building']) : '' ?>"
                   placeholder="Building Name">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn <?= isset($department) ? 'btn-success' : 'btn-primary' ?> w-100">
                <?= isset($department) ? "Update" : "Add" ?>
            </button>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <a href="index.php?controller=department&action=index" class="btn btn-secondary w-100">Clear</a>
        </div>

    </form>
</div>


<!-- =======================================
          TABEL LIST DEPARTMENTS
======================================= -->

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Building</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php if (empty($departments)): ?>
            <tr><td colspan="4" class="text-center">No departments found</td></tr>

        <?php else: ?>
            <?php foreach ($departments as $dep): ?>
                <tr>
                    <td><?= $dep['id'] ?></td>
                    <td><?= htmlspecialchars($dep['name']) ?></td>
                    <td><?= htmlspecialchars($dep['building']) ?></td>

                    <td>
                        <a href="index.php?controller=department&action=index&id=<?= $dep['id'] ?>" 
                           class="btn btn-sm btn-success">Edit</a>

                        <a href="index.php?controller=department&action=delete&id=<?= $dep['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure you want to delete this lecturer?')">
                           Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>

    </tbody>
</table>


<!-- BOOTSTRAP JS -->
<script src="Assets/JS/bootstrap.bundle.min.js"></script>
<script src="Assets/JS/jquery.min.js"></script>

</body>
</html>
