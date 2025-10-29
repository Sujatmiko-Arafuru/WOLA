<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai - Sistem Analisis Beban Kerja Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1ca9a0;
            --secondary-color: #17a2b8;
            --accent-green: #20c997;
            --bright-green: #1ca9a0;
            --turquoise: #1ca9a0;
            --deep-teal: #158f87;
            --gold: #ffc107;
            --light-bg: #e8f5f4;
            --dark-text: #0d5551;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1ca9a0 0%, #17a2b8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 10;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--bright-green), var(--accent-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
        }

        .page-title {
            color: var(--dark-text);
            font-weight: bold;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .text-muted {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .form-label {
            color: var(--dark-text);
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            border-left: 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 95, 95, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid #e9ecef;
            color: #6c757d;
            background: white;
        }

        .btn-outline-secondary:hover {
            background: #f8f9fa;
            border-color: var(--accent-green);
            color: var(--accent-green);
        }

        .alert {
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .text-center a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .text-center a:hover {
            color: var(--accent-green);
        }
        
        .btn-back-home {
            position: fixed;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: white;
            border: 2px solid var(--primary-color);
            border-radius: 12px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .btn-back-home:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 169, 160, 0.4);
        }
        
        @media (max-width: 576px) {
            .btn-back-home {
                padding: 10px 16px;
                font-size: 0.85rem;
                top: 15px;
                left: 15px;
            }
            
            .btn-back-home i {
                font-size: 0.9rem;
            }
        }

        /* Ensure all elements are clickable */
        * {
            pointer-events: auto !important;
        }

        .btn, button, input[type="submit"] {
            cursor: pointer !important;
            position: relative;
            z-index: 1000;
        }

        /* Debug outline */
        .btn, button {
            outline: 2px solid rgba(0, 255, 0, 0.5) !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <div class="logo">
                <i class="fas fa-user-tie"></i>
            </div>
            <h3 class="page-title">Login Pegawai</h3>
            <p class="text-muted">Sistem Analisis Beban Kerja Pegawai<br>Poltekkes Kemenkes Denpasar</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="/login-pegawai" id="loginForm">
            @csrf
            
            <div class="mb-3">
                <label for="nip" class="form-label">
                    <i class="fas fa-id-card me-2"></i>NIP
                </label>
                <input type="text" 
                       class="form-control @error('nip') is-invalid @enderror" 
                       id="nip" 
                       name="nip" 
                       value="{{ old('nip') }}" 
                       placeholder="Masukkan NIP Anda"
                       required>
                @error('nip')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">
                    <i class="fas fa-lock me-2"></i>Password
                </label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan password Anda"
                           required>
                    <button class="btn btn-outline-secondary toggle-password" type="button" id="togglePassword">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk
                </button>
            </div>

            <div class="text-center">
                <a href="/login-admin">
                    <i class="fas fa-user-shield me-1"></i>Login sebagai Admin
                </a>
            </div>
        </form>
    </div>
    
    <!-- Tombol Kembali di Pojok Kiri Atas -->
    <a href="/" class="btn-back-home">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Login page loaded successfully');
            
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    console.log('Toggle password clicked');
                    const icon = this.querySelector('i');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            }

            // Form submission
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    console.log('Form submitted!');
                    
                    const nip = document.getElementById('nip').value.trim();
                    const password = document.getElementById('password').value.trim();
                    
                    if (!nip || !password) {
                        e.preventDefault();
                        alert('Mohon lengkapi semua field yang diperlukan.');
                        return false;
                    }
                    
                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                    
                    console.log('Form data:', { nip, password });
                });
            }
            
            // Test button click
            if (submitBtn) {
                submitBtn.addEventListener('click', function(e) {
                    console.log('Submit button clicked!');
                });
            }
            
            // Test all buttons
            const allButtons = document.querySelectorAll('button, .btn');
            allButtons.forEach((btn, index) => {
                btn.addEventListener('click', function(e) {
                    console.log(`Button ${index} clicked:`, this.textContent.trim());
                });
            });
        });
    </script>
</body>
</html>