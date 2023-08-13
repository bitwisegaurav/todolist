<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- main box for the todo list -->
    <main>
        <section id="titleBar">
            <h1>Todo List</h1>
        </section>

        <section id="taskList">
            <!-- Task items will be added here using JavaScript -->
            <?php if (isset($newTaskHtml)) {
                echo $newTaskHtml;
            } ?>
        </section>

        <section id="buttonBar">
            <button id="addButton">Add</button>
            <button id="deleteButton">Delete</button>
            <button id="updateButton">Update</button>
        </section>
    </main>

    <!-- Form Modals -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Task</h2>
            <form id="addForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="task">Task:</label>
                    <input type="text" id="task" name="addTask" required>
                </div>
                <button type="submit" class="submit-btn" id="addSubmit" name="add">Submit</button>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Delete Task</h2>
            <form id="deleteForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="deleteId">Task ID:</label>
                    <input type="number" id="deleteId" name="deleteId" required>
                </div>
                <button type="submit" class="submit-btn" id="deleteSubmit" name="delete">Submit</button>
            </form>
        </div>
    </div>

    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Update Task</h2>
            <form id="updateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="updateId">Task ID:</label>
                    <input type="number" id="updateId" name="updateId" required>
                </div>
                <div class="form-group">
                    <label for="updateTask">Task:</label>
                    <input type="text" id="updateTask" name="updateTask">
                </div>
                <button type="submit" class="submit-btn" id="updateSubmit" name="update">Submit</button>
            </form>
        </div>
    </div>

    <?php
    $_error = "Something went wrong.";
    $username = "root";
    $password = "";
    $database = "todo";
    $mysqli = new mysqli("localhost", $username, $password, $database);
    $index;
    // get index value from the last row id
    $sql1 = "SELECT * FROM `todo` ORDER BY `id` DESC LIMIT 1";
    $result = $mysqli->query($sql1);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $index = $row["id"] + 1;
    } else {
        $index = 1;
    }

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["add"])) {
            if (isset($_POST['addTask'])) {
                $addTask = $_POST['addTask'];
                $sql = "INSERT INTO `todo` VALUES ('$index','$addTask')";
                $index++;
                if ($mysqli->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
            } else {
                echo "Error" . $_error;
            }
        } 
        elseif (isset($_POST["delete"])) {
            if (isset($_POST['deleteId'])) {
                $deleteId = $_POST["deleteId"];
                $sql = "DELETE FROM `todo` WHERE `id` = '$deleteId'";
                if ($mysqli->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
                // shift the id by 1 from the deleted row
                $sql = "UPDATE `todo` SET `id` = `id` - 1 WHERE `id` > '$deleteId'";
                if ($mysqli->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
                $index--;
            } else {
                echo "Error" . $_error;
            }
        } 
        elseif (isset($_POST["update"])) {
            if (isset($_POST['updateId'], $_POST['updateTask'])) {
                $updateId = $_POST["updateId"];
                $updateTask = $_POST["updateTask"];
                $sql = "UPDATE `todo` SET `task` = '$updateTask' WHERE `id` = '$updateId'";
                if ($mysqli->query($sql) === false) {
                    echo "Error: " . $sql . "<br>" . $mysqli->error;
                }
            } else {
                echo "Error" . $_error;
            }
        }
    }
    ?>

</body>
<script>
    <?php
    $sql = "SELECT * FROM `todo`";
    $result = $mysqli->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    }  
    ?>

    let data = <?php echo json_encode($data); ?>;
    document.getElementById("taskList").innerHTML = data.map((item) => {
        return `<div class='task' value="${item.id}"><span class='id'>${item.id}. </span><span>${item.task}</span></div>`
    }).join("");
    taskList.scrollTop = taskList.scrollHeight;
</script>
<script src="script.js"></script>
</html>