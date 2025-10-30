<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Analisis Beban Kerja Pegawai - Poltekkes Kemenkes Denpasar</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1ca9a0 0%, #17a2b8 100%);
            min-height: 100vh;
            color: var(--dark-text);
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><rect width="20" height="20" fill="%231ca9a0" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.5;
            z-index: -1;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #1ca9a0, #17a2b8);
            padding: 1rem 0;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            max-width: 250px;
            height: auto;
            object-fit: contain;
        }
        
        .logo-placeholder {
            width: 250px;
            height: 68px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            border: 2px solid rgba(255, 255, 255, 0.4);
            font-weight: 600;
        }

        .logo-text {
            color: white;
        }

        .logo-text h4 {
            margin: 0;
            font-weight: bold;
            font-size: 1.4rem;
        }

        .logo-text p {
            margin: 0;
            font-size: 1rem;
            opacity: 0.95;
        }

        .system-title {
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
        }


        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
            z-index: 5;
        }

        .content-container {
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 2rem;
            font-weight: 500;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .description {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            line-height: 1.7;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.15);
        }

        .cta-buttons {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: #0d5551;
            padding: 1rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            position: relative;
            z-index: 1000;
            pointer-events: auto !important;
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(255, 193, 7, 0.5);
            color: #0d5551;
            text-decoration: none;
            background: linear-gradient(135deg, #ffca28, #ffc107);
        }

        .cta-btn.secondary {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
            color: #1ca9a0;
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .cta-btn.secondary:hover {
            box-shadow: 0 12px 35px rgba(255, 255, 255, 0.4);
            background: linear-gradient(135deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.95));
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #158f87, #0d6b63);
            color: white;
            text-align: center;
            padding: 2rem 0;
            position: relative;
            z-index: 1;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.15);
        }

        .footer-content {
            position: relative;
            z-index: 1;
        }

        /* Ensure all interactive elements are clickable */
        a, button, .cta-btn {
            pointer-events: auto !important;
            user-select: none;
            position: relative;
            z-index: 1000;
        }
        
        a:hover, button:hover, .cta-btn:hover {
            pointer-events: auto !important;
            text-decoration: none !important;
        }
        
        /* Override any potential blocking styles */
        * {
            pointer-events: auto !important;
        }
        
        .cta-btn * {
            pointer-events: auto !important;
        }
        
        /* Ensure no element blocks clicks */
        .header, .main-content, .footer {
            pointer-events: auto !important;
        }
        
        .header *, .main-content *, .footer * {
            pointer-events: auto !important;
        }
        
        /* Specific fix for potential issues */
        .container, .row, .col-12 {
            pointer-events: auto !important;
        }
        
        /* Force clickable elements */
        .cta-buttons {
            pointer-events: auto !important;
        }
        
        .cta-buttons * {
            pointer-events: auto !important;
        }
        
        /* Ensure all links work */
        a[href] {
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        
        /* Debug: Highlight clickable elements */
        .cta-btn {
            outline: 2px solid rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Ensure no CSS conflicts */
        .cta-btn:focus {
            outline: 2px solid rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Force display and positioning */
        .cta-btn {
            display: flex !important;
            position: relative !important;
            z-index: 1000 !important;
        }
        
        /* CTA Button styles - Duplicate removed, using above definition */

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-title {
                font-size: 2rem;
            }
            
            .welcome-subtitle {
                font-size: 1rem;
            }
            
            .description {
                font-size: 0.9rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
            
            .system-title {
                font-size: 1rem;
            }
            
            .logo-text h4 {
                font-size: 1.1rem;
            }
            
            .logo-text p {
                font-size: 0.85rem;
            }
            
            .logo, .logo-placeholder {
                max-width: 180px;
                height: auto;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding: 0.5rem 0;
            }
            
            .logo, .logo-placeholder {
                max-width: 150px;
                height: auto;
            }
            
            .logo-container {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .content-container {
                padding: 1rem;
            }
        }
            </style>
    </head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="logo-container">
                        <!-- Ganti src dengan path logo Anda yang berukuran 1062x289 -->
                        <img src="/images/logo-poltekkes-denpasar.png" alt="Logo Poltekkes Kemenkes Denpasar" class="logo">
                        <!-- Atau gunakan placeholder sementara sampai logo diupload -->
                        <!-- <div class="logo-placeholder">Logo 1062x289</div> -->
                        <div class="logo-text">
                            <h4>Poltekkes Kemenkes Denpasar</h4>
                            <p>Sistem Analisis Beban Kerja Pegawai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="content-container">
                <h1 class="welcome-title">Selamat Datang di</h1>
                <h2 class="welcome-subtitle">Sistem Analisis Beban Kerja Pegawai</h2>
                <p class="description">
                    Solusi digital terintegrasi untuk mengelola dan menganalisis beban kerja pegawai Poltekkes Kemenkes Denpasar. 
                    Sistem ini memungkinkan pegawai untuk melaporkan beban kerja mereka dengan mudah, sementara administrator 
                    dapat memantau dan menganalisis distribusi beban kerja secara real-time untuk optimasi sumber daya manusia.
                </p>
                
                <div class="cta-buttons">
                    <a href="{{ route('login.pegawai') }}" class="cta-btn">
                        <i class="fas fa-user"></i>
                        Login Sebagai Pegawai
                    </a>
                    <a href="{{ route('login.admin') }}" class="cta-btn secondary">
                        <i class="fas fa-user-shield"></i>
                        Login Sebagai Admin
                    </a>
                </div>
                </div>
                </div>
            </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p class="mb-0">© 2025 POLTEKKES KEMENKES DENPASAR - Sistem Analisis Beban Kerja Pegawai</p>
            </div>
        </div>
    </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <script>
            // Debug: Pastikan semua link berfungsi
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Landing page loaded successfully');
                
                // Test semua link
                const links = document.querySelectorAll('a');
                links.forEach(link => {
                    console.log('Link found:', link.href, link.textContent.trim());
                    
                    // Pastikan link tidak di-block
                    link.addEventListener('click', function(e) {
                        console.log('Link clicked:', this.href);
                        // Jangan prevent default, biarkan link berfungsi normal
                        // e.preventDefault(); // JANGAN UNCOMMENT INI
                    });
                });
                
                // Pastikan tombol dapat diklik
                const buttons = document.querySelectorAll('.cta-btn');
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        console.log('Button clicked:', this.textContent.trim(), this.href);
                        // Jangan prevent default, biarkan link berfungsi normal
                        // e.preventDefault(); // JANGAN UNCOMMENT INI
                    });
                });
                
                // Test jika ada elemen yang menghalangi klik
                document.addEventListener('click', function(e) {
                    console.log('Click detected on:', e.target);
                });
                
                // Pastikan tidak ada elemen yang menghalangi
                const allElements = document.querySelectorAll('*');
                allElements.forEach(el => {
                    if (getComputedStyle(el).pointerEvents === 'none') {
                        console.warn('Element with pointer-events: none found:', el);
                    }
                });
            });
        </script>
    </body>
</html>
