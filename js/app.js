// mobile menu
document.addEventListener("DOMContentLoaded", function () {
    const mobileBtn = document.getElementById("mobile-btn");
    const mobileMenu = document.getElementById("mobile-menu");

    mobileBtn.addEventListener("click", function () {
        mobileMenu.classList.toggle("hidden");
    });
});

const current = document.getElementById("current");
const currentMobile = document.getElementById("current-mobile");

current.addEventListener("click", function () {
    window.scrollTo(0, 0);
});

currentMobile.addEventListener("click", function () {
    window.scrollTo(0, 0);
});

// Add Task
const modal = document.getElementById("addTaskModal");

function openAddTaskModal() {
    modal.style.display = "block";
}

function closeAddTaskModal() {
    modal.style.display = "none";
}

function addTask() {
    // Get values from the form
    const title = document.getElementById("taskTitle").value;
    const description = document.getElementById("taskDescription").value;
    const priority = document.getElementById("taskPriority").value;

    fetch("add_task.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            title: title,
            description: description,
            priority: priority,
        }),
    })
        .then((response) => {
            if (response.ok) {
                closeAddTaskModal();
            } else {
                console.error("Error adding task");
            }
        })
        .catch((error) => {
            console.error("Network error:", error);
        });
}

// Complete Task

document.addEventListener("DOMContentLoaded", function () {
    const taskLinks = document.querySelectorAll(".task-title-link");

    taskLinks.forEach(function (taskLink) {
        taskLink.addEventListener("click", function (e) {
            e.preventDefault();
            const taskId = taskLink.getAttribute("data-task-id");

            // Send a form submission to update the task's status
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "update_status.php"; // Create this PHP file to handle the update

            const taskIdInput = document.createElement("input");
            taskIdInput.type = "hidden";
            taskIdInput.name = "taskId";
            taskIdInput.value = taskId;

            form.appendChild(taskIdInput);
            document.body.appendChild(form);
            form.submit();

            // Assuming you return a success message from the server
            // Move the task to the completed section in the DOM
            const completedTask = taskLink.closest(".max-w-md");
            completedTask.remove(); // Remove it from the to-do section
            document
                .querySelector(".completed-tasks")
                .appendChild(completedTask); // Append it to the completed section
        });
    });
});

// Navbar opacity
const navbar = document.querySelector("nav");
window.addEventListener("scroll", function () {
    if (window.scrollY > 100) {
        navbar.style.backgroundColor = "rgba(30, 41, 59, 0.9)";
    } else {
        navbar.style.backgroundColor = "#1e293b";
    }
});

function showContextMenu(event) {
    event.preventDefault(); // Prevent the default context menu from appearing
    const contextMenu = document.getElementById("contextMenu");
    contextMenu.style.display = "block";
    contextMenu.style.left = event.clientX + "px";
    contextMenu.style.top = event.clientY + "px";
}

function deleteCard() {
    const contextMenu = document.getElementById("contextMenu");
    contextMenu.style.display = "none";

    // Delete the card or perform your desired action here
    const card = document.querySelector(".card");
    card.style.display = "none"; // For demonstration, hide the card
}

// Close the context menu when clicking anywhere in the document
document.addEventListener("click", function (event) {
    const contextMenu = document.getElementById("contextMenu");
    contextMenu.style.display = "none";
});
