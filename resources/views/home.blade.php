<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Management System | ik</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary:rgb(39, 97, 163);
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
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            border-radius: 30px;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: var(--box-shadow);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--box-shadow);
        }

        /* Header Styles */
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .logo i {
            margin-right: 0.5rem;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin: 0 1rem;
        }

        .nav-links a {
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
        }

        .auth-buttons .btn {
            margin-left: 1rem;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 0 5rem;
            background: linear-gradient(120deg, #f5f7fb 0%, #e9ecef 100%);
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-text {
            flex: 1;
            padding-right: 2rem;
        }

        .hero-text h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark);
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: var(--gray);
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.2rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--box-shadow);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
        }

        /* Testimonials */
        .testimonials {
            padding: 5rem 0;
            background: linear-gradient(120deg, #f5f7fb 0%, #e9ecef 100%);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            color: var(--gray);
        }

        .testimonial-author {
            display: flex;
            align-items: center;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 1rem;
        }

        .author-info h4 {
            font-weight: 600;
            color: var(--dark);
        }

        .author-info p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* CTA Section */
        .cta {
            padding: 5rem 0;
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        .cta .btn {
            background: white;
            color: var(--primary);
            font-weight: 600;
        }

        .cta .btn:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px);
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            transition: var(--transition);
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Mobile Navigation */
        .mobile-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-menu a, .dropdown-menu button {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
        }

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-text {
                padding-right: 0;
                margin-bottom: 2rem;
            }
            
            .hero-text h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .nav-links, .auth-buttons {
                display: none;
            }
            
            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background: white;
                padding: 1rem;
                box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            }
            
            .nav-links.active li {
                margin: 0.5rem 0;
            }
            
            .hero-text h1 {
                font-size: 2rem;
            }
            
            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-users"></i>
                    ik 
                </a>
                
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <!-- <li><a href="#pricing">Pricing</a></li> -->
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
                
                <div class="auth-buttons">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-outline dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="userDropdown">
                                @php
                                    $dashboardRoute = match(Auth::user()->role) {
                                        'superadmin' => route('superadmin.dashboard'),
                                        'manager' => route('manager.dashboard'),
                                        'employee' => route('employee.dashboard'),
                                        default => route('dashboard')
                                    };
                                @endphp
                                <a class="dropdown-item" href="{{ $dashboardRoute }}">Dashboard</a>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('logout.confirm') }}">Logout</a>
                            </div>
                        </div>
                    @endguest
                </div>
                
                <div class="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    @auth
                        <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                        <p>Continue managing your HR processes with our comprehensive platform. Access your dashboard to view latest updates and manage your team.</p>
                    @else
                        <h1>Modern HR Management for Growing Businesses</h1>
                        <p>Streamline your HR processes with our all-in-one platform designed to manage employees, payroll, attendance, and more.</p>
                    @endauth
                    <div class="hero-buttons">
                        @auth
                            @php
                                $dashboardRoute = match(Auth::user()->role) {
                                    'superadmin' => route('superadmin.dashboard'),
                                    'manager' => route('manager.dashboard'),
                                    'employee' => route('employee.dashboard'),
                                    default => route('dashboard')
                                };
                            @endphp
                            <a href="{{ $dashboardRoute }}" class="btn btn-primary">Go to Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline">Manage Profile</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                            <a href="{{ route('login') }}" class="btn btn-outline">Learn More</a>
                        @endauth
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&h=400&q=80" alt="HR Management Dashboard">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features</h2>
                <p>Everything you need to manage your human resources efficiently</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h3>Employee Management</h3>
                    <p>Centralize all employee information, documents, and history in one secure location.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Attendance Tracking</h3>
                    <p>Monitor employee attendance, leaves, and time-off requests with our intuitive system.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Payroll Processing</h3>
                    <p>Automate your payroll calculations, tax deductions, and payment processing.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Performance Reviews</h3>
                    <p>Conduct regular performance evaluations and track employee growth over time.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>Recruitment Tools</h3>
                    <p>Streamline your hiring process from job posting to onboarding new employees.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security & Compliance</h3>
                    <p>Ensure data security and compliance with labor regulations and privacy laws.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->

