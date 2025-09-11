<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | HR Management System</title>
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

        .register-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 500px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }

        .register-left {
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

        .register-left::before {
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

        .register-right {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .register-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .register-header p {
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
            margin-top: 0.8rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            box-shadow: var(--box-shadow);
        }

        .login-link {
            text-align: center;
            margin-top: 1.2rem;
            color: var(--gray);
            font-size: 0.85rem;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .password-strength {
            margin-top: 0.4rem;
            height: 4px;
            background: var(--light-gray);
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-meter {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease;
        }

        .strength-weak { background: var(--danger); width: 33%; }
        .strength-medium { background: var(--warning); width: 66%; }
        .strength-strong { background: var(--success); width: 100%; }

        .password-strength-text {
            font-size: 0.75rem;
            margin-top: 0.3rem;
            color: var(--gray);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                height: auto;
                max-width: 450px;
            }
            
            .register-left {
                padding: 1.5rem;
            }
            
            .welcome-text h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left Side with Branding -->
        <div class="register-left">
            <div class="logo">
                <i class="fas fa-users"></i>
                HR Management System
            </div>
            
            <div class="welcome-text">
                <h3>Join Our Team!</h3>
                <p>Create your account to access the HR management system</p>
            </div>
            
            <ul class="features-list">
                <li><i class="fas fa-check"></i> Employee Self-Service</li>
                <li><i class="fas fa-check"></i> Time & Attendance</li>
                <li><i class="fas fa-check"></i> Payroll Information</li>
                <li><i class="fas fa-check"></i> Benefits Management</li>
            </ul>
        </div>
        
        <!-- Right Side with Registration Form -->
        <div class="register-right">
            <div class="register-header">
                <!-- <h2>Create Account</h2>
                <p>Fill in your details to get started</p> -->
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your full name">
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email">
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Create a secure password">
                    <div class="password-strength">
                        <div class="strength-meter" id="password-strength-meter"></div>
                    </div>
                    <div class="password-strength-text" id="password-strength-text">Password strength</div>
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                    <!-- <div class="input-error">Error message would appear here</div> -->
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Account
                </button>
            </form>
            
            <div class="login-link">
                Already have an account? <a href="{{ route('login') }}">Sign in here</a>
            </div>
        </div>
    </div>

    <script>
        // Password strength indicator
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const strengthMeter = document.getElementById('password-strength-meter');
            const strengthText = document.getElementById('password-strength-text');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Check password length
                if (password.length > 0) {
                    if (password.length < 6) {
                        strength = 1;
                    } else if (password.length < 10) {
                        strength = 2;
                    } else {
                        strength = 3;
                    }
                    
                    // Check for character variety
                    if ((password.match(/[a-z]/) && password.match(/[A-Z]/)) || 
                        (password.match(/[a-z]/) && password.match(/[0-9]/)) || 
                        (password.match(/[A-Z]/) && password.match(/[0-9]/))) {
                        strength++;
                    }
                    
                    // Check for special characters
                    if (password.match(/[^a-zA-Z0-9]/)) {
                        strength++;
                    }
                    
                    // Cap strength at 3 for UI
                    strength = Math.min(strength, 3);
                    
                    // Update UI
                    strengthMeter.className = 'strength-meter';
                    if (strength === 1) {
                        strengthMeter.classList.add('strength-weak');
                        strengthText.textContent = 'Weak password';
                        strengthText.style.color = 'var(--danger)';
                    } else if (strength === 2) {
                        strengthMeter.classList.add('strength-medium');
                        strengthText.textContent = 'Medium strength';
                        strengthText.style.color = 'var(--warning)';
                    } else if (strength === 3) {
                        strengthMeter.classList.add('strength-strong');
                        strengthText.textContent = 'Strong password';
                        strengthText.style.color = 'var(--success)';
                    }
                } else {
                    strengthMeter.className = 'strength-meter';
                    strengthText.textContent = 'Password strength';
                    strengthText.style.color = 'var(--gray)';
                }
            });
        });
    </script>
</body>
</html>