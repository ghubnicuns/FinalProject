<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Project Storemai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Roboto+Slab&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Roboto Slab', serif;
    }
    .font-alfa {
      font-family: 'Alfa Slab One', cursive;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="min-h-screen flex">
    <!-- Full Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col p-6 space-y-6">
      <h2 class="text-2xl font-alfa tracking-wide">PROJECT STOREMAI</h2>
      <nav class="flex flex-col space-y-3">
        <a href="dash.php" class="flex items-center space-x-3 hover:text-teal-400">
          <i class="fas fa-home"></i><span>Dashboard</span>
        </a>
        <a href="inventory.php" class="flex items-center space-x-3 hover:text-teal-400">
          <i class="fas fa-boxes-stacked"></i><span>Inventory</span>
        </a>
        <a href="#" class="flex items-center space-x-3 hover:text-teal-400">
          <i class="fas fa-users"></i><span>User</span>
        </a>
        <a href="reports.php" class="flex items-center space-x-3 hover:text-teal-400">
          <i class="fas fa-chart-line"></i><span>Reports</span>
        </a>
        <a href="add.php" class="flex items-center space-x-3 hover:text-teal-400">
          <i class="fas fa-tags"></i><span>Products</span>
        </a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 space-y-4 bg-[url('bg.PNG')] bg-cover bg-center">
      <!-- Top bar -->
      <header class="bg-white bg-opacity-90 rounded-md flex items-center justify-between px-6 py-2">
        <h1 class="font-alfa text-black text-xl tracking-wide select-none" style="letter-spacing: 0.1em">
          PROJECT STOREMAI
        </h1>
        <div class="flex items-center space-x-3 bg-gray-300 bg-opacity-40 rounded-full px-3 py-1 max-w-[180px]">
          <input class="bg-transparent outline-none text-black text-sm w-full placeholder-black placeholder-opacity-50" placeholder="Search" type="search"/>
          <i class="fas fa-search text-black text-sm"></i>
          <i class="fas fa-bell text-black text-sm"></i>
          <i class="fas fa-user-circle text-black text-sm"></i>
        </div>
      </header>

      <!-- Search bar placeholder -->
      <div class="bg-gray-300 bg-opacity-50 rounded-full h-10 flex items-center space-x-6 px-6 max-w-full">
        <div class="bg-gray-400 rounded-full h-6 w-24"></div>
        <div class="bg-gray-400 rounded-full h-6 w-36"></div>
      </div>

      <!-- Notification -->
      <div class="bg-teal-600 bg-opacity-90 text-white rounded-md flex items-center justify-between px-4 py-1 max-w-full">
        <span class="text-xs font-semibold select-none">1 New Member!</span>
        <button aria-label="Close notification" class="text-black text-lg">×</button>
      </div>

      <!-- User Cards -->
      <section class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-full">
        <!-- Card 1 with "NEW" ribbon -->
        <div class="bg-gray-300 bg-opacity-70 rounded-md relative p-4 flex flex-col items-center space-y-2">
          <div class="absolute top-0 left-0 bg-teal-700 text-white text-[10px] font-semibold px-1 rotate-45 origin-top-left select-none" style="width: 3.5rem; margin-left: -0.9rem; margin-top: 0.5rem">
            NEW
          </div>
          <img src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" alt="User" class="w-16 h-16 rounded-full"/>
          <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">New User</div>
          <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">View</button>
        </div>

        <!-- Additional user cards (example repeated) -->
        <!-- You can duplicate this for more cards -->
        <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
          <img src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" alt="User" class="w-16 h-16 rounded-full"/>
          <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">User</div>
          <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">View</button>
        </div>

        <!-- Add user card -->
        <div aria-label="Add new user" class="bg-gray-300 bg-opacity-70 rounded-2xl flex items-center justify-center cursor-pointer" style="height: 96px">
          <i class="fas fa-plus text-6xl text-gray-600"></i>
        </div>
      </section>
    </main>
  </div>
</body>
</html>
