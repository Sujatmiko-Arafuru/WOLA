<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Analisis Beban Kerja Pegawai') - Poltekkes Kemenkes Denpasar</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #1e5f5f;
            --secondary-color: #2d8f8f;
            --success-color: #27ae60;
            --warning-color: #f1c40f;
            --danger-color: #e74c3c;
            --light-bg: #f0f8f8;
            --dark-text: #1e5f5f;
            --accent-green: #2ecc71;
            --deep-teal: #1a4d4d;
            --bright-green: #00d084;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color) !important;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
            border-radius: 10px;
        }

        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
            border-radius: 10px;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            border-radius: 10px;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
        }

        .badge {
            border-radius: 20px;
            padding: 8px 12px;
            font-weight: 500;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            border-radius: 0 20px 20px 0;
        }

        .sidebar .nav-link {
            color: white;
            padding: 15px 20px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stats-card .card-body {
            padding: 2rem;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
        }

        .login-container {
            background: linear-gradient(135deg, var(--deep-teal), var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="confetti" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect width="2" height="2" fill="%23f1c40f" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23confetti)"/></svg>');
            opacity: 0.1;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--bright-green), var(--accent-green), var(--secondary-color));
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(0, 208, 132, 0.3);
        }

        .page-title {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 2rem;
            text-align: center;
        }

        .loading {
            display: none;
        }

        .loading.show {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                border-radius: 0;
            }
            
        .login-card {
            margin: 1rem;
            padding: 2rem;
        }
        
        /* Ensure all buttons are clickable */
        .btn, button, input[type="submit"] {
            pointer-events: auto !important;
            cursor: pointer !important;
            position: relative;
            z-index: 1000;
        }
        
        .btn:hover, button:hover, input[type="submit"]:hover {
            pointer-events: auto !important;
        }
        
        /* Ensure forms work */
        form {
            pointer-events: auto !important;
        }
        
        form * {
            pointer-events: auto !important;
        }
        
        /* Force all interactive elements to work */
        .btn-primary, .btn-secondary, .btn-outline-secondary {
            pointer-events: auto !important;
            cursor: pointer !important;
            z-index: 1000 !important;
        }
        
        /* Ensure no CSS conflicts */
        .btn:disabled {
            pointer-events: none !important;
        }
        
        .btn:not(:disabled) {
            pointer-events: auto !important;
        }
        
        /* Debug: Highlight clickable elements */
        .btn, button {
            outline: 2px solid rgba(0, 255, 0, 0.3) !important;
        }
        
        /* Ensure no CSS conflicts */
        .btn:focus, button:focus {
            outline: 2px solid rgba(0, 255, 0, 0.8) !important;
        }
        
        /* Force all elements to be clickable */
        * {
            pointer-events: auto !important;
        }
        
        /* Override any potential blocking */
        .login-container, .login-card {
            pointer-events: auto !important;
        }
        
        .login-container *, .login-card * {
            pointer-events: auto !important;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script>
        // Auto hide alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Loading state for forms
        $('form').on('submit', function() {
            $(this).find('.btn').prop('disabled', true);
            $(this).find('.loading').addClass('show');
        });

        // Confirm delete
        $('.btn-delete').on('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            const input = $(this).siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        
        // Debug: Ensure all forms work
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Layout loaded successfully');
            
            // Test all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                console.log('Form found:', form.action, form.method);
                
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted:', this.action, this.method);
                });
            });
            
            // Test all buttons
            const buttons = document.querySelectorAll('button, .btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    console.log('Button clicked:', this.textContent.trim(), this.type);
                });
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>
