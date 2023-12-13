<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "groot";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Groot - Task Manager</title>
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="js/app.js" defer></script>
</head>

<body>
  <nav class="bg-slate-800 shadow sticky top-0 z-50 backdrop-blur-sm ring-4 ring-slate-400/25">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <div class="flex">
          <div class="-ml-2 mr-2 flex items-center md:hidden">
            <!-- Mobile menu button -->
            <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-slate-400 hover:bg-slate-700" aria-controls="mobile-menu" aria-expanded="false" id="mobile-btn">
              <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
              </svg>
            </button>
          </div>
          <div class="flex flex-shrink-0 items-center">
            <img class="h-8 w-auto" src="img/logo.png" alt="Groot UI" draggable="false">
          </div>
          <div class="hidden md:ml-6 md:flex md:space-x-8">
            <a class="inline-flex items-center px-1 pt-1 text-md text-slate-400 hover:cursor-pointer" id="current">Home</a>
            <a class="inline-flex items-center px-1 pt-1 text-md text-slate-500 hover:text-slate-400" href="tasks.php">Tasks</a>
            <a class="inline-flex items-center px-1 pt-1 text-md text-slate-500 hover:text-slate-400" href="blog.html">Blog</a>
          </div>
        </div>
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <a href="contact.html" type="button" class="relative inline-flex items-center gap-x-1.5 rounded-md bg-indigo-500 px-3 py-2 text-md font-semibold text-slate-100 shadow-sm hover:bg-indigo-400">
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
        <a class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-slate-500 hover:border-slate-500 hover:bg-slate-700 hover:text-slate-400 sm:pl-5 sm:pr-6" href="tasks.php">Tasks</a>
        <a class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-slate-500 hover:border-slate-500 hover:bg-slate-700 hover:text-slate-400 sm:pl-5 sm:pr-6">Blog</a>
      </div>
    </div>
  </nav>

  <section id="header">
    <div class="relative isolate overflow-hidden bg-slate-700">
      <div class="mx-auto max-w-7xl pb-24 pt-10 sm:pb-32 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:py-40">
        <div class="px-6 lg:px-0 -mt-20 -mb-14">
          <div class="mx-auto max-w-2xl">
            <div class="max-w-lg">
              <div class="mt-24 sm:mt-32 lg:mt-16">
                <a href="blog.html" class="inline-flex space-x-6 hover:opacity-70">
                  <span class="rounded-full bg-indigo-600/10 px-3 py-1 text-sm font-semibold leading-6 text-indigo-400 ring-1 ring-inset ring-indigo-600/25">What's new</span>
                  <span class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-slate-400">
                    <span>Just shipped v0.1</span>
                    <svg class="h-5 w-5 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                  </span>
                </a>
              </div>
              <h1 class="mt-10 text-4xl font-bold tracking-tight text-slate-100 sm:text-6xl">
                Manage tasks with ease
              </h1>
              <p class="mt-6 text-lg leading-8 text-slate-400">
                Groot is an easy to use task manager, built with PHP and Tailwind CSS. It's open source and free to use.
              </p>
              <div class="mt-10 flex items-center gap-x-6">
                <a href="tasks.php" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-slate-100 shadow-sm hover:bg-indigo-400">
                  View tasks
                </a>
                <a href="#workflow" class="text-sm font-semibold leading-6 text-slate-400 hover:text-slate-600">
                  Learn more <span aria-hidden="true">→</span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-20 sm:mt-24 md:mx-auto md:max-w-full lg:mx-0 lg:mt-0 lg:w-screen">
          <div class="absolute inset-y-0 right-1/2 -z-10 -mr-10 w-[200%] skew-x-[-30deg] bg-slate-900 shadow-xl shadow-indigo-600/10 ring-4 ring-slate-400 md:-mr-20 lg:-mr-36" aria-hidden="true"></div>
          <div class="card hidden lg:block max-w-full mx-6 bg-slate-800 rounded-3xl shadow-md overflow-hidden mb-4 ring-2 ring-slate-400/25" oncontextmenu="showContextMenu(event); return false;">
            <div class="md:flex">
              <div class="p-8 mb-8 md:mb-0 w-full">
                <p class="task-title hover:line-through hover:cursor-pointer text-slate-100 hover:text-slate-300" title="Title">
                  This is the title of a task
                </p>
                <p class=" mt-2 mb-4 text-slate-400 truncate" title="Description">
                  You can give it a description. It will be truncated if it's too long, like this one.
                </p>
                <span class="relative z-10 top-2 float-left py-1.5 font-medium text-slate-500" title="Date added">August 12, 2023</span>
                <span class="select-none relative z-10 top-2 float-right rounded-full bg-rose-400 text-rose-800 px-4 py-1.5 font-medium" title="Priority">High</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-slate-800/100 sm:h-96"></div>
    </div>
  </section>

  <section id="workflow">
    <div class="bg-slate-800 py-24 sm:py-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
          <p class="text-base font-semibold leading-7 text-indigo-400">
            Easy to use
          </p>
          <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-100 sm:text-4xl">
            A better workflow
          </h1>
          <div class="mt-10 grid max-w-xl grid-cols-1 gap-8 text-lg leading-8 text-slate-400 lg:max-w-none lg:grid-cols-2">
            <div>
              <p>
                Easily throw in your tasks through the user-friendly interface on the Tasks page.
                You're in control with the title, description, and priority.
                And guess what? It even slaps on the date when you added it, so you can keep
                track of your productivity journey.
              </p>
              <p class="mt-8">
                Delete tasks if they're out of the picture or mark them as completed.
                The completed ones get their VIP spot in the "Completed" column on the Tasks page.
                They've earned it with their hard work.
              </p>
            </div>
            <div>
              <p>
                But hey, the fun doesn't stop there! Check out our blog page for exciting
                development updates about the website. It's where we spill the tea on
                what's brewing behind the scenes.
              </p>
              <p class="mt-8">
                Have questions or just want to chat? Swing by our Contact page.
                We're all ears and ready to help out.
                Your journey to organized chaos-free living starts here!
              </p>
            </div>
          </div>
          <div class="mt-10 flex">
            <a href="#preview" class="text-sm font-semibold leading-6 text-slate-400 hover:text-slate-600">
              Preview <span aria-hidden="true">→</span>
            </a>
          </div>
        </div>
      </div>
      <div class="relative overflow-hidden pt-16 lg:pt-20" id="preview">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <img class="rounded-2xl shadow-2xl ring-4 ring-slate-400/25" src="img/task-page.jpg" alt="Task page" draggable="false">
          <div class="relative" aria-hidden="true">
            <div class="absolute -inset-x-20 bottom-0 bg-gradient-to-t from-slate-800 pt-[15%]"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-slate-700 ring-4 ring-slate-400/25">
    <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
      <div class="flex justify-center space-x-6 md:order-2">
        <div class="text-slate-300 select-none">
          Github repo <span aria-hidden="true">→</span>
        </div>
        <a href="https://github.com/fexnagy/groot" class="text-slate-300 hover:text-slate-400" target="_blank">
          <span class="sr-only">GitHub</span>
          <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
          </svg>
        </a>
      </div>
      <div class="mt-8 md:order-1 md:mt-0">
        <p class="text-center text-sm text-slate-300">
          &copy; 2023 Groot, Inc. All rights reserved.
        </p>
      </div>
    </div>
  </footer>
</body>

</html>