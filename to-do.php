<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style1.css">
</head>
<body>
<?php
include('connect.php');

// إضافة Task
if(isset($_POST['make']) && !empty($_POST['make'])){
    $make = mysqli_real_escape_string($conn, $_POST['make']);
    $query = "INSERT INTO `tasks`(`todo`) VALUES ('$make')";
    mysqli_query($conn,$query);
   
}
?>
<form action="to-do.php" method="post">
<div class="todo-container">
    <div class="todo-header">
        <h1><i class="fas fa-tasks me-2"></i>My To-Do List</h1>
        <p>Organize your tasks and boost your productivity</p>
    </div>

    <div class="todo-body">
        <!-- Input لإضافة Task -->
        <div class="input-group mb-3">
            <input type="text" class="todo-input form-control" id="newTodo" name="make" placeholder="Add a new task...">
            <button class="btn btn-primary add-btn" type="submit">
                <i class="fas fa-plus me-2"></i>Add Task
            </button>
        </div>

        <!-- Filters + Stats -->
        <div class="todo-stats mb-3">
            <div class="stat-item"> <div class="stat-value"><?php  ?></div> <div class="stat-label"></div> </div>
            <div class="stat-item"> <div class="stat-value"></div> <div class="stat-label"></div> </div>
            <div class="stat-item"> <div class="stat-value"></div> <div class="stat-label"></div> </div>
            <div class="stat-item"> <div class="stat-value"></div> <div class="stat-label"></div> </div>
        </div>

        <div class="todo-filters mb-3">
            <button class="filter-btn active" data-filter="all">All Tasks</button>
            
        </div>

        <!-- قائمة Tasks -->
        <ul class="todo-list" id="todoList">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM tasks ORDER BY id DESC");
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <li class="todo-item" id="task-<?= $row['id'] ?>">
                <div class="todo-checkbox">
                    <input type="checkbox">
                    <label class="checkmark"></label>
                </div>
                <div class="priority-indicator priority-low"></div>
                <div class="todo-text">
                    <?= htmlspecialchars($row['todo']); ?>
                </div>
                <div class="todo-actions">
                    <button class="action-btn edit-btn" type="button">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="action-btn delete-btn" onclick="deleteTask(<?= $row['id'] ?>)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </li>
            <?php } ?>
        </ul>

        <div class="empty-state" id="emptyState" style="display: none;">
            <i class="fas fa-clipboard-list"></i>
            <h3>No tasks to display</h3>
            <p>Add a new task using the form above</p>
        </div>
    </div>
</div>
</form> 

<div class="instructions mt-3">
    <h3>How to use this To-Do App :</h3>
    <ul>
        <li><strong>Add a task:</strong> Type in the input field and click "Add Task"</li>
      
        
</div>

<!-- JavaScript للحذف بدون Reload -->
<script>
function deleteTask(id) {
    if(!confirm("متأكد عايز تمسح التاسك دي؟")) return;

    fetch("delete.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "id=" + id
    })
    .then(res => res.text())
    .then(data => {
        if(data.trim() === "success") {
            document.getElementById("task-" + id).remove();
        }
    });
}
</script>

</body>
</html>
