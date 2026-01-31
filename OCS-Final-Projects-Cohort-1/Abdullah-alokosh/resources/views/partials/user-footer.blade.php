<!-- resources/views/partials/user-footer.blade.php -->
<style>
    /* متغيرات التصميم */
    :root {
        --footer-gold: #D4AF37;
        --footer-gold-light: #F4E4B5;
        --footer-dark: #1A1A1A;
        --footer-darker: #111111;
        --footer-light: #F8F5F0;
        --footer-text: #CCCCCC;
        --footer-text-light: #999999;
    }

    /* الفوتر الرئيسي */
    .footer-luxury {
        background: linear-gradient(135deg, var(--footer-dark), var(--footer-darker));
        color: var(--footer-text);
        padding: 5rem 0 2rem;
        position: relative;
        overflow: hidden;
        border-top: 1px solid rgba(212, 175, 55, 0.2);
    }

    .footer-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg,
                transparent,
                var(--footer-gold),
                transparent);
    }

    .footer-luxury::after {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle,
                rgba(212, 175, 55, 0.1) 0%,
                transparent 70%);
        border-radius: 50%;
    }

    /* تحسين الـ Container */
    .container-custom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .container-custom {
            padding: 0 1rem;
        }
    }

    /* اللوجو */
    .footer-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        margin-bottom: 1.5rem;
    }

    .footer-logo-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--footer-gold), #E6B325);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--footer-dark);
        font-size: 1.2rem;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .footer-logo-text {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        font-weight: 700;
        background: linear-gradient(90deg, var(--footer-gold), var(--footer-gold-light));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* نص الشركة */
    .company-description {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--footer-text-light);
        margin-bottom: 2rem;
        padding-right: 2rem;
    }

    /* روابط التواصل الاجتماعي */
    .social-icons-luxury {
        display: flex;
        gap: 12px;
        margin-top: 2rem;
    }

    .social-icon-luxury {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--footer-text);
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .social-icon-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--footer-gold), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .social-icon-luxury:hover {
        transform: translateY(-3px);
        border-color: var(--footer-gold);
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.2);
        color: white;
    }

    .social-icon-luxury:hover::before {
        opacity: 0.2;
    }

    .social-icon-luxury i {
        position: relative;
        z-index: 1;
        transition: transform 0.3s ease;
    }

    .social-icon-luxury:hover i {
        transform: scale(1.1);
    }

    /* العناوين */
    .footer-title-luxury {
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        position: relative;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-title-luxury::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 2px;
        background: linear-gradient(90deg, var(--footer-gold), transparent);
    }

    /* القوائم */
    .footer-links-luxury {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links-luxury li {
        margin-bottom: 0.8rem;
    }

    .footer-links-luxury a {
        color: var(--footer-text-light);
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .footer-links-luxury a:hover {
        color: var(--footer-gold);
        transform: translateX(5px);
    }

    .footer-links-luxury a i {
        font-size: 0.8rem;
        color: var(--footer-gold);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .footer-links-luxury a:hover i {
        opacity: 1;
    }

    /* معلومات الاتصال */
    .contact-info li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 1rem;
        color: var(--footer-text-light);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    .contact-info i {
        color: var(--footer-gold);
        font-size: 1rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* القسم السفلي */
    .footer-bottom-luxury {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        position: relative;
    }

    .footer-bottom-luxury::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 2px;
        background: linear-gradient(90deg,
                transparent,
                var(--footer-gold),
                transparent);
    }

    .footer-bottom-luxury p {
        color: var(--footer-text-light);
        font-size: 0.9rem;
        margin: 0;
    }

    /* تأثيرات التحميل */
    .footer-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* تأخيرات للعناصر */
    .footer-section:nth-child(1) {
        animation-delay: 0.1s;
    }

    .footer-section:nth-child(2) {
        animation-delay: 0.2s;
    }

    .footer-section:nth-child(3) {
        animation-delay: 0.3s;
    }

    .footer-section:nth-child(4) {
        animation-delay: 0.4s;
    }

    .footer-section:nth-child(5) {
        animation-delay: 0.5s;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .footer-luxury {
            padding: 4rem 0 2rem;
        }

        .row {
            gap: 2rem 0;
        }

        .col-lg-4 {
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 768px) {
        .footer-luxury {
            padding: 3rem 0 1.5rem;
        }

        .footer-title-luxury {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .company-description {
            padding-right: 0;
        }

        .social-icons-luxury {
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .footer-luxury {
            text-align: center;
        }

        .footer-brand {
            justify-content: center;
        }

        .footer-title-luxury::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .footer-links-luxury a {
            justify-content: center;
        }

        .contact-info li {
            justify-content: center;
            text-align: center;
        }
    }
</style>

<footer class="footer-luxury">
    <div class="container-custom">
        <div class="row g-5">
            <!-- معلومات الشركة -->
            <div class="col-lg-4 footer-section">
                <a class="footer-brand" href="{{ route('home') }}">
                    <div class="footer-logo-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <span class="footer-logo-text">WeddingHalls</span>
                </a>

                <p class="company-description">
                    Discover Jordan's most exquisite wedding venues. From luxurious halls to enchanting outdoor spaces,
                    we connect you with the perfect setting for your once-in-a-lifetime celebration.
                </p>

                <div class="social-icons-luxury">
                    <a href="#" class="social-icon-luxury" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-icon-luxury" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon-luxury" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon-luxury" aria-label="Pinterest">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>

            <!-- روابط سريعة -->
            <div class="col-lg-2 col-md-4 footer-section">
                <h5 class="footer-title-luxury">Quick Links</h5>
                <ul class="footer-links-luxury">
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fas fa-chevron-right"></i>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('explore') }}">
                            <i class="fas fa-chevron-right"></i>
                            Explore Venues
                        </a>
                    </li>
                    @auth
                        <li>
                            <a class="nav-link nav-link-luxury {{ request()->routeIs('user.bookings') ? 'active' : '' }}"
                                href="{{ route('user.bookings') }}"></a>
                        </li>
                        <li>
                            <a href="{{ route('favorites') }}">
                                <i class="fas fa-chevron-right"></i>
                                Favorites
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- موارد -->
            <div class="col-lg-2 col-md-4 footer-section">
                <h5 class="footer-title-luxury">Resources</h5>
                <ul class="footer-links-luxury">
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Wedding Blog
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            FAQ
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Planning Guide
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Vendor Directory
                        </a>
                    </li>
                </ul>
            </div>

            <!-- معلومات قانونية -->
            <div class="col-lg-2 col-md-4 footer-section">
                <h5 class="footer-title-luxury">Legal</h5>
                <ul class="footer-links-luxury">
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Cookie Policy
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-chevron-right"></i>
                            Refund Policy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- معلومات الاتصال -->
            <div class="col-lg-2 footer-section">
                <h5 class="footer-title-luxury">Contact Us</h5>
                <ul class="footer-links-luxury contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Amman, Jordan</span>
                    </li>
                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+962 7 1234 5678</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@weddinghalls.com</span>
                    </li>
                    <li>
                        <i class="fas fa-clock"></i>
                        <span>Mon - Sun: 9AM - 9PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- القسم السفلي -->
        <div class="footer-bottom-luxury">
            <p class="mb-0">
                &copy; {{ date('Y') }} WeddingHalls. All rights reserved.
                <span class="d-block d-sm-inline mt-2 mt-sm-0 ms-sm-2">
                    Made with <i class="fas fa-heart text-danger mx-1"></i> for unforgettable celebrations
                </span>
            </p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تأثيرات التمرير للفوتر
        const footerSections = document.querySelectorAll('.footer-section');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, {
            threshold: 0.1
        });

        footerSections.forEach(section => {
            observer.observe(section);
            section.style.animationPlayState = 'paused';
        });

        // تأثير hover للروابط
        const footerLinks = document.querySelectorAll('.footer-links-luxury a');
        footerLinks.forEach(link => {
            link.addEventListener('mouseenter', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'translateX(3px)';
                }
            });

            link.addEventListener('mouseleave', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'translateX(0)';
                }
            });
        });


    });
</script>
