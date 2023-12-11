DROP DATABASE IF EXISTS groot;
CREATE DATABASE groot;
USE groot;
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    description TEXT,
    status ENUM("to-do", "done"),
    priority ENUM("low", "medium", "high"),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO tasks (title, description, status, priority, created_at)
VALUES (
        "Complete Project Proposal",
        "Write and finalize the project proposal document for the upcoming software project.",
        "done",
        "medium",
        "2023-10-06 00:00:00"
    ),
    (
        "Bug Fixing",
        "Identify and fix the critical bugs reported by users in the latest software release.",
        "to-do",
        "high",
        "2023-10-06 00:00:00"
    ),
    (
        "Client Meeting",
        "Schedule and prepare for a client meeting to discuss project progress and updates.",
        "to-do",
        "low",
        "2023-10-02 00:00:00"
    ),
    (
        "Code Review",
        "Review and provide feedback on code changes submitted by team members.",
        "done",
        "low",
        "2023-09-30 00:00:00"
    ),
    (
        "Testing",
        "Perform extensive testing to ensure the software functions correctly and meets quality standards.",
        "done",
        "medium",
        "2023-09-28 00:00:00"
    );