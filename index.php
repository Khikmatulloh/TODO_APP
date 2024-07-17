


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdo list</title>
</head>
<body>
    
    <form action="index.php" method="POST">
        <label for="task">Task:</label>
        <input type="text" id="task" name="task" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>


<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task=$_POST['task'];

    $stmt=$pdo->prepare('insert into tasks (task) values (?)');
    $stmt->execute([$task]);


    echo '<h1>Task</h1>';
   
    echo '<form>';
}
$stmt=$pdo->query('select * from tasks');
echo '<form>';
while($row=$stmt->fetch()){
    echo'<label>';
    echo'<input type=checkbox>';
    echo ($row['task']);
    echo'</label><br>';
}
echo '</form>';
?>