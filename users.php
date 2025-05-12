
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Project Storemai
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&amp;family=Roboto+Slab&amp;display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   body {
      font-family: 'Roboto Slab', serif;
    }
    .font-alfa {
      font-family: 'Alfa Slab One', cursive;
    }
  </style>
 </head>
 <body>
  <div class="min-h-screen flex bg-[url('bg.PNG')] bg-cover bg-center p-4">
   <!-- Sidebar -->
   <aside class="w-48 bg-gray-200 bg-opacity-90 rounded-md flex flex-col items-center pt-6 relative">
    <img alt="Black user icon silhouette inside a circle" class="w-20 h-20 rounded-full mb-4" height="80" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="80"/>
    <button aria-label="Edit profile" class="absolute top-2 right-2 text-gray-600 text-xs flex items-center space-x-1">
     <span>
      Edit
     </span>
     <i class="fas fa-pencil-alt text-xs">
     </i>
    </button>
    <div class="w-full bg-gray-400 text-center font-['Roboto_Slab'] font-semibold text-lg py-2 rounded-md select-none">
     Admin
    </div>
   </aside>
   <main class="flex-1 ml-6 flex flex-col space-y-4">
    <!-- Header -->
    <header class="bg-white bg-opacity-90 rounded-md flex items-center justify-between px-6 py-2">
     <h1 class="font-alfa text-black text-xl tracking-wide select-none" style="letter-spacing: 0.1em">
      PROJECT STOREMAI
     </h1>
     <div class="flex items-center space-x-3 bg-gray-300 bg-opacity-40 rounded-full px-3 py-1 max-w-[180px]">
      <input class="bg-transparent outline-none text-black text-sm w-full placeholder-black placeholder-opacity-50" placeholder="Search" type="search"/>
      <i class="fas fa-search text-black text-sm">
      </i>
      <i class="fas fa-bell text-black text-sm">
      </i>
      <i class="fas fa-user-circle text-black text-sm">
      </i>
     </div>
    </header>
    <!-- Search bar -->
    <div class="bg-gray-300 bg-opacity-50 rounded-full h-10 flex items-center space-x-6 px-6 max-w-full">
     <div class="bg-gray-400 rounded-full h-6 w-24">
     </div>
     <div class="bg-gray-400 rounded-full h-6 w-36">
     </div>
    </div>
    <!-- Notification bar -->
    <div class="bg-teal-600 bg-opacity-90 text-white rounded-md flex items-center justify-between px-4 py-1 max-w-full">
     <span class="text-xs font-semibold select-none">
      1 New Member!
     </span>
     <button aria-label="Close notification" class="text-black text-lg">
      ×
     </button>
    </div>
    <!-- User cards grid -->
    <section class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-full">
     <!-- Card 1 with NEW ribbon -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md relative p-4 flex flex-col items-center space-y-2">
      <div class="absolute top-0 left-0 bg-teal-700 text-white text-[10px] font-semibold px-1 rotate-45 origin-top-left select-none" style="width: 3.5rem; margin-left: -0.9rem; margin-top: 0.5rem">
       NEW
      </div>
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       New User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Card 2 -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Card 3 -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Card 4 -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Card 5 -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Card 6 -->
     <div class="bg-gray-300 bg-opacity-70 rounded-md p-4 flex flex-col items-center space-y-2">
      <img alt="Black user icon silhouette inside a circle" class="w-16 h-16 rounded-full" height="64" src="https://storage.googleapis.com/a1aa/image/a8995d59-1291-47ee-d0bf-01d85a6d42dc.jpg" width="64"/>
      <div class="bg-gray-400 rounded-full text-center text-xs font-semibold px-3 py-1 select-none">
       User
      </div>
      <button class="bg-gray-400 rounded-full text-xs font-semibold px-3 py-1 select-none">
       View
      </button>
     </div>
     <!-- Add new user card -->
     <div aria-label="Add new user" class="bg-gray-300 bg-opacity-70 rounded-2xl flex items-center justify-center cursor-pointer" style="height: 96px">
      <i class="fas fa-plus text-6xl text-gray-600">
      </i>
     </div>
    </section>
   </main>
   <!-- Right side icons (edit and trash) -->
   <div class="flex flex-col justify-start ml-2 space-y-4">
    <button aria-label="Edit" class="text-gray-700 hover:text-gray-900 focus:outline-none">
     <i class="fas fa-pencil-alt text-lg">
     </i>
    </button>
    <button aria-label="Delete" class="text-red-600 hover:text-red-800 focus:outline-none">
     <i class="fas fa-trash-alt text-lg">
     </i>
    </button>
   </div>
  </div>
 </body>
</html>



