<?php
// check if user loggedin
session_start();
if (!isset($_SESSION['loggedin']))
    header("Location: login.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include './components/header.php'; ?>
    <title>To-Do List</title>
</head>

<body>
    <?php include './components/navbar.php'; ?>

    <div class="container my-5 min-vh-100">
        <h2>To-Do List</h2>
        <ol id="todo-list">
            <!-- To-Do items will be displayed here using JavaScript -->
        </ol>

        <p id="empty-message" style="display: none;">No items to display.</p>

        <!-- Form to add a new to-do item -->
        <h3>Add a New To-Do Item</h3>
        <form id="addTodoForm" class="form-inline">
            <div class="form-group mb-3">
                <input type="text" id="todoDescription" class="form-control mr-2" placeholder="Enter a new to-do item" value="">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>


    </div>

    <?php include './components/footer.php'; ?>

    <!-- JavaScript to load and manage To-Do items -->
    <script src="assests/js/todo.js"></script>
</body>

</html>