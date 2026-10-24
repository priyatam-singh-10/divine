<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI & Wealth Creation Webinar | Future Growth Blueprint</title>
    <meta name="description" content="Discover how AI can help you grow, earn smarter, build wealth, and create new opportunities. Live 2 day webinar with AI prompts, bonuses, and practical strategies. Join Now!">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.png') }}">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        /* ==================== CSS VARIABLES ==================== */
        :root {
            --brown-primary: #5C3E2F;
            --brown-secondary: #8B6F47;
            --brown-dark: #2C2416;
            --brown-darker: #3D2A1F;
            --gold: #D4AF37;
            --gold-light: #E5C76B;
            --cream: #FFF8E7;
            --cream-dark: #F5E6D3;
            --cream-light: #FDF8F1;
            --coral: #F84C74;
            --white: #FFFFFF;
            --font-sans: 'Inter', system-ui, sans-serif;
            --font-serif: 'Playfair Display', Georgia, serif;
            
        }

        /* ==================== BASE STYLES ==================== */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-sans);
            background: var(--cream);
            color: var(--brown-dark);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .font-serif {
            font-family: var(--font-serif);
        }

        /* ==================== UTILITY CLASSES ==================== */
        .bg-cream {
            background-color: var(--cream) !important;
        }

        .bg-cream-dark {
            background-color: var(--cream-dark) !important;
        }

        .bg-cream-light {
            background-color: var(--cream-light) !important;
        }

        .bg-brown-primary {
            background-color: var(--brown-primary) !important;
        }

        .bg-brown-dark {
            background-color: var(--brown-dark) !important;
        }

        .bg-gold {
            background-color: var(--gold) !important;
        }

        .bg-gold-light {
            background-color: var(--gold-light) !important;
        }

        .text-brown-primary {
            color: var(--brown-primary) !important;
        }

        .text-brown-secondary {
            color: var(--brown-secondary) !important;
        }

        .text-brown-dark {
            color: var(--brown-dark) !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .text-gold-light {
            color: var(--gold-light) !important;
        }

        .text-cream {
            color: var(--cream) !important;
        }

        .text-coral {
            color: var(--coral) !important;
        }

        .text-dark {
            color: #030606 !important;
        }

        .border-gold {
            border-color: var(--gold) !important;
        }

        .border-cream {
            border-color: var(--cream) !important;
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--gold) 0%, var(--brown-secondary) 50%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-brown-gradient {
            background: linear-gradient(135deg, #5C3E2F 0%, #3d2a1f 100%);
        }

        .bg-gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #5C3E2F 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-dark {
            background: rgba(44, 36, 22, 0.95) !important;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
        }

        .glow-bg {
            inset: -3px;
            background: linear-gradient(135deg, #D4AF37, #5C3E2F);
            opacity: 0.3;
            filter: blur(4px);
            z-index: 0;
        }

        .fs-48 {
            font-size: 48px;
        }

        .z-20 {
            z-index: 20;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* ==================== BUTTONS ==================== */
        .btn-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--brown-secondary) 100%);
            color: var(--brown-dark);
            font-weight: 700;
            border: none;
            border-radius: 50rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            text-decoration: none;
        }

        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.5);
            color: var(--brown-dark);
        }

        .btn-outline-premium {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            background: transparent;
            color: var(--brown-primary);
            font-weight: 600;
            border: 2px solid var(--brown-primary);
            border-radius: 50rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-outline-premium:hover {
            background: var(--brown-primary);
            color: var(--white);
        }

        .btn-gold {
            background: linear-gradient(135deg,
                    #F7D774 0%,
                    #E5C76B 20%,
                    #D4AF37 50%,
                    #C89B2A 80%,
                    #B8860B 100%);
            color: #2C2416;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            padding: 14px 32px;
            box-shadow:
                0 8px 25px rgba(212, 175, 55, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.4);
            transition: all .3s ease;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow:
                0 12px 35px rgba(212, 175, 55, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes float-delay {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(12px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes border-glow {

            0%,
            100% {
                border-color: rgba(212, 175, 55, 0.3);
            }

            50% {
                border-color: rgba(212, 175, 55, 0.8);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float-delay 5s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 4s ease infinite;
        }

        .animate-border-glow {
            animation: border-glow 3s ease-in-out infinite;
        }

        /* ==================== NAVBAR ==================== */
        .navbar-custom {
            padding: 0.75rem 0;
            transition: all 0.3s ease;
        }

        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(16px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid rgba(212, 175, 55, 0.5);
        }

        .navbar-brand-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand-icon i {
            font-size: 1.25rem;
            color: var(--gold);
        }

        .navbar-custom .nav-link {
            color: var(--brown-primary) !important;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-custom .nav-link:hover {
            color: var(--gold) !important;
        }

        .navbar-custom .nav-link:hover::after {
            width: 80%;
        }

        /* ==================== HERO SECTION ==================== */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 5rem;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            /* background: linear-gradient(135deg, var(--cream) 0%, var(--cream-dark) 50%, var(--cream) 100%); */
            background-color: var(--cream-light);
            z-index: 0;
        }

        .hero-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 1;
        }

        .hero-shape-1 {
            top: 5rem;
            left: 10%;
            width: 20rem;
            height: 20rem;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.25), transparent);
            animation: float 8s ease-in-out infinite;
        }

        .hero-shape-2 {
            bottom: 5rem;
            right: 10%;
            width: 26rem;
            height: 26rem;
            background: linear-gradient(135deg, rgba(139, 111, 71, 0.2), transparent);
            animation: float-delay 10s ease-in-out infinite;
        }

        .hero-shape-3 {
            top: 50%;
            left: 25%;
            width: 18rem;
            height: 18rem;
            background: linear-gradient(135deg, rgba(92, 62, 47, 0.15), transparent);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.2), rgba(139, 111, 71, 0.1));
            border: 1px solid rgba(212, 175, 55, 0.4);
            border-radius: 50rem;
        }

        .hero-badge-dot {
            width: 0.5rem;
            height: 0.5rem;
            background: var(--gold);
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite;
            display: inline-block;
        }

        .hero-title,
        .hero-title-2 {
            font-size: clamp(2.5rem, 5vw, 2.8rem);
            font-weight: 700;
            line-height: 1.1;
        }

        .hero-tag {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            background: rgba(92, 62, 47, 0.1);
            border: 1px solid rgba(92, 62, 47, 0.25);
            border-radius: 50rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--brown-primary);
        }

        .hero-stat-card {
            text-align: center;
            padding: 1.25rem;
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .hero-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }


        .video-card {
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(212, 175, 55, .15);
        }

        .video-card iframe {
            border-radius: 16px;
        }

        .video-card:hover {
            transform: translateY(-6px);
            transition: .4s ease;
        }

        /* ==================== ENROLL FORM ==================== */
        .enroll-form-wrapper {
            position: relative;
        }

        .enroll-form-glow {
            position: absolute;
            inset: -6px;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.4), rgba(139, 111, 71, 0.3), rgba(212, 175, 55, 0.4));
            border-radius: 1.5rem;
            filter: blur(25px);
            animation: pulse-glow 3s ease-in-out infinite;
        }

        .enroll-form-card {
            position: relative;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 2px solid rgba(212, 175, 55, 0.6);
            border-radius: 1.5rem;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
        }

        .enroll-form-icon {
            width: 4.5rem;
            height: 4.5rem;
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(92, 62, 47, 0.3);
        }

        .enroll-form-icon i {
            font-size: 2rem;
            color: var(--gold);
        }

        .form-control-premium {
            padding: 0.875rem 1rem;
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.5);
            border-radius: 0.75rem;
            font-size: 1rem;
            color: var(--brown-dark);
            transition: all 0.3s ease;
        }

        .form-control-premium::placeholder {
            color: rgba(139, 111, 71, 0.5);
        }

        .form-control-premium:focus {
            border-color: var(--brown-primary);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
        }

        .enroll-form-decor {
            position: absolute;
            border-radius: 50%;
        }

        .enroll-form-decor-1 {
            top: -12px;
            right: -12px;
            width: 1.75rem;
            height: 1.75rem;
            background: linear-gradient(135deg, var(--gold), var(--brown-secondary));
            animation: float 4s ease-in-out infinite;
        }

        .enroll-form-decor-2 {
            bottom: -10px;
            left: -10px;
            width: 1.25rem;
            height: 1.25rem;
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
            animation: float-delay 5s ease-in-out infinite;
        }

        .trust-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            backdrop-filter: blur(16px);
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .trust-item i {
            color: var(--gold);
        }

        /* FORM CONTROL PREMIUM */
        .form-control-premium {
            border: 2px solid var(--gold) !important;
            padding: 0.8rem 1rem !important;
            font-size: 0.95rem !important;
            border-radius: 10px !important;
            background: white !important;
            color: var(--text-dark) !important;
            transition: all 0.3s ease !important;
            font-family: inherit !important;
            box-shadow: none !important;
        }

        .form-control-premium::placeholder {
            color: rgba(44, 36, 22, 0.5) !important;
        }

        .form-control-premium:focus {
            border-color: var(--brown-dark) !important;
            background: rgba(212, 175, 55, 0.05) !important;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2) !important;
            outline: none !important;
        }

        .form-control-premium.is-valid {
            border-color: #10b981 !important;
            background: rgba(16, 185, 129, 0.05) !important;
        }

        .form-control-premium.is-invalid {
            border-color: #ef4444 !important;
            background: rgba(239, 68, 68, 0.05) !important;
        }

        /* ERROR MESSAGE */
        .error-message {
            display: none !important;
            color: #ef4444 !important;
            font-weight: 500 !important;
        }

        .error-message.show {
            display: block !important;
        }

        /* FORM MESSAGE */
        .form-message {
            display: none;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            animation: slideDown 0.3s ease;
            margin-top: 1rem;
        }

        .form-message.success {
            background: rgba(16, 185, 129, 0.15) !important;
            color: #059669 !important;
            border: 1px solid #10b981 !important;
            display: block !important;
        }

        .form-message.error {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #dc2626 !important;
            border: 1px solid #ef4444 !important;
            display: block !important;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* BTN PREMIUM */
        .btn-premiums {
            background: linear-gradient(135deg, var(--gold) 0%, var(--brown-secondary) 100%) !important;
            color: white !important;
            border: none !important;
            border-radius: 50rem !important;
            font-weight: 700 !important;
            font-size: 1.05rem !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 10px 30px rgba(92, 62, 47, 0.25) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 0.8rem !important;
            text-decoration: none !important;
        }

        .btn-premiums:hover:not(:disabled) {
            transform: translateY(-3px) !important;
            box-shadow: 0 15px 45px rgba(212, 175, 55, 0.35) !important;
            color: white !important;
        }

        .btn-premiums:active:not(:disabled) {
            transform: translateY(-1px) !important;
        }

        .btn-premiums:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }

        .btn-premiums i {
            font-size: 1.2rem !important;
        }

        /********* counter section ********/

        .countdown-bar {
            background: linear-gradient(90deg, #2c1b10 0%, #4b2f1d 25%, #0c0601 50%, #4b2f1d 75%, #2c1b10 100%);
            padding: 18px 0;
            position: relative;
            overflow: hidden;
        }

        .countdown-bar::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at center,
                    rgba(212, 175, 55, .25),
                    transparent 70%);
        }

        .countdown-wrapper {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
        }

        .countdown-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 18px;
            text-transform: uppercase;
        }

        .countdown-label i {
            color: #D4AF37;
            font-size: 20px;
        }

        .countdown-timer {
            text-align: center;
            min-width: 70px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .time-box {
            text-align: center;
            min-width: 70px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .time-box span {
            display: block;
            color: #f8dede;
            font-size: 42px;
            line-height: 1;
            font-weight: 800;
            text-shadow:
                0 0 10px rgba(255, 77, 77, .5),
                0 0 20px rgba(255, 77, 77, .3);
        }

        .time-box small {
            color: #fff;
            font-size: 14px;
            letter-spacing: 2px;
            font-weight: 700;
        }

        .separator {
            color: #D4AF37;
            font-size: 32px;
            font-weight: 700;
            margin-top: -12px;
        }

        @media (max-width: 768px) {
            .countdown-wrapper {
                gap: 15px;
            }

            .time-box {
                min-width: 55px;
                display: grid;
                gap: 2px;
            }   
            

            .time-box span {
                font-size: 28px;
            }

            .separator {
                font-size: 22px;
            }

            .countdown-label {
                font-size: 12px;
            }
        }


        /*******************  timer  **************************/
        .time-running-section {
            background:
                linear-gradient(180deg,
                    #FFF8E7 0%,
                    #F5E6D3 100%);
            position: relative;
            overflow: hidden;
        }

        .time-running-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(212, 175, 55, .08);
            border-radius: 50%;
            top: -250px;
            right: -200px;
            filter: blur(40px);
        }

        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(212, 175, 55, .15);
            border: 1px solid rgba(212, 175, 55, .3);
            color: var(--brown-dark);
            padding: 12px 24px;
            border-radius: 50px;
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .time-badge i {
            color: #E53935;
        }

        .time-heading {
            font-size: clamp(2rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.2;
            color: var(--brown-dark);
        }

        .time-subtitle {
            max-width: 700px;
            margin: auto;
            font-size: 1.1rem;
            color: var(--brown-secondary);
        }

        .time-stat-card {
            background: white;
            padding: 2rem;
            text-align: center;
            border-radius: 24px;
            height: 100%;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, .06);
            border: 1px solid rgba(212, 175, 55, .2);
            transition: .4s;
        }

        .time-stat-card:hover {
            transform: translateY(-10px);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            margin: auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(135deg,
                    #D4AF37,
                    #B8860B);
            color: white;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .time-stat-card h3 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--brown-dark);
            margin-bottom: 10px;
        }

        .time-stat-card p {
            color: var(--brown-secondary);
            margin: 0;
        }

        .warning-box {
            background:
                linear-gradient(135deg,
                    #5C3E2F,
                    #2C2416);
            border-radius: 32px;
            padding: 4rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .warning-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at center,
                    rgba(212, 175, 55, .15),
                    transparent 70%);
        }

        .warning-box h3 {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            position: relative;
        }

        .warning-box p {
            max-width: 700px;
            margin: 20px auto;
            color: rgba(255, 255, 255, .85);
            position: relative;
        }

        @media(max-width:768px) {

            .time-heading {
                font-size: 2rem;
            }

            .warning-box {
                padding: 2.5rem 1.5rem;
            }

            .warning-box h3 {
                font-size: 1.5rem;
            }
        }

        /* ==================== PROBLEM SECTION ==================== */
        .problem-section {
            position: relative;
            padding: 4rem 0;
            background: linear-gradient(135deg, rgba(245, 230, 211, 0.7), rgba(255, 248, 231, 0.5), rgba(245, 230, 211, 0.7));
        }

        .section-border {
            position: absolute;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .section-border-top {
            top: 0;
        }

        .section-border-bottom {
            bottom: 0;
        }

        .section-tag {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.2), rgba(139, 111, 71, 0.1));
            border-radius: 50rem;
            color: var(--brown-primary);
            font-size: 0.875rem;
            font-weight: 600;
        }

        .tag2 {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.8), rgba(139, 111, 71, 0.8));
            color: #fff;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2rem);
            font-weight: 700;
            color: var(--brown-dark);
        }

        .problem-card {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 1rem;
            padding: 1.25rem;
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 1rem;
            transition: all 0.3s ease;
        }

        .problem-card:hover {
            /* border-color: rgba(248, 76, 116, 0.5);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1); */
            border-color: var(--gold);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
            transform: translateY(-5px);
        }

        .problem-card-icon {
            flex-shrink: 0;
            width: 3.25rem;
            height: 3.25rem;
            /* background: linear-gradient(135deg, rgba(248, 76, 116, 0.15), rgba(248, 76, 116, 0.05)); */
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(139, 111, 71, 0.1));
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .problem-card:hover .problem-card-icon {
            /* background: linear-gradient(135deg, rgba(248, 76, 116, 0.25), rgba(248, 76, 116, 0.1)); */
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
        }

        .problem-card-icon i {
            font-size: 1.5rem;
            /* color: var(--coral); */
            color: var(--gold);
        }

        .problem-statement {
            position: relative;
            padding: 2.5rem;
            background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown-darker) 100%);
            border-radius: 1.5rem;
            border: 2px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.2);
        }

        .problem-statement::before {
            content: '';
            position: absolute;
            inset: -3px;
            background: linear-gradient(135deg, var(--gold), transparent, var(--gold));
            border-radius: 1.5rem;
            z-index: -1;
            opacity: 0.3;
        }

        /* ==================== TRANSFORMATION SECTION ==================== */
        .transformation-section {
            padding: 4rem 0;
            /* background: var(--cream); */
            background: linear-gradient(135deg, #f5f1e8 0%, #fdfaf5 100%);
        }

        .transform-card {
            position: relative;
            padding: 2rem;
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 1.5rem;
            height: 100%;
            transition: all 0.4s ease;
            overflow: hidden;
        }

        .transform-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--brown-secondary));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .transform-card:hover {
            border-color: var(--gold);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            transform: translateY(-8px);
        }

        .transform-card:hover::before {
            transform: scaleX(1);
        }

        .transform-card-number {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 3rem;
            font-weight: 900;
            color: rgba(212, 175, 55, 0.15);
            line-height: 1;
        }

        .transform-card-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(139, 111, 71, 0.1));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .transform-card:hover .transform-card-icon {
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
        }

        .transform-card-icon i {
            font-size: 1.75rem;
            color: var(--brown-primary);
            transition: all 0.3s ease;
        }

        .transform-card:hover .transform-card-icon i {
            color: var(--gold);
        }


        /* ==================== BONUS SECTION ==================== */
        .bonus-section {
            padding: 4rem 0;
            /* background: linear-gradient(135deg, var(--cream-dark), var(--cream), var(--cream-dark)); */
            background: var(--cream-dark);
        }

        .bonus-card {
            position: relative;
            padding: 2rem;
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.4);
            border-radius: 1.5rem;
            height: 100%;
            transition: all 0.4s ease;
            overflow: hidden;
        }

        .bonus-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .bonus-card:hover {
            border-color: var(--gold);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
            transform: translateY(-8px);
        }

        .bonus-card:hover::before {
            opacity: 1;
        }

        .bonus-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.375rem 0.875rem;
            background: linear-gradient(135deg, var(--gold), var(--brown-secondary));
            border-radius: 50rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--brown-dark);
        }

        .bonus-icon {
            width: 4.5rem;
            height: 4.5rem;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(139, 111, 71, 0.1));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .bonus-card:hover .bonus-icon {
            background: linear-gradient(135deg, var(--brown-primary), var(--brown-secondary));
        }

        .bonus-icon i {
            font-size: 2rem;
            color: var(--gold);
            transition: all 0.3s ease;
        }

        .bonus-card:hover .bonus-icon i {
            transform: scale(1.1);
        }


        /* ==================== TESTIMONIALS SECTION ==================== */
        .testimonials-section {
            padding: 4rem 0;
            background: var(--cream);
            overflow: hidden;
        }

        .testimonial-card {
            padding: 2rem;
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 1.5rem;
            height: 360px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card p {
            height: 170px;
            overflow-y: auto;
            line-height: 1.7;
            padding-right: 6px;
        }

        .testimonial-card:hover {
            border-color: var(--gold);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .testimonial-stars {
            color: var(--gold);
            font-size: 1.125rem;
        }

        .testimonial-avatar {
            width: 4rem;
            height: 4rem;
        }

        .testimonial-avatar img {
            min-width: 100%;
            height: 100%;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 3rem !important;
            height: 3rem !important;
            background: var(--white) !important;
            border: 2px solid rgba(212, 175, 55, 0.4) !important;
            border-radius: 50% !important;
            transition: all 0.3s ease !important;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--brown-primary) !important;
            border-color: var(--brown-primary) !important;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 1rem !important;
            font-weight: 700 !important;
            color: var(--brown-primary) !important;
        }

        .swiper-button-next:hover::after,
        .swiper-button-prev:hover::after {
            color: var(--gold) !important;
        }

        .swiper-pagination-bullet {
            width: 0.75rem !important;
            height: 0.75rem !important;
            background: var(--brown-secondary) !important;
            opacity: 0.4 !important;
        }

        .swiper-pagination-bullet-active {
            background: var(--gold) !important;
            opacity: 1 !important;
        }

        .testimonial-card p::-webkit-scrollbar {
            width: 4px;
        }

        .testimonial-card p::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .testimonial-card p::-webkit-scrollbar-thumb {
            background: #c5a253;
            border-radius: 10px;
        }

        /* ==================== FAQ SECTION ==================== */
        .faq-section {
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--cream-dark), var(--cream));
        }

        .accordion-premium .accordion-item {
            background: var(--white);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 1rem !important;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .accordion-premium .accordion-item:hover {
            border-color: var(--gold);
        }

        .accordion-premium .accordion-button {
            padding: 1.25rem 1.5rem;
            background: transparent;
            font-weight: 600;
            color: var(--brown-dark);
            box-shadow: none;
        }

        .accordion-premium .accordion-button:not(.collapsed) {
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1), rgba(139, 111, 71, 0.05));
            color: var(--brown-primary);
        }

        .accordion-premium .accordion-button::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%235C3E2F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            width: 1.5rem;
            height: 1.5rem;
        }

        .accordion-premium .accordion-body {
            padding: 0 1.5rem 1.5rem;
            color: var(--brown-secondary);
            line-height: 1.7;
        }


        /* ==================== CTA2 SECTION ==================== */
        .future-stat-card {
            background: rgba(255, 255, 255, .8);
            border: 1px solid rgba(212, 175, 55, .25);
            border-radius: 20px;
            padding: 2rem;
            transition: .4s ease;
            height: 100%;
        }

        .future-stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(92, 62, 47, .12);
        }

        .counter {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: .75rem;
        }

        .future-warning-card {
            max-width: 850px;
            padding: 3rem;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg,
                    var(--brown-primary),
                    var(--brown-darker));
        }

        .pulse-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            /* background:var(--gold); */
            color: var(--brown-dark);
            font-size: 28px;
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 0 0 rgba(212, 175, 55, .5);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(212, 175, 55, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
            }
        }

        /* ==================== FINAL CTA SECTION ==================== */
        .final-cta-section {
            position: relative;
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--brown-dark) 0%, var(--brown-darker) 100%);
            overflow: hidden;
        }

        .final-cta-glow {
            position: absolute;
            width: 40rem;
            height: 40rem;
            border-radius: 50%;
            filter: blur(120px);
        }

        .final-cta-glow-1 {
            top: -10rem;
            left: -10rem;
            background: rgba(212, 175, 55, 0.15);
        }

        .final-cta-glow-2 {
            bottom: -10rem;
            right: -10rem;
            background: rgba(139, 111, 71, 0.15);
        }

        .final-cta-card {
            position: relative;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            border: 2px solid rgba(212, 175, 55, 0.4);
            border-radius: 2rem;
            animation: border-glow 3s ease-in-out infinite;
        }

        .final-cta-icon {
            width: 5rem;
            height: 5rem;
            /* background: linear-gradient(135deg, var(--gold), var(--brown-secondary)); */
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 50px rgba(212, 175, 55, 0.3);
        }

        .final-cta-icon i {
            font-size: 2.5rem;
            color: var(--brown-dark);
        }


        /* Sticky WhatsApp Button Styles */
        .whatsapp-sticky {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            animation: slideInRight 0.5s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 14px 20px;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse-whatsapp 2s ease-in-out infinite;
        }

        .whatsapp-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(37, 211, 102, 0.6);
            color: white;
            text-decoration: none;
        }

        .whatsapp-btn i {
            animation: pulse-glow 1s ease-in-out infinite;
        }

        @keyframes pulse-whatsapp {

            0%,
            100% {
                box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
            }

            50% {
                box-shadow: 0 8px 40px rgba(37, 211, 102, 0.7);
            }
        }

        .whatsapp-text-large {
            display: block;
        }

        .whatsapp-text-small {
            display: none;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .whatsapp-sticky {
                bottom: 20px;
                right: 20px;
            }

            .whatsapp-btn {
                padding: 12px 16px;
                font-size: 0.9rem;
            }

            .whatsapp-text-large {
                display: none;
            }

            .whatsapp-text-small {
                display: block;
            }
        }



        /* Social proof cards */
        .social-proof-section .card:hover {
            transform: scale(1.02);
        }


        .timerout{
            background: linear-gradient(135deg, #fffdf8, #f7efe0);
        }

        /* Founder section improvements */
        .founder-section {
            /* background: linear-gradient(135deg, #fffdf8, #f7efe0); */
            padding: 4rem 0;
        }

        .founder-image {
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 60px rgba(92, 62, 47, 0.2);
        }

        .founder-section .btn-premium {
            position: relative;
            overflow: hidden;
        }

        .founder-section .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.3s ease;
        }

        .founder-section .btn-premium:hover::before {
            left: 100%;
        }

        .founder-section ul li {
            font-size: 1.1rem;
            font-weight: 500;
            line-height: 1.8;
            letter-spacing: 0.2px;
            font-family: var(--font-sans);

        }

        .founder-section ul li i {
            font-size: 1.25rem;
            min-width: 28px;
        }

        /* Batch timing glow effect */
        .batch-timing-section .glass {
            border-color: var(--gold);
            animation: border-glow 3s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .founder-section h2,
            .social-proof-section h2,
            .batch-timing-section h2 {
                font-size: 2rem !important;
            }
        }

        /* ==================== FOOTER ==================== */
        .footer-section {
            padding: 1.5rem 0;
            background: var(--brown-dark);
            border-top: 2px solid rgba(212, 175, 55, 0.3);
        }


        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 767px) {
            .hero-title {
                font-size: 2.25rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .countdown-value {
                font-size: 1.75rem;
            }

            .trust-bar {
                padding: 0.75rem 1rem;
                gap: 0.75rem;
            }

            .final-cta-card {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="{{asset('assets/logo.png')}}" alt="divine touch" width="118px">
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-4 text-brown-primary"></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#masterclass">Masterclass</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bonuses">Bonuses</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn-premium cursor-pointer" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            Register Now
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ==================== HERO SECTION ==================== -->
    <section class="hero-section" id="home">
        <div class="hero-bg"></div>

        <!-- Background Shapes -->
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>

        <div class="container position-relative z-20">
            <div class="row align-items-center g-5 py-5">
                <!-- Left Content -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <div class="hero-badge mb-4">
                        <span class="hero-badge-dot"></span>
                        <span class="fw-medium text-brown-primary small">India's First AI Wealth Psychology
                            Experience</span>
                    </div>

                    <h1 class="hero-title mb-2 text-dark font-serif fst-italic">AI Era <span class="text-gold"> में पीछे नहीं... </span></h1>
                    <h2 class="hero-title-2 text-dark mb-3">Mentally Unstoppable बनिए</h2>

                    <p class="fs-5 text-brown-primary mb-3">2-Day Live Wealth Psychology Masterclass</p>

                    <div class="">
                        <h5 class="text-brown-secondary">Features:</h5>
                        <ul class="list-unstyled my-3">
                            <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                                <i class="bi bi-check-circle-fill text-gold"></i>
                                Wealth Psychology Reset
                            </li>
                            <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                                <i class="bi bi-check-circle-fill text-gold"></i>
                                AI Wealth Blueprint
                            </li>
                            <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                                <i class="bi bi-check-circle-fill text-gold"></i>
                                Live Mind Reprogramming
                            </li>
                            <li class="fs-5 d-flex align-items-center gap-2 text-brown-dark small">
                                <i class="bi bi-check-circle-fill text-gold"></i>
                                Future Self Visualization
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="hero-tag"> <i class="bi bi-people-fill me-2"></i>Limited Seats</span>
                        <span class="hero-tag"> <i class="bi bi-camera-video-fill me-2"></i>Live Interactive</span>
                        <span class="hero-tag"> <i class="bi bi-gift-fill me-2"></i>Free Bonuses </span>
                    </div>

                    <button class="btn-premium mb-3" data-bs-toggle="modal" data-bs-target="#enrollModal">
                        <i class="bi bi-rocket-takeoff-fill"></i>
                        REGISTER NOW
                    </button>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="video-card glass-card rounded-4 p-3 shadow-lg position-relative">
                        <div class="badge bg-danger my-3">
                            <span class="hero-badge-dot bg-white mt-1"></span> LIVE PREVIEW
                        </div>
                        <div class="ratio ratio-16x9 rounded-4 overflow-hidden">
                           <iframe
                                src="https://www.youtube.com/embed/jkKHAXvPBAk" title="Webinar Preview"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div class="text-center mt-3">
                            <h5 class="fw-bold text-brown-dark mb-2">
                                Transformational Experience
                            </h5>
                            <p class="small text-brown-secondary mb-3">
                                Discover how AI, Mindset & Future Growth can transform your life.
                            </p>
                            <button class="btn-premium" data-bs-toggle="modal" data-bs-target="#enrollModal">
                                <i class="bi bi-rocket-takeoff-fill"></i>
                                Reserve Your Seat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== TIMER SECTION ==================== -->
    <section class="countdown-bar">
        <div class="container">
            <div class="countdown-wrapper">
                <div class="countdown-label">
                    <i class="bi bi-alarm"></i>
                    <span>REGISTRATION CLOSES IN</span>
                </div>

                <div class="countdown-timer">
                    <div class="time-box">
                        <span id="days">02</span>
                        <small>DAYS</small>
                    </div>

                    <div class="separator">:</div>

                    <div class="time-box">
                        <span id="hours">08</span>
                        <small>HOURS</small>
                    </div>

                    <div class="separator">:</div>

                    <div class="time-box">
                        <span id="minutes">21</span>
                        <small>MIN</small>
                    </div>

                    <div class="separator">:</div>

                    <div class="time-box">
                        <span id="seconds">11</span>
                        <small>SEC</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PROBLEM SECTION ==================== -->
    <section class="problem-section" id="masterclass">
        <div class="section-border section-border-top"></div>
        <div class="section-border section-border-bottom"></div>

        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title mb-3">यह Masterclass किन लोगों के लिए है?</h2>
            </div>

            <div class="row g-3 justify-content-center mb-5 mx-auto" style="max-width: 66rem;">
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-mortarboard-fill"></i> </div>
                        <span class="fw-medium">Students</span>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="150">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-briefcase-fill"></i> </div>
                        <span class="fw-medium">Job Seekers</span>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-person-workspace"></i> </div>
                        <span class="fw-medium">Employees</span>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="250">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <span class="fw-medium">Entrepreneurs</span>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-person-video3"></i></div>
                        <span class="fw-medium">Coaches</span>
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="350">
                    <div class="problem-card">
                        <div class="problem-card-icon"><i class="bi bi-award-fill"></i></div>
                        <span class="fw-medium">Professionals</span>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title mb-3">क्या आप इन समस्याओं का सामना कर रहे हैं?</h2>
            </div>

            <div class="row g-3 justify-content-center mb-5 mx-auto">
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="100">
                    <div class="problem-card">
                        <i class="bi bi-emoji-frown-fill text-gold fs-2"></i>
                        <small class="fw-medium">Confidence कम है</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="150">
                    <div class="problem-card">
                        <i class="bi bi-graph-down-arrow text-gold fs-2"></i>
                        <small class="fw-medium">Income नहीं बढ़ रही</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="200">
                    <div class="problem-card">
                        <i class="bi bi-signpost-2-fill text-gold fs-2"></i>
                        <small class="fw-medium">Future Unclear</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="250">
                    <div class="problem-card">
                        <i class="bi bi-cpu-fill text-gold fs-2"></i>
                        <small class="fw-medium">AI का डर है</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="300">
                    <div class="problem-card">
                        <i class="bi bi-lightbulb-fill text-gold fs-2"></i>
                        <small class="fw-medium">Overthinking</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="350">
                    <div class="problem-card">
                        <i class="bi bi-clock-fill text-gold fs-2"></i>
                        <small class="fw-medium">Procrastination</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="400">
                    <div class="problem-card">
                        <i class="bi bi-compass-fill text-gold fs-2"></i>
                        <small class="fw-medium">Direction नहीं है</small>
                    </div>
                </div>
                <div class="col-6 col-lg-auto" data-aos="fade-up" data-aos-delay="450">
                    <div class="problem-card">
                        <i class="bi bi-person-fill-exclamation text-gold fs-2"></i>
                        <small class="fw-medium">Self-Doubt</small>
                    </div>
                </div>
            </div>

            <div class="problem-statement mx-auto" style="max-width: 48rem;" data-aos="zoom-in" data-aos-delay="400">
                <p class="text-cream fs-3 text-center lh-lg mb-4">
                    आज की दुनिया में सिर्फ <span class="text-gold fw-semibold">hard work काफी नहीं है।</span>
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <span class="hero-tag bg-cream-dark">
                        <i class="bi bi-lightbulb-fill me-1"></i>
                        Mindset Improve
                    </span>

                    <span class="hero-tag bg-cream-dark">
                        <i class="bi bi-people-fill me-1"></i>
                        Youth Focused
                    </span>

                    <span class="hero-tag bg-cream-dark">
                        <i class="bi bi-graph-up-arrow me-1"></i>
                        खुद को Upgrade
                    </span>
                </div>
                <p class="text-gold fw-semibold fs-4 text-center lh-lg mb-0">
                    यही लोग future में आगे बढ़ेंगे।
                </p>
            </div>
        </div>
    </section>
    

    <!-- ==================== BONUS SECTION ==================== -->
    <section class="bonus-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <!-- <span class="section-tag mb-3 d-inline-block">Curriculum</span> -->
                <h2 class="section-title mb-3">2-Day <span class="text-gold">Webinar</span> में आप क्या सीखेंगे?</h2>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="webinar">
                        <img src="{{asset('assets/day-1.webp')}}" class="rounded-4"  alt="day-1" width="100%">
                    </div>
                </div>
                <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="webinar">
                        <img src="{{asset('assets/day-2.webp')}}" class="rounded-4" alt="day-2" width="100%">
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-12 text-center mb-4" data-aos="fade-up">
                    <h2 class="section-title">Live Exercises You Will Experience </h2>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-person-check-fill"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">Wealth Identity Assessment</h4>
                        <p class="text-brown-secondary mb-3">
                            अपनी wealth identity को समझें और financial growth में आने वाली बाधाओं को पहचानें।
                        </p>
                    </div>
                </div>                
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">Mind Reprogramming</h4>
                        <p class="text-brown-secondary mb-3">
                            पुराने limiting beliefs को बदलकर success-oriented mindset विकसित करें।
                        </p>
                    </div>
                </div>                
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">Future Self Visualization</h4>
                        <p class="text-brown-secondary mb-3">
                            अपने future self की स्पष्ट image बनाकर goals को reality में बदलें।
                        </p>
                    </div>
                </div>                
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">AI Opportunity Mapping</h4>
                        <p class="text-brown-secondary mb-3">
                            AI tools की मदद से नई opportunities और growth paths को discover करें।
                        </p>
                    </div>
                </div>                
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-calculator-fill"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">Future Income Calculator</h4>
                        <p class="text-brown-secondary mb-3">
                            अपनी future income potential का आकलन करें और financial roadmap तैयार करें।
                        </p>
                    </div>
                </div>                
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="350">
                    <div class="bonus-card">
                        <div class="bonus-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fs-4 fw-bold text-brown-dark mb-2">Wealth Frequency Activation</h4>
                        <p class="text-brown-secondary mb-3">
                            abundance, confidence और prosperity को attract करने वाली energy को activate करें।
                        </p>
                    </div>
                </div>       
            </div>
        </div>
    </section>

    <!-- BATCH DATE SECTION -->
    <section class="timerout py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-tag mb-3 d-inline-block"> Time is Running Out</span>

                <h2 class="fw-bold text-brown-dark display-5">
                    अगले 2 दिन आपकी <br> <span class="text-gold">पूरी Life बदल सकते हैं।</span>
                </h2>
            </div>

            <div class="row g-4 justify-content-center mb-5">
                <div class="col-md-4" data-aos="zoom-in">
                    <div class="future-stat-card text-center">
                        <h3 class="counter text-gold" data-target="10000+">0+</h3>
                        <p class="mb-0 text-brown-secondary">
                            Jobs AI की वजह से बदल रही हैं
                        </p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="future-stat-card text-center">
                        <h3 class="counter" data-target="85%">0%</h3>
                        <p class="mb-0 text-brown-secondary">
                            Youth future को लेकर uncertain है
                        </p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="future-stat-card text-center">
                        <h3 class="text-gold">NOW</h3>
                        <p class="mb-0 text-brown-secondary">
                            Best time to upgrade yourself
                        </p>
                    </div>
                </div>
            </div>

            <div class="future-warning-card mx-auto text-center" data-aos="fade-up">
                <div class="pulse-icon p-2">
                    <img src="{{asset('assets/divine-icon.png')}}" alt="icon" width="100%">
                </div>
                <h3 class="fw-bold text-cream mb-3">
                    जो लोग अभी सीखेंगे और खुद को upgrade करेंगे...
                </h3>
                <p class="text-cream opacity-75 mb-4">
                    वही future में आगे बढ़ेंगे।
                    बाकी लोग पीछे छूट सकते हैं।
                </p>
                <a class="btn-premium cursor-pointer" data-bs-toggle="modal" data-bs-target="#enrollModal">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                    अभी अपनी सीट Reserve करें
                </a>
            </div>
        </div>
    </section>

    <!-- ==================== FOUNDER SECTION ==================== -->
    <section class="founder-section bg-cream" id="about">
        <div class="container">
          <div class="row align-items-center g-5">
            <!-- Left Side: Founder Image -->
            <div class="col-lg-5 aos-init aos-animate" data-aos="fade-right" data-aos-duration="800">
              <div class="position-relative">
                <!-- Glowing border effect -->
                <div class="glow-bg position-absolute p-4 rounded-4"></div>
                
                <!-- Founder image container -->
                <img src="https://divinetouch.info/public/assets/frontend/default/image/founder.webp" alt="Founder" class="founder-image p-4 img-fluid rounded-4">
              </div>
            </div>
    
            <!-- Right Side: Story, Mission, Credibility -->
            <div class="col-lg-7 aos-init aos-animate" data-aos="fade-left" data-aos-duration="800">
              <div class="mb-4">
                <span class="text-gold fw-bold ">Meet Your Mentor</span>
                <h2 class="fs-48 fw-bold text-dark mt-3 lh-sm">Meet Dr. Mahaveer Gautam</h2>
                <h5 class="text-dark">AI Wealth Psychologist | Human Transformation Architect</h5>
              </div>
    
              <!-- session specially -->
              <div class="glass-card mb-4 p-4 rounded-4 border-start border-4 border-gold">
                <ul class="list-unstyled my-3">
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        Clinical & Spiritual Hypnotherapist
                    </li>
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        NLP Master Practitioner
                    </li>
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        Reiki Grand Master
                    </li>
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        Wealth Architect
                    </li>
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        Author of Multiple Books
                    </li>
                    <li class="fs-5 d-flex align-items-center gap-2 mb-2 text-brown-dark small">
                        <i class="bi bi-check-circle-fill text-gold"></i>
                        Founder of Mentally Unstoppable Movement
                    </li>
                </ul>         
              </div>
            </div>
          </div>
        </div>
    </section>

    <!-- ==================== Exclusive Bonuses SECTION ==================== -->
    <section class="transformation-section" id="bonuses">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-tag mb-3 d-inline-block">Exclusive Bonuses</span>
                <h2 class="section-title mb-3">Webinar Join करने पर <span class="text-gold">FREE मिलेगा</span></h2>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="50">
                    <div class="transform-card">
                      <span class="transform-card-number">01</span>
                      <div class="transform-card-icon">
                        <i class="bi bi-book-fill"></i>
                      </div>
                      <h3 class="fs-4 fw-bold text-brown-dark mb-2">FREE PDF BOOK</h3>
                      <p class="text-brown-secondary mb-0">शून्य से करोड़पति तक</p>
                    </div>
                  </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="transform-card">
                        <span class="transform-card-number">01</span>
                        <div class="transform-card-icon">
                            <i class="bi bi-book-fill"></i>
                        </div>
                        <h3 class="fs-4 fw-bold text-brown-dark mb-2">Wealth Psychology PDF</h3>
                        <p class="text-brown-secondary mb-0">
                            Wealth mindset और financial success के principles सीखें।
                        </p>
                    </div>
                </div>            
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
                    <div class="transform-card">
                        <span class="transform-card-number">02</span>
                        <div class="transform-card-icon">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                        <h3 class="fs-4 fw-bold text-brown-dark mb-2">AI Opportunity Guide</h3>
                        <p class="text-brown-secondary mb-0">
                            AI tools से career और income opportunities discover करें।
                        </p>
                    </div>
                </div>            
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="transform-card">
                        <span class="transform-card-number">03</span>
                        <div class="transform-card-icon">
                            <i class="bi bi-headphones"></i>
                        </div>
                        <h3 class="fs-4 fw-bold text-brown-dark mb-2">Wealth Frequency Audio</h3>
                        <p class="text-brown-secondary mb-0">
                            Daily listening के लिए guided wealth activation audio।
                        </p>
                    </div>
                </div>            
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
                    <div class="transform-card">
                        <span class="transform-card-number">04</span>
                        <div class="transform-card-icon">
                            <i class="bi bi-clipboard-check-fill"></i>
                        </div>
                        <h3 class="fs-4 fw-bold text-brown-dark mb-2">Success Identity Worksheet</h3>
                        <p class="text-brown-secondary mb-0">
                            Clear goals और action plan बनाने के लिए practical worksheet।
                        </p>
                    </div>
                </div>    
                <div class="col-md-6 col-lg-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <div class="transform-card">
                      <span class="transform-card-number">06</span>
                      <div class="transform-card-icon">
                        <i class="bi bi-mic-fill"></i>
                      </div>
                      <h3 class="fs-4 fw-bold text-brown-dark mb-2">Live Q&amp;A Session</h3>
                      <p class="text-brown-secondary mb-0">Get your questions answered live</p>
                    </div>
                  </div>        
            </div>
        </div>
    </section>

    <!-- ==================== TESTIMONIALS SECTION ==================== -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-tag mb-3 d-inline-block">Community Results</span>
                <h2 class="section-title mb-3">लोग <span class="text-gold">Improve </span>कर रहे हैं</h2>
            </div>

            <div class="swiper testimonials-swiper pb-5" data-aos="fade-up" data-aos-delay="200">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-brown-dark mb-4">"डाँ महावीर गोतम जी द्बारा लिखित पुस्तक धन के अनकहें रहस्य
                                आप को एक ऐसी यात्रा पर ले जाते हैं , जहां आप अपनी मानसिक ऊर्जा और कर्मों के प्रचुरता के
                                साथ जोड़कर अपने सपनों को
                                हकीकत में बदल सकते हैं । जीवन में बचत और निवेश कैसे करें समय और धन का उपयोग कहा और कैसे
                                करें , मुझे इस पुस्तक को पढ़ने के बाद बहुत कुछ ज्ञान सिखने को मिला है ।"</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar"><img src="{{ asset('assets/man2.png') }}" alt="testimonial"></div>
                                <div>
                                    <strong class="text-brown-dark d-block">गोरी शंकर रूद्राक्ष जोशी</strong>
                                    <small class="text-brown-secondary"> Achieved: Wealth Clarity + Smart
                                        Thinking</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-brown-dark mb-4">"Thank you for taking the time to do the one-on-one session
                                with me. I appreciate your insights on energy, mind, and vibrations - they were
                                informative and gave me a broader understanding of how manifestation works.
                                However, since the session was positioned as a hypnosis-based manifestation clearing, I
                                was expecting more direct subconscious work-like being guided into trance, receiving
                                affirmations or suggestions, and specifically addressing money blockages.
                                While the knowledge shared was valuable, I personally felt the session could have
                                included deeper subconscious reprogramming or energetic clearing. I usually don't feel
                                comfortable sharing video feedback, especially when it's shared publicly or with other
                                clients. I hope you understand. I'm happy to provide written feedback like this instead.
                                Thank you again for your time."</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar"><img src="{{ asset('assets/woman.png') }}" alt="testimonial"></div>
                                <div>
                                    <strong class="text-brown-dark d-block">Sanyogita</strong>
                                    <small class="text-brown-secondary">Achieved: Mindset Expansion + Energy
                                        Awareness</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-brown-dark mb-4">"Dr. Mahaveer Gautam explained everything clearly and helped
                                me overcome daily life challenges. I recommend his sessions for anyone looking to
                                improve their future or health. Thank you, sir!"</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar"><img src="{{ asset('assets/man.png') }}" alt="testimonial"></div>
                                <div>
                                    <strong class="text-brown-dark d-block">Pankaj Singh</strong>
                                    <small class="text-brown-secondary">Achieved: Life Clarity + Inner Strength</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-brown-dark mb-4">"Dr. Mahaveer Gautam's session was truly inspiring. His
                                clear, practical teaching made complex topics easy to understand and apply. Though
                                scheduled for one hour, the session extended to three engaging hours. I left feeling
                                confident and motivated. Highly recommended for anyone seeking personal growth."</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar"><img src="{{ asset('assets/man2.png') }}" alt="testimonial"></div>
                                <div>
                                    <strong class="text-brown-dark d-block">Lokendra Rana</strong>
                                    <small class="text-brown-secondary"> Achieved: Clarity + Growth Mindset</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="text-brown-dark mb-4">"I am Nazia from Mysore main Dr. Mahaveer Gautam ka dil se
                                shukriya ada karti hoon. Aapne mere liye apna qeemti waqt – 2.5 ghante tak diya, bina
                                jaldi kiye meri baat suni aur har masle ka root cause samjhaane mein meri madad ki.
                                Aapka shaant aur samvedansheel (sensitive) approach ne mujhe clarity aur healing ka
                                raasta diya. Divine touch foundation ka yeh initiative waqai un logon ke liye ek rehmat
                                hai jo emotional struggles face kar rahe hain. Ek baar mai dubara dil se aapka Thanks
                                karna chahti ki main last 42 years se regular struggle Kar rahi thi aur aisa lagata tha
                                ki life completely struck ho gai hai aise main aap mere life me ek Masiha ban kar aaye
                                aur aapane itani aasani se meri painful memories ko remove karvaya aur mujhe jeene ka
                                naya rasta dikhaya. Thanks Dr. Mahaveer Gautam thanks divine touch."</p>
                            <div class="d-flex align-items-center gap-3">
                                <div class="testimonial-avatar"><img src="{{ asset('assets/woman.png') }}" alt="testimonial"></div>
                                <div>
                                    <strong class="text-brown-dark d-block">Nazia</strong>
                                    <small class="text-brown-secondary">Achieved: Trauma Release + Inner Peace</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-4"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <!-- ==================== FAQ SECTION ==================== -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="section-tag mb-3 d-inline-block">FAQ</span>
                <h2 class="section-title mb-3">Frequently Asked <span class="gradient-text">Questions</span></h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-7">
                    <div class="accordion accordion-premium" style="max-width: 48rem; margin: 0 auto;" id="faqAccordion"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    क्या यह AI Course है?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    नहीं, यह एक mindset transformation program है जिसमें AI opportunities को भी समझाया जाएगा।
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq2">
                                    क्या Recording मिलेगी?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    हाँ, सभी sessions की recordings replay access के साथ उपलब्ध रहेंगी।
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq3">
                                    क्या Beginners Join कर सकते हैं?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    बिल्कुल, यह program beginners और experienced learners दोनों के लिए उपयुक्त है।
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faq4">
                                    क्या यह Motivation Seminar है?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    नहीं, यह केवल motivation नहीं बल्कि practical transformation, mindset rewiring और action-based learning program है।
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-5">
                    <div class="bg-brown-primary final-cta-card text-center" data-aos="zoom-in">        
                        <h2 class="hero-title fs-3 text-cream mb-4">
                            AI आपका Future नहीं बदलेगा... <span class="text-gold font-serif fst-italic">आपका Mind बदलेगा। </span>
                        </h2>
                        <h4 class="text-cream">और वही आपकी <span class="text-gold font-serif fst-italic">Income, Identity और Future</span> तय करेगा।</h4>
                
                        <a class="btn-premium btn-lg mb-5 cursor-pointer" data-bs-toggle="modal" data-bs-target="#enrollModal">
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            अभी अपनी Seat Reserve करें
                        </a>
        
                        <div class="d-flex flex-wrap justify-content-center gap-2 border border-cream rounded-4 py-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-people-fill text-gold"></i>
                                <span class="text-cream small">Limited Seats</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-mortarboard-fill text-gold"></i>
                                <span class="text-cream small">Youth Focused</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-lightbulb-fill text-gold"></i>
                                <span class="text-cream small">Practical Learning</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

   
    <!-- Sticky WhatsApp Button HTML -->
    <div class="whatsapp-sticky">
        <a href="https://wa.me/919214327023?text=Hi%20Divine%20Touch!%20I%20need%20help%20choosing%20the%20right%20batch%20for%20me.%20Can%20you%20guide%20me%3F"
            target="_blank" rel="noopener noreferrer" class="whatsapp-btn">
            <i class="bi bi-whatsapp"></i>
            <span class="whatsapp-text-large">Need Help? Chat Now</span>
            <span class="whatsapp-text-small">Chat</span>
        </a>
    </div>

    <!-- ==================== FOOTER ==================== -->
    <footer class="footer-section">
        <div class="container text-center">
            <p class="text-cream opacity-50 small mb-0">
                &copy; 2026 DivineTouch. All rights reserved.
            </p>
        </div>
    </footer>

    <div class="modal fade" id="enrollModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header border-0 d-grid">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                    <div class="enroll-form-icon mx-auto mb-3 p-2">
                        <img src="{{asset('assets/divine-icon.png')}}" alt="icon" width="100%">
                    </div>
                    <h5 class="fw-bold text-brown-primary text-center">
                        Reserve Your Webinar Seat
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="enrollForm" novalidate>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-brown-primary small">Full Name</label>
                            <input type="text" class="form-control form-control-premium" id="enrollName" name="fullName"
                                placeholder="Enter your full name" required>
                            <div class="error-message small text-danger mt-1" id="enrollNameError"></div>
                        </div>
  
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-brown-primary small">Phone Number</label>
                            <input type="text" class="form-control form-control-premium" id="enrollPhone" name="mobile"
                                placeholder="Enter your 10-digit phone number" maxlength="10" required>
                            <div class="error-message small text-danger mt-1" id="enrollPhoneError"></div>
                        </div>
                        <button type="submit" class="btn-premiums w-100 py-3" id="enrollSubmitBtn">
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            YES! RESERVE MY WEBINAR SEAT
                        </button>
                        <div class="form-message small mt-3" id="enrollFormMessage"></div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <div class="trust-bar">
                        <div class="trust-item">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <small class="text-brown-dark">
                                Last 24 Hours: 89 Registrations
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== SCRIPTS ==================== -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!--  form validation  -->
    <script>
        // Get form elements
        const enrollForm = document.getElementById('enrollForm');
        const enrollName = document.getElementById('enrollName');
        // const enrollEmail = document.getElementById('enrollEmail');
        const enrollPhone = document.getElementById('enrollPhone');
        const enrollSubmitBtn = document.getElementById('enrollSubmitBtn');
        const enrollFormMessage = document.getElementById('enrollFormMessage');
        const checkoutUrl = "{{ route('checkout2') }}";

        // Regex patterns
        const nameRegex = /^[A-Za-z\s.'-]{3,50}$/;
        //const emailRegex = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        const phoneRegex = /^[6-9][0-9]{9}$/;

        // ===== NAME VALIDATION =====
        enrollName.addEventListener('blur', validateName);
        enrollName.addEventListener('input', function () {
            // Remove numbers and special characters in real-time
            let value = this.value;
            let cleaned = value.replace(/[^A-Za-z\s.'-]/g, '');

            if (cleaned !== value) {
                this.value = cleaned;
            }
        });

        function validateName() {
            const value = enrollName.value.trim();
            const nameError = document.getElementById('enrollNameError');

            if (value === '') {
                nameError.textContent = 'Full Name is required';
                nameError.classList.add('show');
                enrollName.classList.add('is-invalid');
                enrollName.classList.remove('is-valid');
                return false;
            }

            if (value.length < 3) {
                nameError.textContent = 'Name must be at least 3 characters';
                nameError.classList.add('show');
                enrollName.classList.add('is-invalid');
                enrollName.classList.remove('is-valid');
                return false;
            }

            if (value.length > 50) {
                nameError.textContent = 'Name cannot exceed 50 characters';
                nameError.classList.add('show');
                enrollName.classList.add('is-invalid');
                enrollName.classList.remove('is-valid');
                return false;
            }

            if (!/^[A-Za-z\s.'-]+$/.test(value)) {
                nameError.textContent = 'Name can only contain letters, spaces, dots, hyphens and apostrophes';
                nameError.classList.add('show');
                enrollName.classList.add('is-invalid');
                enrollName.classList.remove('is-valid');
                return false;
            }

            nameError.textContent = '';
            nameError.classList.remove('show');
            enrollName.classList.remove('is-invalid');
            enrollName.classList.add('is-valid');
            validateFormState();
            return true;
        }

        // ===== EMAIL VALIDATION =====
        // enrollEmail.addEventListener('blur', validateEmail);

        // function validateEmail() {
        //     const value = enrollEmail.value.trim();
        //     const emailError = document.getElementById('enrollEmailError');

        //     if (value === '') {
        //         emailError.textContent = 'Email is required';
        //         emailError.classList.add('show');
        //         enrollEmail.classList.add('is-invalid');
        //         enrollEmail.classList.remove('is-valid');
        //         return false;
        //     }

        //     if (value.length > 100) {
        //         emailError.textContent = 'Email cannot exceed 100 characters';
        //         emailError.classList.add('show');
        //         enrollEmail.classList.add('is-invalid');
        //         enrollEmail.classList.remove('is-valid');
        //         return false;
        //     }

        //     if (!emailRegex.test(value)) {
        //         emailError.textContent = 'Please enter a valid email address';
        //         emailError.classList.add('show');
        //         enrollEmail.classList.add('is-invalid');
        //         enrollEmail.classList.remove('is-valid');
        //         return false;
        //     }

        //     emailError.textContent = '';
        //     emailError.classList.remove('show');
        //     enrollEmail.classList.remove('is-invalid');
        //     enrollEmail.classList.add('is-valid');
        //     validateFormState();
        //     return true;
        // }

        // ===== PHONE VALIDATION =====
        enrollPhone.addEventListener('blur', validatePhone);
        enrollPhone.addEventListener('input', function () {
            // Remove all non-digit characters
            let value = this.value;
            let cleaned = value.replace(/[^0-9]/g, '');
            this.value = cleaned;
        });

        function validatePhone() {
            const value = enrollPhone.value.trim();
            const phoneError = document.getElementById('enrollPhoneError');

            if (value === '') {
                phoneError.textContent = 'Phone Number is required';
                phoneError.classList.add('show');
                enrollPhone.classList.add('is-invalid');
                enrollPhone.classList.remove('is-valid');
                return false;
            }

            if (value.length < 10) {
                phoneError.textContent = 'Phone number must be exactly 10 digits';
                phoneError.classList.add('show');
                enrollPhone.classList.add('is-invalid');
                enrollPhone.classList.remove('is-valid');
                return false;
            }

            if (value.length > 10) {
                phoneError.textContent = 'Phone number cannot exceed 10 digits';
                phoneError.classList.add('show');
                enrollPhone.classList.add('is-invalid');
                enrollPhone.classList.remove('is-valid');
                return false;
            }

            if (!/^[6-9][0-9]{9}$/.test(value)) {
                phoneError.textContent = 'Phone number must start with 6, 7, 8, or 9';
                phoneError.classList.add('show');
                enrollPhone.classList.add('is-invalid');
                enrollPhone.classList.remove('is-valid');
                return false;
            }

            phoneError.textContent = '';
            phoneError.classList.remove('show');
            enrollPhone.classList.remove('is-invalid');
            enrollPhone.classList.add('is-valid');
            validateFormState();
            return true;
        }

        // ===== VALIDATE FORM STATE =====
        function validateFormState() {
            const name = enrollName.value.trim();
            //const email = enrollEmail.value.trim();
            const phone = enrollPhone.value.trim();

            const isNameValid = nameRegex.test(name);
            //const isEmailValid = emailRegex.test(email);
            const isPhoneValid = phoneRegex.test(phone);

            if (isNameValid && isPhoneValid) {
                enrollSubmitBtn.disabled = false;
            } else {
                enrollSubmitBtn.disabled = true;
            }
        }

        // ===== PREVENT PASTE OF INVALID DATA =====
        enrollName.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const cleaned = pasted.replace(/[^A-Za-z\s.'-]/g, '');
            enrollName.value = cleaned;
            validateName();
        });

        enrollPhone.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const cleaned = pasted.replace(/[^0-9]/g, '');
            enrollPhone.value = cleaned;
            validatePhone();
        });

        // ===== FORM SUBMISSION =====
         enrollForm.addEventListener('submit', function (e) {
            e.preventDefault();
        
            const isNameValid = validateName();
            const isPhoneValid = validatePhone();
        
            if (!isNameValid || !isPhoneValid) {
                enrollFormMessage.className = 'form-message error';
                enrollFormMessage.textContent = '❌ Please fix the errors above';
                return;
            }
        
            $.ajax({
                url: "{{ route('leads.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    fullName: $('#enrollName').val(),
                    mobile: $('#enrollPhone').val()
                },
                success: function (response) {

                    window.location.href = "{{ route('checkout2') }}";
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
        });


        // Initialize button state
        enrollSubmitBtn.disabled = true;
    </script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });

        // Navbar Scroll Effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const navbar = document.getElementById('mainNavbar');
        const toggler = document.querySelector('.navbar-toggler');

        toggler.addEventListener('click', function () {
            navbar.classList.toggle('scrolled');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });

                    // Close mobile menu
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse.classList.contains('show')) {
                        new bootstrap.Collapse(navbarCollapse).hide();
                    }
                }
            });
        });

        // Testimonials Swiper
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 5000000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            }
        });

    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        
            // Counter Animation
            function animateCounter(element, start, end, duration, suffix = '') {
                let startTime = null;
        
                function update(currentTime) {
                    if (!startTime) startTime = currentTime;
        
                    const progress = Math.min((currentTime - startTime) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);
        
                    element.textContent = value.toLocaleString() + suffix;
        
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                }
        
                requestAnimationFrame(update);
            }
        
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
        
                        const counter = entry.target;
                        const text = counter.dataset.target;
        
                        let endValue = parseInt(text.replace(/[^0-9]/g, ''));
                        let suffix = '';
        
                        if (text.includes('%')) {
                            suffix = '%';
                        } else if (text.includes('+')) {
                            suffix = '+';
                        }
        
                        animateCounter(counter, 0, endValue, 2000, suffix);
        
                        counterObserver.unobserve(counter);
                    }
                });
            }, {
                threshold: 0.5
            });
        
            document.querySelectorAll('.counter').forEach(counter => {
                counterObserver.observe(counter);
            });
            
        
            // Countdown Timer
           const targetDate = new Date("September 05, 2026 20:00:00").getTime();
        
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = targetDate - now;
        
                if (distance <= 0) {
                    document.getElementById("days").textContent = "00";
                    document.getElementById("hours").textContent = "00";
                    document.getElementById("minutes").textContent = "00";
                    document.getElementById("seconds").textContent = "00";
                    return;
                }
        
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
                document.getElementById("days").textContent = String(days).padStart(2, '0');
                document.getElementById("hours").textContent = String(hours).padStart(2, '0');
                document.getElementById("minutes").textContent = String(minutes).padStart(2, '0');
                document.getElementById("seconds").textContent = String(seconds).padStart(2, '0');
            }
        
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>

</body>

</html>