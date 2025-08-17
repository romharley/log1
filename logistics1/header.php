
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Logistics 1 Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex font-sans">

<!-- Sidebar -->
<aside class="w-64 bg-gray-900 text-white min-h-screen shadow-lg">
  <!-- Logo / Header -->
  <div class="p-5 bg-gradient-to-r from-blue-600 to-indigo-700 text-2xl font-bold flex items-center justify-center space-x-2">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" >
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6a2 2 0 012-2h7v8h-7a2 2 0 01-2-2z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 17h2v-6H4v6z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 13V9h6v4H6z" />
    </svg>
    <span>Logistics 1</span>
  </div>

  <!-- Navigation -->
  <nav class="p-4 space-y-2">
    <a href="/logistics1/dashboard/analytics.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Chart Bar Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17V9m4 8V5m4 12v-6" />
      </svg>
      <span class="ml-3">Dashboard</span>
    </a>

    <a href="/logistics1/dashboard/analytics.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Trending Up Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 17l6-6 4 4 8-8" />
      </svg>
      <span class="ml-3">Analytics</span>
    </a>

    <a href="/logistics1/products/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Cube Icon (for Products) -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7" />
      </svg>
      <span class="ml-3">Products</span>
    </a>

    <a href="/logistics1/suppliers/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Office Building Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 3.13a4 4 0 01.88 7.7m-4.1 1.3a4 4 0 10-4.1-6.42" />
      </svg>
      <span class="ml-3">Suppliers</span>
    </a>

    <a href="/logistics1/sws/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Home Icon (for Smart Warehousing) -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m2 13H3a2 2 0 01-2-2v-7a2 2 0 012-2h16a2 2 0 012 2v7a2 2 0 01-2 2z" />
      </svg>
      <span class="ml-3">Smart Warehousing</span>
    </a>

    <a href="/logistics1/psm/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Document Text Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h10M7 16h6" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M14 4H6a2 2 0 00-2 2v12a2 2 0 002 2h8l6-6V6a2 2 0 00-2-2z" />
      </svg>
      <span class="ml-3">Procurement &amp; Sourcing</span>
    </a>

    <a href="/logistics1/plt/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Map Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A2 2 0 013 15.382V5.618a2 2 0 011.447-1.894L9 2m0 18l6-3 5.447 2.724A2 2 0 0021 18.618v-9.764a2 2 0 00-1.447-1.894L15 4m-6 16V4m6 16V4" />
      </svg>
      <span class="ml-3">Project Logistics Tracker</span>
    </a>

    <a href="/logistics1/alms/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Refresh Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582M20 20v-5h-.581M5.64 15.364a9 9 0 0112.72-12.728M18.36 8.636a9 9 0 01-12.72 12.728" />
      </svg>
      <span class="ml-3">Asset Lifecycle</span>
    </a>

    <a href="/logistics1/dtrs/index.php" class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition duration-200">
      <!-- Folder Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H9l-2-2H5a2 2 0 00-2 2z" />
      </svg>
      <span class="ml-3">Document Tracking</span>
    </a>
  </nav>
</aside>

<!-- Main Content -->

</body>
</html>
