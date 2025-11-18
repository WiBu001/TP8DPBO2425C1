<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Courses</title>

    <!-- Bootstrap -->
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

<!-- =======================================
        FORM ADD & EDIT COURSE
======================================= -->
<div class="card p-3 mb-4">
    <h4 class="mb-3">
        <?= isset($course) ? "Edit Course" : "Add Course" ?>
    </h4>

    <form action="index.php?controller=course&action=<?= isset($course) ? 'edit&id=' . $course['id'] : 'create' ?>" method="POST" class="row g-3">

        <!-- Course Name -->
        <div class="col-md-4">
            <label class="form-label">Course Name</label>
            <input type="text"
                class="form-control"
                name="course_name"
                required
                placeholder="Enter course name"
                value="<?= isset($course) ? htmlspecialchars($course['course_name']) : '' ?>">
        </div>

        <!-- Credit -->
        <div class="col-md-2">
            <label class="form-label">Credit</label>
            <input type="number"
                class="form-control"
                name="credit"
                required
                min="1"
                value="<?= isset($course) ? htmlspecialchars($course['credit']) : '' ?>">
        </div>

        <!-- Lecturer -->
        <div class="col-md-4">
            <label class="form-label">Lecturer</label>
            <select name="lecturer_id" class="form-select" required>
                <option value="">-- Select Lecturer --</option>

                <?php foreach ($lecturers as $lec): ?>
                    <option value="<?= $lec['id'] ?>"
                        <?= isset($course) && $lec['id'] == $course['lecturer_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($lec['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Buttons -->
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit"
                class="btn <?= isset($course) ? 'btn-success' : 'btn-primary' ?> w-100">
                <?= isset($course) ? "Update" : "Add" ?>
            </button>

            <a href="index.php?controller=course&action=index" class="btn btn-secondary w-100">Clear</a>
        </div>

    </form>
</div>

<!-- =======================================
        COURSES LIST TABLE
======================================= -->

<h3 class="mb-3">Courses List</h3>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Course Name</th>
            <th>Credit</th>
            <th>Lecturer</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>

        <?php if (empty($courses)): ?>
            <tr><td colspan="5" class="text-center">No courses found</td></tr>

        <?php else: ?>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['course_name']) ?></td>
                    <td><?= $c['credit'] ?></td>
                    <td><?= htmlspecialchars($c['lecturer_name'] ?? 'N/A') ?></td>

                    <td>
                        <a href="index.php?controller=course&action=index&id=<?= $c['id'] ?>" 
                           class="btn btn-sm btn-success">Edit</a>

                        <a href="index.php?controller=course&action=delete&id=<?= $c['id'] ?>"
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

<!-- JS -->
<script src="Assets/JS/bootstrap.bundle.min.js"></script>
<script src="Assets/JS/jquery.min.js"></script>

</body>
</html>