<section class="testimonials" id="about">
    <div class="container">
        <div class="section-title">
            <h2>What Our Clients Say</h2>
            <p>Hear from businesses that have transformed their HR processes with our platform</p>
        </div>

        <div class="testimonials-grid">
            @php
                $testimonials = [
                    [
                        'text' => "ik has revolutionized how we manage our HR processes. We've reduced administrative work by 60% and improved employee satisfaction significantly.",
                        'name' => "Al Imran Emon",
                        'role' => "HR Director, zZone Ecommerce"
                    ],
                    [
                        'text' => "The payroll automation alone has saved us countless hours each month. The reporting features have given us insights we never had before.",
                        'name' => "Mhamuda Jhuma",
                        'role' => "CFO, CareerBridge"
                    ],
                    [
                        'text' => "Implementation was smooth, and the support team was incredibly helpful. Our employees find the system intuitive and easy to use.",
                        'name' => "Abdul Aziz",
                        'role' => "Operations Manager, Social Talk"
                    ],
                ];
            @endphp

            @foreach ($testimonials as $t)
                @php
                    $initials = collect(explode(' ', $t['name']))
                        ->map(fn($word) => strtoupper($word[0]))
                        ->join('');
                    $initials = substr($initials, 0, 2); // keep max 2 letters
                @endphp

                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "{{ $t['text'] }}"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">{{ $initials }}</div>
                        <div class="author-info">
                            <h4>{{ $t['name'] }}</h4>
                            <p>{{ $t['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


    <!-- <section class="testimonials" id="about">
        <div class="container">
            <div class="section-title">
                <h2>What Our Clients Say</h2>
                <p>Hear from businesses that have transformed their HR processes with our platform</p>
            </div>
            
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "ik has revolutionized how we manage our HR processes. We've reduced administrative work by 60% and improved employee satisfaction significantly."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">IE</div>
                        <div class="author-info">
                            <h4>Al Imran Emon</h4>
                            <p>HR Director, zZone Ecommerce</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "The payroll automation alone has saved us countless hours each month. The reporting features have given us insights we never had before."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">MJ</div>
                        <div class="author-info">
                            <h4>Mhamuda Jhuma</h4>
                            <p>CFO, CarrerBridge</p>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-text">
                        "Implementation was smooth, and the support team was incredibly helpful. Our employees find the system intuitive and easy to use."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">AA</div>
                        <div class="author-info">
                            <h4>Abdul Aziz</h4>
                            <p>Operations Manager, Social Talk</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- CTA Section -->
    <section class="cta" id="pricing">
        <div class="container">
            <h2>Ready to Transform Your HR Management?</h2>
            <p>Join thousands of companies that have streamlined their HR processes with TalentFlow. Get started today with our 14-day free trial.</p>
            @auth
                @php
                    $dashboardRoute = match(Auth::user()->role) {
                        'superadmin' => route('superadmin.dashboard'),
                        'manager' => route('manager.dashboard'),
                        'employee' => route('employee.dashboard'),
                        default => route('dashboard')
                    };
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn">Start Free Trial</a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>ik </h3>
                    <p>Modern HR management solutions for businesses of all sizes.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="#">Features</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Case Studies</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Tutorials</a></li>
                        <li><a href="#">Webinars</a></li>
                        <li><a href="#">Documentation</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Partners</a></li>
                        <li><a href="#">Press</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ik HR Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile navigation toggle
        document.querySelector('.mobile-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
        
        // Simple animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            
            function checkIfInView() {
                featureCards.forEach(card => {
                    const position = card.getBoundingClientRect();
                    
                    if (position.top < window.innerHeight && position.bottom >= 0) {
                        card.style.opacity = 1;
                        card.style.transform = 'translateY(0)';
                    }
                });
            }
            
            // Initialize
            featureCards.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            
            window.addEventListener('scroll', checkIfInView);
            window.addEventListener('load', checkIfInView);
        });
    </script>
</body>
</html>