// Manager Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }
    
    // Close sidebar when overlay is clicked
    if (overlay) {
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
    
    // Auto-hide mobile sidebar when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }
    });
    
    // Add loading states to buttons
    const actionButtons = document.querySelectorAll('.tool-card .btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.tagName === 'BUTTON') {
                e.preventDefault();
                this.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
                this.disabled = true;
                
                // Re-enable after 2 seconds (simulate loading)
                setTimeout(() => {
                    this.disabled = false;
                    this.innerHTML = this.getAttribute('data-original-text') || 'Action';
                }, 2000);
            }
        });
    });
    
    // Animate stats on page load
    const statNumbers = document.querySelectorAll('.stat-card h2');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent) || 0;
        let currentValue = 0;
        const increment = finalValue / 20;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                stat.textContent = finalValue;
                clearInterval(timer);
            } else {
                stat.textContent = Math.floor(currentValue);
            }
        }, 50);
    });
    
    // Add real-time clock
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        const clockElement = document.querySelector('.current-time');
        if (clockElement) {
            clockElement.textContent = timeString;
        }
    }
    
    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call
    
    // Add tooltips to navigation items
    const navLinks = document.querySelectorAll('.sidebar .nav-link');
    navLinks.forEach(link => {
        link.setAttribute('title', link.textContent.trim());
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Enhanced functionality for manager views
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.classList.contains('show')) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });
    
    // Form validation for settings
    const settingsForm = document.querySelector('form[method="PATCH"]');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            const teamSizeLimit = document.getElementById('team_size_limit');
            if (teamSizeLimit && (teamSizeLimit.value < 1 || teamSizeLimit.value > 100)) {
                e.preventDefault();
                alert('Team size limit must be between 1 and 100');
                teamSizeLimit.focus();
            }
        });
    }
    
    // Notification mark as read functionality
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            if (this.classList.contains('unread')) {
                this.classList.remove('unread');
                const badge = this.querySelector('.badge');
                if (badge) badge.remove();
            }
        });
    });
    
    // Message priority color coding
    const messageRows = document.querySelectorAll('table tbody tr');
    messageRows.forEach(row => {
        const priorityCell = row.querySelector('td:nth-child(4)');
        if (priorityCell) {
            const priority = priorityCell.textContent.toLowerCase().trim();
            if (priority.includes('high')) {
                row.classList.add('message-priority-high');
            } else if (priority.includes('normal')) {
                row.classList.add('message-priority-normal');
            } else if (priority.includes('low')) {
                row.classList.add('message-priority-low');
            }
        }
    });
    
    // Attendance bar hover effects
    const attendanceBars = document.querySelectorAll('.attendance-bar');
    attendanceBars.forEach(bar => {
        bar.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        });
        
        bar.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
    
    // Enhanced table row interactions
    const tableRows = document.querySelectorAll('.table-hover tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(0,123,255,0.05)';
            this.style.transform = 'scale(1.005)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.transform = 'scale(1)';
        });
    });
    
    // Form switch animations
    const formSwitches = document.querySelectorAll('.form-switch .form-check-input');
    formSwitches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            this.style.transform = 'scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 200);
        });
    });
    
    // Button group hover effects
    const btnGroups = document.querySelectorAll('.btn-group .btn');
    btnGroups.forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.zIndex = '2';
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.zIndex = '';
            this.style.transform = 'translateY(0)';
        });
    });
});