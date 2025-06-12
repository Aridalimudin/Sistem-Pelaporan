<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link rel="Icon" type="png" href="{{asset('images/logoMts.png')}}"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .has-submenu > a .submenu-indicator {
            margin-right: 20px !important;
        }   
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --text-color: #333;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --danger-color: #e63946;
            --warning-color: #ffb703;
            --success-color: #52b788;
            --info-color: #4cc9f0;
            --transition: all 0.3s ease;
            --border-radius: 10px;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            color: var(--text-color);
            padding: 20px;
        }

        /* Header Section */
        .header {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        /* Management Section */
        .management-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header h2 {
            font-size: 1.3rem;
            color: var(--text-color);
            margin: 0;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-1px);
        }

        /* Table Styles */
        .table-container {
            padding: 20px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        .data-table th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .user-info-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .role-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .role-badge.superadmin { background: #fee2e2; color: #ef4444; } /* Adjusted for superadmin */
        .role-badge.gurubk { background: #dbeafe; color: #3b82f6; } /* Adjusted for GuruBK */
        .role-badge.user { background: #e0f2f7; color: #007bb6; } /* Example for 'user' if you add it later */
        /* Default role badge for undefined roles */
        .role-badge:not(.superadmin):not(.gurubk) { background: #e2e8f0; color: #4a5568; }

        /* Removed status-badge styles as status is no longer displayed */

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .btn-action.edit {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }

        .btn-action.delete {
            background: rgba(230, 57, 70, 0.1);
            color: var(--danger-color);
        }
        .close-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #666;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .close-btn:hover {
            background: rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        /* Form Styles */
        .user-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-color);
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            padding: 12px 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }

        .password-input {
            position: relative;
        }

        .password-input input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #a0aec0;
            font-size: 1rem;
            padding: 5px;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-danger:hover {
            background: #d62839; /* Slightly darker red on hover */
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Status indicator (Toast) */
        .status-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
            z-index: 1001;
            transform: translateX(300px);
            transition: transform 0.3s ease;
            box-shadow: var(--shadow);
            word-break: break-word; /* Ensure long messages break properly */
            max-width: 300px; /* Limit width */
        }

        .status-indicator.show {
            transform: translateX(0);
        }

        /* Konfirmasi Delete Modal Styles */
        .delete-confirm-modal .modal {
            max-width: 400px;
            text-align: center;
        }

        .delete-confirm-modal .modal-body {
            padding: 30px;
        }

        .delete-confirm-modal .modal-body p {
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .delete-confirm-modal .modal-footer {
            padding: 15px 25px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
         .permission-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .permission-badge {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
        }
    </style>
    @stack('styles')
    
</head>

<body class="bg-light">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            @include('layouts.sidebar_admin')
            
            <!-- Content -->
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @stack('scripts')
</body>
</html>