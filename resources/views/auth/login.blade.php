<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HR Management System</title>
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
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(120deg, #f5f7fb 0%, #e9ecef 100%);
            color: #333;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 500px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .login-left {
            flex: 1;
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            z-index: 1;
        }

        .logo i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }

        .welcome-text h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            z-index: 1;
        }

        .welcome-text p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 1.5rem;
            z-index: 1;
        }

        .features-list {
            list-style: none;
            z-index: 1;
        }

        .features-list li {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            font-size: 0.85rem;
        }

        .features-list i {
            margin-right: 0.8rem;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }

        .login-right {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.4rem;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 2px solid var(--light-gray);
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .input-error {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.4rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .remember-me input {
            margin-right: 0.5rem;
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn {
            display: inline-block;
            width: 100%;
            padding: 0.8rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            text-align: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            box-shadow: var(--box-shadow);
        }

        .session-status {
            padding: 0.8rem;
            background: rgba(76, 201, 240, 0.1);
            border-left: 4px solid var(--success);
            border-radius: 4px;
            margin-bottom: 1rem;
            color: var(--dark);
            font-size: 0.85rem;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1rem 0;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--light-gray);
        }

        .divider span {
            padding: 0 0.8rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--dark);
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .social-btn:hover {
            background: var(--primary);
            color: white;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-width: 450px;
            }
            
            .login-left {
                padding: 1.5rem;
            }
            
            .welcome-text h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side with Branding -->
        <div class="login-left">
            <div class="logo">
                <i class="fas fa-users"></i>
                TalentFlow HR
            </div>
            
            <div class="welcome-text">
                <h1>Welcome Back!</h1>
                <p>Sign in to access your HR management dashboard</p>
            </div>
            
            <ul class="features-list">
                <li><i class="fas fa-check"></i> Employee Management</li>
                <li><i class="fas fa-check"></i> Payroll Processing</li>
                <li><i class="fas fa-check"></i> Attendance Tracking</li>
                <li><i class="fas fa-check"></i> Performance Reviews</li>
            </ul>
        </div>
        
        <!-- Right Side with Login Form -->
        <div class="login-right">
            <!-- <div class="login-header">
                <h2>Sign In</h2>
                <p>Enter your credentials to access your account</p>
            </div> -->
            
            <!-- Session Status -->
            <!-- <div class="session-status">
                Session status message would appear here
            </div> -->
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="Enter your email">
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <!-- Remember Me -->
                <div class="remember-forgot">
                    <div class="remember-me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <label for="remember_me">Remember me</label>
                    </div>
                    
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-primary">
                    Sign In
                </button>
            </form>
            
            <div class="divider">
                <span>Or continue with</span>
            </div>
            
            <div class="social-login">
                <a href="#" class="social-btn">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#" class="social-btn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-btn">
                    <i class="fab fa-microsoft"></i>
                </a>
            </div>
            
            <div class="register-link">
                Don't have an account? <a href="{{route ('register')}}">Contact administrator</a>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation and animation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('.form-control');
            
            // Add focus effects
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Form submission
            form.addEventListener('submit', function(e) {
                // Laravel will handle validation, this is just for UX
                let isValid = true;
                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = 'var(--danger)';
                    } else {
                        input.style.borderColor = '';
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>