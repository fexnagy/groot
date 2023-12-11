<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "groot";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch tasks from the database
$sql = "SELECT * FROM tasks WHERE status = 'to-do' ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch completed tasks from the database, sorted by completed_at in descending order
$sqlCompleted = "SELECT * FROM tasks WHERE status = 'done'";
$stmtCompleted = $conn->prepare($sqlCompleted);
$stmtCompleted->execute();
$completedTasks = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["priority"])) {
    // Collect form data
    $title = $_POST["title"];
    $description = $_POST["description"];
    $priority = $_POST["priority"];

    // Insert the new task into the database
    $insertSql = "INSERT INTO tasks (title, description, status, priority) VALUES (:title, :description, 'to-do', :priority)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bindParam(":title", $title, PDO::PARAM_STR);
    $insertStmt->bindParam(":description", $description, PDO::PARAM_STR);
    $insertStmt->bindParam(":priority", $priority, PDO::PARAM_STR);

    try {
        $insertStmt->execute();
        // Redirect to the same page to refresh the task lists
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$hasToDoTasks = !empty($tasks);
$hasCompletedTasks = !empty($completedTasks);

function getPriorityClass($priority)
{
    switch ($priority) {
        case 'high':
            return 'bg-rose-400 text-rose-800';
        case 'medium':
            return 'bg-orange-400 text-orange-800';
        case 'low':
            return 'bg-green-400 text-green-800';
        default:
            return 'bg-stone-400 text-stone-800';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Groot - Task Manager</title>
    <link rel="shortcut icon" href="https://tailwindui.com/img/logos/mark.svg?color=rose&shade=500" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/app.js" defer></script>
</head>

<body>
    <nav class="bg-slate-800 shadow sticky top-0 z-50 backdrop-blur-sm ring-2 ring-slate-400/25">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                <div class="flex">
                    <div class="-ml-2 mr-2 flex items-center md:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-slate-400 hover:bg-slate-700 focus:outline-none" aria-controls="mobile-menu" aria-expanded="false" id="mobile-btn">
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-shrink-0 items-center">
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=400" alt="Groot UI" />
                    </div>
                    <div class="hidden md:ml-6 md:flex md:space-x-8">
                        <a class="inline-flex items-center px-1 pt-1 text-md text-slate-400 hover:cursor-pointer" id="current">Home</a>
                        <a class="inline-flex items-center px-1 pt-1 text-md text-slate-500 hover:text-slate-400" href="tasks.php">Tasks</a>
                        <a class="inline-flex items-center px-1 pt-1 text-md text-slate-500 hover:text-slate-400" href="blog.html">Blog</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="contact.html" type="button" class="relative inline-flex items-center gap-x-1.5 rounded-md bg-indigo-500 px-3 py-2 text-md font-semibold text-slate-50 shadow-sm hover:bg-indigo-400 transition duration-150 ease-in-out focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                            Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden" id="mobile-menu">
            <div class="space-y-1 pb-3 pt-2">
                <a class="block border-l-4 border-slate-500 bg-slate-700 text-slate-400 py-2 pl-3 pr-4  sm:pl-5 sm:pr-6 hover:cursor-pointer" id="current-mobile">Home</a>
                <a href="tasks.php" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-slate-500 hover:border-slate-500 hover:bg-slate-700 hover:text-slate-400 sm:pl-5 sm:pr-6">Tasks</a>
                <a href="blog.html" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-slate-500 hover:border-slate-500 hover:bg-slate-700 hover:text-slate-400 sm:pl-5 sm:pr-6">Blog</a>
            </div>
        </div>
    </nav>

    <section>
        <div class="py-24 pb-10 sm:py-32 sm:pb-20 -mt-10 bg-stone-100">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="text-center text-4xl pb-12 font-bold tracking-tight text-stone-900 sm:text-6xl">Your tasks</h2>
                <div class="mx-auto max-w-7xl text-center">
                    <?php if (!$hasToDoTasks && !$hasCompletedTasks) { ?>
                        <a class="text-slate-500 font-bold hover:cursor-pointer hover:opacity-75 py-4 h-64" onclick="openAddTaskModal()">Create a new task.</a>
                    <?php } else { ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if ($hasToDoTasks) { ?>
                                <div class="mx-4">
                                    <h3 class="select-none font-bold text-stone-600 text-xl py-4">To do
                                        <?php if ($hasCompletedTasks || !$hasCompletedTasks && $hasToDoTasks) { ?>
                                            <span class=" bg-rose-200 rounded-lg px-[5.4px] text-rose-500 text-center font-normal hover:cursor-pointer hover:opacity-75" onclick="openAddTaskModal()" title="Add task">+</span>
                                        <?php } ?>
                                    </h3>
                                    <?php foreach ($tasks as $task) { ?>
                                        <div id="contextMenu" style="display: none; position: absolute; background-color: white; border: 1px solid #ccc;">
                                            <div onclick="deleteCard();">Delete</div>
                                        </div>
                                        <div class="card max-w-md mx-auto bg-slate-800 rounded-3xl shadow-md overflow-hidden md:max-w-2xl mb-4 ring-2 ring-slate-400/25" oncontextmenu="showContextMenu(event); return false;">
                                            <div class="md:flex">
                                                <div class="p-8 mb-8 md:mb-0 w-full">
                                                    <a href="#" class="task-title-link hover:line-through" data-task-id="<?= $task['id'] ?>">
                                                        <?= $task['title'] ?>
                                                    </a>
                                                    <p class="mt-2 mb-4 text-stone-500 truncate" title="<?= $task['description'] ?>">
                                                        <?= $task['description'] ?>
                                                    </p>
                                                    <span class="relative z-10 top-2 float-left py-1.5 font-medium text-stone-400" title="Date added"><?= date('F j, Y', strtotime($task['created_at'])) ?></span>
                                                    <?php
                                                    $priorityClass = getPriorityClass($task['priority']);
                                                    ?>
                                                    <span class="select-none relative z-10 top-2 float-right rounded-full <?= $priorityClass ?> px-4 py-1.5 font-medium"><?= ucfirst($task['priority']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if ($hasCompletedTasks) { ?>
                                <div class="mx-4">
                                    <h3 class="select-none font-bold text-stone-600 text-xl py-4">Completed
                                        <?php if (!$hasToDoTasks) { ?>
                                            <span class="bg-rose-200 rounded-lg px-[5.4px] text-rose-500 text-center font-normal hover:cursor-pointer hover:opacity-75" onclick="openAddTaskModal()" title="Add task">+</span>
                                        <?php } ?>
                                    </h3>
                                    <?php foreach ($completedTasks as $completedTask) { ?>
                                        <div class="max-w-md mx-auto bg-white rounded-3xl shadow-md overflow-hidden md:max-w-2xl mb-4">
                                            <div class="md:flex">
                                                <div class="p-8 mb-8 md:mb-0 w-full">
                                                    <?php if ($completedTask['status'] == 'done') { ?>
                                                        <span class="line-through"><?= $completedTask['title'] ?></span>
                                                    <?php } else { ?>
                                                        <a href="#" class="task-title-link <?= $taskClass ?>" data-task-id="<?= $completedTask['id'] ?>">
                                                            <?= $completedTask['title'] ?>
                                                        </a>
                                                    <?php } ?>
                                                    <p class="mt-2 mb-4 text-stone-500 truncate line-clamp-3" title="<?= $completedTask['description'] ?>">
                                                        <?= $completedTask['description'] ?>
                                                    </p>
                                                    <span class="relative z-10 top-2 float-left py-1.5 font-medium text-stone-400" title="Date added"><?= date('F j, Y', strtotime($completedTask['created_at'])) ?></span>
                                                    <?php
                                                    $priorityClass = getPriorityClass($completedTask['priority']);
                                                    ?>
                                                    <span class="select-none relative z-10 top-2 float-right rounded-full <?= $priorityClass ?> px-4 py-1.5 font-medium"><?= ucfirst($completedTask['priority']) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
            <div class="flex justify-center space-x-6 md:order-2">
                <div class="text-stone-600 select-none">
                    Github repo <span aria-hidden="true">→</span>
                </div>
                <a href="https://github.com/fexnagy/groot" class="text-stone-400 hover:text-rose-500 transition duration-150 ease-in-out" target="_blank">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <div class="mt-8 md:order-1 md:mt-0">
                <p class="text-center text-xs leading-5 text-stone-500">
                    &copy; 2023 Groot, Inc. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Add Task Modal -->
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addTaskModal">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay, show/hide based on modal state -->
            <div class="fixed inset-0" aria-hidden="true">
                <div class="absolute inset-0 bg-stone-800 opacity-50"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Task Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg px-12">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start p-4">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-xl leading-6 font-bold text-stone-900 pb-8" id="modal-title">
                                Add task
                            </h3>
                            <div class="mt-2">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-4">
                                        <label for="title" class="block text-stone-700 text-sm font-bold mb-2">Title</label>
                                        <input minlength="5" maxlength="50" type="text" id="title" name="title" class="appearance-none border rounded w-full py-2 px-3 text-stone-700" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="description" class="block text-stone-700 text-sm font-bold mb-2">Description</label>
                                        <textarea minlength="5" maxlength="255" id="description" name="description" class="appearance-none border rounded w-full py-2 h-24 px-3 text-stone-700" required></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="priority" class="block text-stone-700 text-sm font-bold mb-2">Priority</label>
                                        <select id="priority" name="priority" class="appearance-none border rounded w-full py-2 px-3 text-stone-700" required>
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center justify-end">
                                        <button type="button" class="bg-stone-500 hover:bg-stone-600 text-white py-2 px-4 rounded-full focus:outline-none focus:shadow-outline" onclick="closeAddTaskModal()">
                                            Cancel
                                        </button>
                                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white py-2 px-4 rounded-full ml-2 focus:outline-none focus:shadow-outline">
                                            Add
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>