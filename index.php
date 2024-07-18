<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
    if (isset($_POST['task']) && !isset($_POST['update_id'])) {
        $task = $_POST['task'];
        $stmt = $pdo->prepare('INSERT INTO tasks (task) VALUES (?)');
        $stmt->execute([$task]);
        header('Location: index.php');
        exit;
    }
    if (isset($_POST['task']) && isset($_POST['update_id'])) {
        $task = $_POST['task'];
        $update_id = $_POST['update_id'];
        $stmt = $pdo->prepare('UPDATE tasks SET task = ? WHERE id = ?');
        $stmt->execute([$task, $update_id]);
        header('Location: index.php');
        exit;
    }
    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
        $stmt->execute([$delete_id]);
        header('Location: index.php');
        exit;
    }
}

$stmt = $pdo->query('SELECT * FROM tasks');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
   
    <form action="index.php" method="POST">
        <label for="task">Task:</label>
        <input type="text" id="task" name="task" required>
        <button type="submit">Submit</button>
    </form>

    <h1>Task List</h1>
    <?php
    while ($row = $stmt->fetch()) {
        $task_id = $row['id'];
        $task_name = htmlspecialchars($row['task']);
        
        echo '<form action="index.php" method="POST">';
        echo '<label>';
        echo '<input type=checkbox>';
        echo $task_name;
        echo '</label>';
        echo '<input type="hidden" name="update_id" value="' . $task_id . '">';
        echo '<input type="text" name="task" value="' . $task_name . '">';
        echo '<button type="submit">Update</button>';
        echo '</form>';
        
        echo '<form action="index.php" method="POST" style="display:inline;">';
        echo '<input type="hidden" name="delete_id" value="' . $task_id . '">';
        echo '<button type="submit">Delete</button>';
        echo '</form>';
        
        echo '<br>';
    }
    ?>
</body>
</html>
