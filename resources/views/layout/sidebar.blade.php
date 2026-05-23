<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel with Toggle Sidebar</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <h4><i class="bi bi-person"></i> <span class="logo-text">Food Delivery App</span></h4>
        <a href="index.html" class="active"><i class="bi bi-person"></i> <span>User Management</span></a>
        <a href="table.html"><i class="bi bi-telephone"></i> <span>Restaurant</span></a>
        <a href="#"><i class="bi bi-star"></i> <span>Customers</span></a>
        <a href="#"><i class="bi bi-bar-chart"></i> <span>Orders</span></a>
        <a href="#"><i class="bi bi-graph-up"></i> <span>CMS</span></a>
        <a href="#"><i class="bi bi-graph-up"></i> <span>Support</span></a>
        <a href="#"><i class="bi bi-graph-up"></i> <span>Restaurant Review</span></a>
        <a href="#"><i class="bi bi-graph-up"></i> <span>Offers</span></a>

    </div>

    <!-- Main Content -->
    {{-- <div id="main-content" class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
            <div class="dropdown profile-dropdown">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">

                    <i class="bi bi-person"></i>
                    <span class="fw-semibold">User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div> --}}
