<!-- resources/views/pages/forgot-password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Wedding Hall Booking</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        .auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            font-weight: 700;
            font-size: 1.5rem;
            color: #6366f1;
            text-decoration: none;
        }

        .auth-logo:hover {
            color: #4f46e5;
        }

        .auth-title {
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #1e293b;
        }

        .auth-subtitle {
            color: #64748b;
            margin-bottom: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-control {
            padding: 1rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .auth-btn {
            width: 100%;
            padding: 1rem;
            background: #6366f1;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .auth-btn:hover {
            background: #4f46e5;
            transform: translateY(-1px);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            text-decoration: none;
            margin-top: 1.5rem;
        }

        .back-link:hover {
            color: #475569;
        }

        .success-message {
            display: none;
            text-align: center;
            padding: 2rem 0;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #10b981;
            font-size: 2rem;
        }

        .instruction-list {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .instruction-list li {
            padding: 0.5rem 0;
            color: #64748b;
            display: flex;
            align-items: center;
        }

        .instruction-list i {
            color: #10b981;
            margin-right: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <a href="{{ route('home') }}" class="auth-logo">
                <i class="fas fa-heart text-primary"></i>
                <span>WeddingHalls</span>
            </a>

            <div id="resetForm">
                <h1 class="auth-title">Forgot Password?</h1>
                <p class="auth-subtitle">Enter your email address and we'll send you instructions to reset your password.</p>

                <form onsubmit="handleResetRequest(event)">
                    <div class="form-floating">
                        <input type="email"
                               class="form-control"
                               id="resetEmail"
                               placeholder="name@example.com"
                               required>
                        <label for="resetEmail">
                            <i class="fas fa-envelope me-2"></i> Email Address
                        </label>
                    </div>

                    <button type="submit" class="auth-btn">
                        <i class="fas fa-paper-plane me-2"></i> Send Reset Instructions
                    </button>
                </form>

                <a href="{{ route('login') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i> Back to Login
                </a>
            </div>

            <div id="successMessage" class="success-message">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>

                <h3 class="auth-title">Check Your Email</h3>
                <p class="auth-subtitle">We've sent password reset instructions to your email address.</p>

                <ul class="instruction-list">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        Check your inbox for our email
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        Click the reset link in the email
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        Create a new password
                    </li>
                </ul>

                <div class="mt-4">
                    <button class="auth-btn" onclick="resendInstructions()">
                        <i class="fas fa-redo me-2"></i> Resend Instructions
                    </button>
                </div>

                <a href="{{ route('login') }}" class="back-link mt-3">
                    <i class="fas fa-arrow-left"></i> Return to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        function handleResetRequest(event) {
            event.preventDefault();

            const email = document.getElementById('resetEmail').value;

            if (!email) {
                showToast('Please enter your email address', 'error');
                return;
            }

            // In a real app, you would make an API call here
            // For demo, simulate successful request
            document.getElementById('resetForm').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';

            showToast('Reset instructions sent to your email', 'success');
        }

        function resendInstructions() {
            const email = document.getElementById('resetEmail').value;

            // In a real app, you would make an API call here
            showToast('Reset instructions resent to ' + email, 'success');
        }

        function showToast(message, type = 'success') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#10b981' : '#ef4444'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;

            toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
