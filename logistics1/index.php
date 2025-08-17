<?php include('../header.php');?>

    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold">Smart Warehousing</h2>
        <p class="text-gray-600">Manage and track warehouse inventory.</p>
        <a href="sws/index.php" class="mt-3 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Open</a>
    </div>

    <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold">Procurement & Sourcing</h2>
        <p class="text-gray-600">Track procurement and supplier activities.</p>
        <a href="psm/index.php" class="mt-3 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Open</a>
    </div>

    <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold">Project Logistics Tracker</h2>
        <p class="text-gray-600">Monitor project delivery and progress.</p>
        <a href="plt/index.php" class="mt-3 inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Open</a>
    </div>

    <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold">Asset Lifecycle</h2>
        <p class="text-gray-600">Track asset status and maintenance.</p>
        <a href="alms/index.php" class="mt-3 inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Open</a>
    </div>

    <div class="bg-white p-6 rounded shadow hover:shadow-lg transition">
        <h2 class="text-lg font-semibold">Document Tracking</h2>
        <p class="text-gray-600">Manage and store logistics documents.</p>
        <a href="dtrs/index.php" class="mt-3 inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Open</a>
    </div>
</div>

<?php include('footer.php'); ?>
