<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - TalentFlow HR Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .logout-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .logout-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .logout-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--warning), #ff6b6b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(247, 37, 133, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(247, 37, 133, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(247, 37, 133, 0);
            }
        }

        .logout-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .logout-message {
            font-size: 1.1rem;
            color: var(--gray);
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        .user-info {
            background: var(--light);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            border-left: 4px solid var(--primary);
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .user-email {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 140px;
            justify-content: center;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .btn-secondary {
            background: var(--light-gray);
            color: var(--dark);
            border: 1px solid #dee2e6;
        }

        .btn-secondary:hover {
            background: #e2e6ea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #856404;
        }

        .security-notice i {
            margin-right: 0.5rem;
            color: #f39c12;
        }

        .footer-links {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--light-gray);
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            font-size: 0.9rem;
            margin: 0 1rem;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logout-container {
                padding: 2rem;
                margin: 1rem;
            }

            .logout-title {
                font-size: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .footer-links a {
                display: block;
                margin: 0.5rem 0;
            }
        }

        /* Loading state */
        .btn-danger.loading {
            position: relative;
            color: transparent;
        }

        .btn-danger.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-icon">
            <i class="fas fa-sign-out-alt"></i>
        </div>

        <h1 class="logout-title">Confirm Logout</h1>
        <p class="logout-message">
            Are you sure you want to sign out of your TalentFlow HR Management account?
        </p>

        @auth
            <div class="user-info">
                <div class="user-avatar">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-email">{{ Auth::user()->email }}</div>
            </div>
        @endauth

        <div class="button-group">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-danger" id="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Yes, Sign Out
                </button>
            </form>
            
            <a href="{{ route('home') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Cancel
            </a>
        </div>

        <div class="security-notice">
            <i class="fas fa-shield-alt"></i>
            For your security, you will be logged out of all devices and sessions.
        </div>

        <div class="footer-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('profile.edit') }}">Profile</a>
        </div>
    </div>

    <script>
        document.getElementById('logout-form').addEventListener('submit', function(e) {
            const button = document.getElementById('logout-btn');
            button.classList.add('loading');
            button.disabled = true;
            
            // Add a small delay to show the loading state
            setTimeout(() => {
                // Form will submit naturally
            }, 500);
        });

        // Add keyboard shortcut for quick logout (Ctrl/Cmd + Shift + L)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && e.key === 'L') {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            }
        });

        // Add escape key to cancel
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                window.location.href = '{{ route("home") }}';
            }
        });
    </script>
</body>
</html>