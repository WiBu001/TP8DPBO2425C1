<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lecturers</title>

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

<!-- ===========================================================
                    PAGE: INDEX
=========================================================== -->
<?php if ($page === 'index'): ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lecturers List</h2>
</div>

<div class="card mb-4">
    <div class="card-body">

        <h5 class="mb-3">
            <?= isset($lecturer) ? "Edit Lecturer" : "Add Lecturer" ?>
        </h5>

        <form action="index.php?controller=lecturer&action=<?= isset($lecturer) ? 'edit&id='.$lecturer['id'] : 'create' ?>" 
              method="POST" 
              class="row g-3 mb-3 border-bottom pb-3">

            <div class="col-md-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control"
                       value="<?= isset($lecturer) ? htmlspecialchars($lecturer['name']) : '' ?>"
                       required>
            </div>

            <div class="col-md-3">
                <label class="form-label">NIDN</label>
                <input type="text" name="nidn" class="form-control"
                       value="<?= isset($lecturer) ? htmlspecialchars($lecturer['nidn']) : '' ?>"
                       required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control"
                       value="<?= isset($lecturer) ? htmlspecialchars($lecturer['phone']) : '' ?>"
                       required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Join Date</label>
                <input type="date" name="join_date" class="form-control"
                       value="<?= isset($lecturer) ? htmlspecialchars($lecturer['join_date']) : '' ?>"
                       required>
            </div>

            <div class="col-md-2">
                <label class="form-label">Department</label>
                <select name="department_id" class="form-control" required>
                    <option value="">-- Select --</option>

                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d['id'] ?>"
                            <?= isset($lecturer) && $lecturer['department_id'] == $d['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d['name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn <?= isset($lecturer) ? 'btn-success' : 'btn-primary' ?> w-100">
                    <?= isset($lecturer) ? "Update" : "Add" ?>
                </button>

                <a href="index.php?controller=lecturer&action=index" class="btn btn-secondary w-100">
                    Clear
                </a>
            </div>

        </form>
    </div>
</div>


<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>NIDN</th>
            <th>Phone</th>
            <th>Join Date</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($lecturers)): ?>
            <tr><td colspan="7" class="text-center">No lecturers found</td></tr>
        <?php else: ?>
            <?php foreach ($lecturers as $l): ?>
                <tr>
                    <td><?= $l['id'] ?></td>
                    <td><?= htmlspecialchars($l['name']) ?></td>
                    <td><?= htmlspecialchars($l['nidn']) ?></td>
                    <td><?= htmlspecialchars($l['phone']) ?></td>
                    <td><?= htmlspecialchars($l['join_date']) ?></td>

                    <td>
                        <?= htmlspecialchars($l['department_name'] ?? '—') ?>
                    </td>

                    <td>
                        <a href="index.php?controller=lecturer&action=index&id=<?= $l['id'] ?>" 
                           class="btn btn-sm btn-success">Edit</a>

                        <a href="index.php?controller=lecturer&action=delete&id=<?= $l['id'] ?>"
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

<?php endif; ?>


<script src="Assets/JS/bootstrap.bundle.min.js"></script>
<script src="Assets/JS/jquery.min.js"></script>

</body>
</html>
