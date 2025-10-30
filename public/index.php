<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EnvisionFlow - Blueprint Your Vision</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Source+Code+Pro:wght@400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="logo.webp">
    
    <style>
        :root {
            --dark-bg: #0A0A0A;
            --dark-surface: #1C1C1E;
            --dark-card-bg: #2C2C2E;
            --dark-text: #F2F2F7;
            --dark-secondary-text: #A9A9B2;
            --dark-border: #3A3A3C;
            --dark-input-bg: #2C2C2E;
            
            --light-bg: #F9F9F9;
            --light-surface: #FFFFFF;
            --light-card-bg: #EFEFF4;
            --light-text: #1C1C1E;
            --light-secondary-text: #6A6A6A;
            --light-border: #E5E5EA;
            --light-input-bg: #E5E5EA;

            --gradient-start: #B16CEA;
            --gradient-end: #6CEAC7;
            --accent-orange: #FF6B35;
            --accent-pink: #FF10F0;

            --transition-speed: 0.3s ease;
        }

        @keyframes gradient-flow {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        body {
            background-color: var(--dark-bg);
            background-image: 
                radial-gradient(at 0% 100%, rgba(108, 234, 199, 0.18) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(177, 108, 234, 0.18) 0, transparent 50%),
                radial-gradient(at 50% 50%, rgba(255, 107, 53, 0.1) 0, transparent 50%);
            background-size: 200% 200%;
            animation: gradient-flow 30s ease infinite alternate;
            color: var(--dark-text);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 5%;
            right: -5%;
            width: 500px;
            height: 500px;
            background-image: url('blob.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.8;
            animation: float 20s ease-in-out infinite, spin 40s linear infinite;
            pointer-events: none;
            z-index: 0;
            filter: blur(8px) brightness(1.3);
        }
        
        body::after {
            content: '';
            position: fixed;
            bottom: 10%;
            left: -5%;
            width: 400px;
            height: 400px;
            background-image: url('blob.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.7;
            animation: float 25s ease-in-out infinite reverse, spin 50s linear infinite reverse;
            pointer-events: none;
            z-index: 0;
            filter: blur(10px) brightness(1.2) hue-rotate(80deg);
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }

        body.light-mode {
            background-color: var(--light-bg);
            background-image: radial-gradient(at 0% 100%, rgba(108, 234, 199, 0.25) 0, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(177, 108, 234, 0.25) 0, transparent 50%);
            color: var(--light-text);
        }
        body.light-mode .container-wrapper {
            background-image: radial-gradient(at 0% 100%, rgba(108, 234, 199, 0.15) 0, transparent 40%),
                              radial-gradient(at 100% 0%, rgba(177, 108, 234, 0.15) 0, transparent 40%);
        }
        body.light-mode .card, body.light-mode .how-it-works-card {
            background-color: var(--light-surface);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        body.light-mode .cta-button, body.light-mode .action-button:not(:disabled) {
            color: #1c1c1e;
        }
        body.light-mode .prompt-box, body.light-mode .file-upload-label, body.light-mode .input-group,
        body.light-mode #chatInput, body.light-mode #chatInputArea {
            background-color: var(--light-input-bg);
            border: 1px solid var(--light-border);
            box-shadow: none;
            color: var(--light-text);
        }
        body.light-mode .prompt-box:focus, body.light-mode #chatInput:focus {
            box-shadow: 0 0 0 2px var(--gradient-end);
        }
        body.light-mode .char-counter, body.light-mode .input-group-text, body.light-mode .how-it-works-card h3 {
            color: var(--light-secondary-text);
        }
        body.light-mode .how-it-works-card .icon {
            color: var(--gradient-end);
            background-color: var(--light-card-bg);
        }
        body.light-mode .navbar {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--light-border);
        }
        body.light-mode .mode-toggle {
            background-color: var(--light-surface);
            border: 1px solid var(--light-border);
        }
        body.light-mode footer {
            color: var(--light-secondary-text);
            border-top: 1px solid var(--light-border);
        }
        body.light-mode .nav-links a {
            color: var(--light-secondary-text);
        }
        body.light-mode .nav-links a:hover {
            color: var(--light-text);
        }
        body.light-mode .mobile-nav-toggle svg {
            color: var(--light-text);
        }

        /* General styles */
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        a {
            color: var(--gradient-end);
            text-decoration: none;
            transition: all var(--transition-speed);
        }
        a:hover {
            color: var(--gradient-start);
            text-decoration: underline;
        }
        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            outline: none;
            user-select: none;
        }
        svg {
            display: block;
        }
        main {
            width: 100%;
            position: relative;
            z-index: 1;
        }

        /* Nav Bar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--dark-border);
            transition: all var(--transition-speed);
        }
        .navbar .logo {
            font-weight: 900;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            user-select: none;
            position: relative;
        }
        .navbar .logo::after {
            content: '✨';
            position: absolute;
            right: -25px;
            top: -5px;
            font-size: 0.8rem;
            animation: pulse 2s ease-in-out infinite;
        }
        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        .nav-links a {
            font-weight: 500;
            font-size: 1rem;
            position: relative;
            color: var(--dark-secondary-text);
        }
        .nav-links a:hover {
            color: var(--dark-text);
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-end);
            transition: width var(--transition-speed);
        }
        .nav-links a:hover::after, .nav-links a:focus::after {
            width: 100%;
        }

        .cta-button {
            padding: 0.75rem 1.75rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 9999px;
            font-weight: 700;
            color: #121212;
            font-size: 1rem;
            box-shadow: 0 6px 12px rgba(108, 234, 199, 0.4);
            transition: all var(--transition-speed);
            position: relative;
            overflow: hidden;
        }
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        .cta-button:hover::before {
            left: 100%;
        }
        .cta-button:hover, .cta-button:focus {
            filter: brightness(1.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(108, 234, 199, 0.6);
        }

        .mode-toggle {
            background: var(--dark-card-bg);
            color: var(--dark-text);
            border: 1px solid var(--dark-border);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-left: 1rem;
            transition: all var(--transition-speed);
        }
        .mode-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            background-color: var(--gradient-end);
            border-color: var(--gradient-end);
        }
        .mode-toggle svg {
            width: 20px;
            height: 20px;
            transition: all var(--transition-speed);
        }
        .mode-toggle:hover svg {
            color: #121212;
        }
        body.light-mode .mode-toggle svg {
            color: var(--light-text);
        }

        /* Hero Section - Compact */
        .hero {
            text-align: center;
            padding: 3rem 2rem 1.5rem;
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }
        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 900;
            letter-spacing: -0.05em;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end), var(--accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.75rem;
            user-select: none;
            line-height: 1.1;
        }
        .hero p {
            font-size: clamp(0.95rem, 2.5vw, 1.15rem);
            color: var(--dark-secondary-text);
            line-height: 1.5;
            margin-bottom: 1rem;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-bottom: 0;
        }

        .cta-button-secondary {
            padding: 0.75rem 1.75rem;
            background-color: transparent;
            border: 2px solid var(--gradient-end);
            color: var(--gradient-end);
            border-radius: 9999px;
            font-weight: 700;
            transition: all var(--transition-speed);
        }
        .cta-button-secondary:hover {
            background-color: var(--gradient-end);
            color: #121212;
            text-decoration: none;
            transform: translateY(-2px);
        }
        body.light-mode .cta-button-secondary {
            color: var(--gradient-start);
            border-color: var(--gradient-start);
        }
        body.light-mode .cta-button-secondary:hover {
            background-color: var(--gradient-start);
            color: #fff;
        }

        /* Main Content */
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
        }

        /* Hand-drawn Cloud Prompt Section - Closer to hero */
        .prompt-section-container {
            max-width: 900px;
            margin: 1.5rem auto 3rem;
            padding: 0 2rem 2rem;
            background: transparent;
            position: relative;
            transition: all var(--transition-speed);
        }

        .prompt-box-wrapper-new {
            position: relative;
            animation: cloudFloat 6s ease-in-out infinite;
        }

        @keyframes cloudFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(1deg); }
        }

        .prompt-box-new {
            width: 100%;
            min-height: 120px;
            max-height: 300px;
            padding: 2rem;
            background: var(--dark-input-bg);
            color: var(--dark-text);
            font-size: 1.15rem;
            font-family: inherit;
            resize: vertical;
            line-height: 1.6;
            border: none;
            outline: none;
            position: relative;
            z-index: 2;
            
            border-radius: 60px 80px 70px 90px / 80px 60px 90px 70px;
            box-shadow: 
                0 0 0 3px var(--gradient-end),
                inset 0 2px 10px rgba(0, 0, 0, 0.1);
            
            clip-path: polygon(
                15% 5%, 25% 2%, 35% 8%, 45% 3%, 55% 7%, 65% 2%, 75% 6%, 85% 3%, 95% 8%,
                98% 15%, 95% 25%, 98% 35%, 95% 45%, 98% 55%, 95% 65%, 98% 75%, 95% 85%,
                85% 97%, 75% 94%, 65% 98%, 55% 93%, 45% 97%, 35% 92%, 25% 98%, 15% 95%,
                2% 85%, 5% 75%, 2% 65%, 5% 55%, 2% 45%, 5% 35%, 2% 25%, 5% 15%
            );
            
            transition: all var(--transition-speed);
        }

        .prompt-box-wrapper-new::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(45deg, var(--gradient-start), var(--gradient-end));
            z-index: 1;
            opacity: 0.3;
            
            border-radius: 50px 70px 60px 80px / 70px 50px 80px 60px;
            clip-path: polygon(
                12% 8%, 28% 5%, 38% 12%, 48% 6%, 58% 11%, 68% 5%, 78% 9%, 88% 6%, 96% 12%,
                99% 18%, 96% 28%, 99% 38%, 96% 48%, 99% 58%, 96% 68%, 99% 78%, 96% 88%,
                88% 94%, 78% 91%, 68% 95%, 58% 89%, 48% 94%, 38% 88%, 28% 95%, 18% 92%,
                4% 88%, 7% 78%, 4% 68%, 7% 58%, 4% 48%, 7% 38%, 4% 28%, 7% 18%
            );
            
            animation: cloudGlow 4s ease-in-out infinite;
        }

        @keyframes cloudGlow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.02); }
        }

        .prompt-box-new:focus {
            outline: none;
            box-shadow: 
                0 0 0 4px var(--gradient-end),
                inset 0 2px 15px rgba(0, 0, 0, 0.2),
                0 0 30px rgba(108, 234, 199, 0.4);
            transform: scale(1.02);
        }
        
        body.light-mode .prompt-box-new {
            background: var(--light-input-bg);
            color: var(--light-text);
            box-shadow: 
                0 0 0 3px var(--gradient-start),
                inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        body.light-mode .prompt-box-new:focus {
            box-shadow: 
                0 0 0 4px var(--gradient-start),
                inset 0 2px 15px rgba(0, 0, 0, 0.08),
                0 0 30px rgba(177, 108, 234, 0.3);
        }

        body.light-mode .prompt-box-wrapper-new::before {
            background: linear-gradient(45deg, var(--gradient-end), var(--gradient-start));
            opacity: 0.2;
        }

        .prompt-actions-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            gap: 1rem;
        }

        .secondary-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-button-new {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            color: #121212;
            box-shadow: 0 4px 12px rgba(108, 234, 199, 0.4);
            transition: all var(--transition-speed);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .action-button-new::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .action-button-new:hover::before {
            width: 300px;
            height: 300px;
        }
        
        body.light-mode .action-button-new {
            color: #1c1c1e;
        }

        .action-button-new:hover {
            filter: brightness(1.15);
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 15px rgba(108, 234, 199, 0.6);
        }
        
        .action-button-new:disabled {
            background: var(--dark-card-bg);
            cursor: not-allowed;
            box-shadow: none;
            color: #6a6a6a;
        }
        
        body.light-mode .action-button-new:disabled {
            background: var(--light-card-bg);
            color: var(--light-secondary-text);
        }

        .small-button {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--dark-secondary-text);
            background: var(--dark-input-bg);
            border: 1px solid var(--dark-border);
            transition: all var(--transition-speed);
        }
        .small-button:hover {
            color: var(--dark-text);
            background: var(--dark-card-bg);
            border-color: var(--gradient-end);
            transform: translateY(-2px);
        }

        body.light-mode .small-button {
            color: var(--light-secondary-text);
            background: var(--light-input-bg);
            border-color: var(--light-border);
        }
        body.light-mode .small-button:hover {
            color: var(--light-text);
            background: var(--light-card-bg);
            border-color: var(--gradient-end);
        }
        
        .small-button svg {
            width: 16px;
            height: 16px;
            color: var(--gradient-start);
        }
        body.light-mode .small-button svg {
            color: var(--light-secondary-text);
        }
        body.light-mode .small-button:hover svg {
            color: var(--gradient-end);
        }

        /* How it Works Section */
        .how-it-works-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        .how-it-works-card {
            background-color: var(--dark-surface);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: all var(--transition-speed);
            border: 1px solid transparent;
        }
        .how-it-works-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 24px rgba(108, 234, 199, 0.3);
            border-color: var(--gradient-end);
        }
        .how-it-works-card .icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 50%;
            margin-bottom: 1rem;
            color: #121212;
            font-size: 1.8rem;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(108, 234, 199, 0.4);
        }
        .how-it-works-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 0.5rem;
            color: var(--dark-text);
        }
        .how-it-works-card p {
            font-size: 1rem;
            color: var(--dark-secondary-text);
            line-height: 1.6;
        }
        
        .section-heading {
            text-align: center;
            font-weight: 900;
            font-size: clamp(1.8rem, 4vw, 3rem);
            margin-bottom: 3rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end), var(--accent-orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }
        .section-heading::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        /* Chat UI (Hidden on landing page) */
        .chat-container { display: none; }

        /* Footer */
        footer {
            text-align: center;
            color: var(--dark-secondary-text);
            padding: 3rem 1rem 2rem;
            font-size: 0.9rem;
            user-select: none;
            border-top: 1px solid var(--dark-border);
            margin-top: 4rem;
        }

        /* Mobile Nav */
        .mobile-nav-toggle {
            display: none;
            cursor: pointer;
            background: transparent;
            border: none;
        }
        .mobile-nav-toggle svg {
            color: var(--dark-text);
            width: 28px;
            height: 28px;
            transition: color var(--transition-speed);
        }
        body.light-mode .mobile-nav-toggle svg {
            color: var(--light-text);
        }

        .mobile-nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(12px);
            padding: 2rem;
            z-index: 999;
            transform: translateY(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-nav-links.open {
            transform: translateY(0);
        }

        body.light-mode .mobile-nav-links {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
        }

        .mobile-nav-links li {
            width: 100%;
            margin-bottom: 1rem;
        }
        .mobile-nav-links a {
            padding: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            display: block;
            text-align: center;
            border-bottom: 1px solid var(--dark-border);
        }
        .mobile-nav-links a:last-child {
            border-bottom: none;
        }
        .mobile-nav-links .cta-button {
            width: 100%;
        }

        /* Accordion-specific styles */
        .accordion-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .accordion-item {
            background-color: var(--dark-surface);
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: box-shadow var(--transition-speed);
            border: 1px solid var(--dark-border);
        }
        .accordion-item:hover {
            box-shadow: 0 8px 20px rgba(108, 234, 199, 0.2);
            border-color: var(--gradient-end);
        }
        body.light-mode .accordion-item {
            background-color: var(--light-surface);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        body.light-mode .accordion-item:hover {
            box-shadow: 0 8px 20px rgba(177, 108, 234, 0.2);
        }

        .accordion-header {
            width: 100%;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: transparent;
            border: none;
            color: var(--dark-text);
            font-size: 1.25rem;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
            transition: color var(--transition-speed);
        }
        .accordion-header:hover {
            color: var(--gradient-end);
        }
        body.light-mode .accordion-header {
            color: var(--light-text);
        }
        body.light-mode .accordion-header:hover {
            color: var(--gradient-start);
        }

        .accordion-icon {
            font-size: 2rem;
            line-height: 1;
            transition: transform 0.3s ease;
        }
        .accordion-header[aria-expanded="true"] .accordion-icon {
            transform: rotate(45deg);
        }

        .accordion-content {
            padding: 0 2rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out;
        }
        .accordion-content.open {
            max-height: 200px;
            padding-bottom: 2rem;
        }
        .accordion-content p {
            margin: 0;
            color: var(--dark-secondary-text);
            font-size: 1rem;
        }
        body.light-mode .accordion-content p {
            color: var(--light-secondary-text);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 0.5rem 1rem;
                flex-wrap: nowrap;
            }
            .nav-links {
                display: none;
            }
            .navbar .cta-button {
                display: none;
            }
            .mobile-nav-toggle {
                display: block;
                margin-left: 1rem;
            }
            .mobile-nav-links {
                display: flex;
            }
            .hero {
                padding: 2.5rem 1rem 1rem;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .hero p {
                font-size: 0.95rem;
            }
            .prompt-section-container {
                padding: 0 1.5rem 1.5rem;
                margin: 1rem auto 2rem;
            }
            .prompt-box-new {
                font-size: 1rem;
                padding: 1.5rem;
            }
            .how-it-works-grid {
                display: none;
            }
            .chat-container {
                padding: 1rem;
                height: 400px;
            }
            .prompt-actions-row {
                flex-direction: column-reverse;
                align-items: stretch;
            }
            .secondary-buttons {
                justify-content: center;
            }
            .accordion-container {
                display: flex;
            }
        }
        /* Show original grid on larger screens and hide accordion */
        @media (min-width: 769px) {
            .accordion-container {
                display: none;
            }
            .mobile-nav-links {
                display: none;
            }
            .nav-links {
                display: flex;
            }
            .navbar .cta-button {
                display: block;
            }
            .mobile-nav-toggle {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <nav class="navbar">
            <div class="logo"><a href="index.php">EnvisionFlow</a></div>
            
            <ul class="nav-links">
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="blueprint.php">View Blueprint</a></li>
            </ul>
            
            <div style="display:flex; align-items:center;">
                <button class="cta-button" id="startVisionBtn" aria-label="Start your vision">Blueprint Now</button>
                <button class="mode-toggle" id="modeToggle" aria-label="Toggle light and dark mode">
                    <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun" style="display: none;">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                    <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon" style="display: block;">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                </button>
                <button class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Toggle mobile navigation">
                    <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </nav>
        <ul class="mobile-nav-links" id="mobileNavLinks">
            <li><a href="#how-it-works">How It Works</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="blueprint.php">View Blueprint</a></li>
            <li><a href="index.php" class="cta-button">Start New Blueprint</a></li>
        </ul>

        <header class="hero">
            <h1>EnvisionFlow</h1>
            <p>Your AI-powered launchpad for turning raw ideas into flawless blueprints. Stop dreaming, start building.</p>
            <div class="hero-buttons">
                <a href="#how-it-works" class="cta-button-secondary">Learn How</a>
            </div>
        </header>

        <main class="container">
            <section id="blueprint" class="prompt-section-container">
                <div id="promptInputArea">
                    <div class="prompt-box-wrapper-new">
                        <textarea
                            id="projectDescription"
                            class="prompt-box-new"
                            placeholder="Build something amazing. Describe your idea here..."
                            maxlength="1000"
                            rows="5"
                        ></textarea>
                        <span class="char-counter" id="charCounter">0 / 1000</span>
                    </div>

                    <div class="prompt-actions-row">
                        <div class="secondary-buttons">
                            <label class="small-button" for="fileUpload">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                File
                                <input type="file" id="fileUpload" style="display: none;" />
                            </label>
                            <button class="small-button" type="button" id="attachLinkBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07L9.44 7.94"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                </svg>
                                Link
                            </button>
                        </div>
                        <button class="action-button-new" id="startBuildingBtn" disabled>
                            Start Blueprinting 🚀
                        </button>
                    </div>

                    <div id="linkInputContainer" style="display: none; margin-top: 1rem;">
                        <input
                            class="prompt-box-new"
                            type="url"
                            id="attachLink"
                            placeholder="Paste a link here (optional)"
                            style="padding: 0.75rem 1.5rem; min-height: unset;"
                        />
                    </div>
                </div>
                
                <div id="chatContainer" class="chat-container">
                </div>
            </section>
            
            <section id="how-it-works" class="accordion-section" style="margin-top: 5rem;">
                <h2 class="section-heading">The Flow, Demystified</h2>
                <div class="how-it-works-grid">
                    <div class="how-it-works-card">
                        <div class="icon">1</div>
                        <h3>Drop Your Vision</h3>
                        <p>Simply articulate your big idea. Our prompt box is designed to capture every detail, no matter how small, to build a powerful foundation.</p>
                    </div>
                    <div class="how-it-works-card">
                        <div class="icon">2</div>
                        <h3>Launch the Blueprint</h3>
                        <p>Hit the button and watch the magic happen. The AI instantly starts to process your vision, organizing it into a coherent, strategic draft.</p>
                    </div>
                    <div class="how-it-works-card">
                        <div class="icon">3</div>
                        <h3>Collaborate in Real-Time</h3>
                        <p>Refine your plan with an interactive chat. This isn't a one-and-one tool—it's a dynamic partnership where you can ask questions and fine-tune your blueprint.</p>
                    </div>
                    <div class="how-it-works-card">
                        <div class="icon">4</div>
                        <h3>Build Your Empire</h3>
                        <p>Receive a comprehensive, beautifully structured blueprint. Your idea is now a tangible, actionable plan, ready for you to execute and conquer.</p>
                    </div>
                    <div class="how-it-works-card">
                        <div class="icon">🔒</div>
                        <h3>Security First</h3>
                        <p>Your data is never stored on our servers. All blueprint generation happens within your browser, and you can download a PDF blueprint with confidence knowing your data is secure.</p>
                    </div>
                </div>
                
                <div class="accordion-container">
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-how1">
                            <h3>Drop Your Vision</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-how1">
                            <p>Simply articulate your big idea. Our prompt box is designed to capture every detail, no matter how small, to build a powerful foundation.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-how2">
                            <h3>Launch the Blueprint</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-how2">
                            <p>Hit the button and watch the magic happen. The AI instantly starts to process your vision, organizing it into a coherent, strategic draft.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-how3">
                            <h3>Collaborate in Real-Time</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-how3">
                            <p>Refine your plan with an interactive chat. This isn't a one-and-one tool—it's a dynamic partnership where you can ask questions and fine-tune your blueprint.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-how4">
                            <h3>Build Your Empire</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-how4">
                            <p>Receive a comprehensive, beautifully structured blueprint. Your idea is now a tangible, actionable plan, ready for you to execute and conquer.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-how5">
                            <h3>Security First</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-how5">
                            <p>Your data is never stored on our servers. All blueprint generation happens within your browser, and you can download a PDF blueprint with confidence knowing your data is secure.</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="about" class="accordion-section" style="margin-top: 5rem;">
                <h2 class="section-heading">What It Is</h2>
                <div class="how-it-works-grid">
                    <div class="how-it-works-card">
                        <h3>Your Co-Creator</h3>
                        <p>EnvisionFlow is your AI-powered co-creator. A platform that takes your unstructured thoughts and transforms them into a clear, strategic blueprint. No more vague ideas—this is where clarity and action begin.</p>
                    </div>
                    <div class="how-it-works-card">
                        <h3>The Catalyst for Innovation</h3>
                        <p>It's the engine that propels your projects forward, from a simple spark to a complete, ready-to-execute plan. EnvisionFlow is the catalyst that makes your big ideas happen.</p>
                    </div>
                    <div class="how-it-works-card">
                        <h3>Blueprint Anything</h3>
                        <p>Use it to build anything: a new website, a business plan, a marketing strategy, or a product roadmap. Our AI can handle a wide range of tasks to get your project off the ground.</p>
                    </div>
                    <div class="how-it-works-card">
                        <h3>Hype for Your Vision</h3>
                        <p>This is more than a tool—it's a launchpad for your ambitions. We've designed every detail to be motivational, dynamic, and genuinely helpful. Your future is waiting; let's blueprint it.</p>
                    </div>
                </div>

                <div class="accordion-container">
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-about1">
                            <h3>Your Co-Creator</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-about1">
                            <p>EnvisionFlow is your AI-powered co-creator. A platform that takes your unstructured thoughts and transforms them into a clear, strategic blueprint. No more vague ideas—this is where clarity and action begin.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-about2">
                            <h3>The Catalyst for Innovation</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-about2">
                            <p>It's the engine that propels your projects forward, from a simple spark to a complete, ready-to-execute plan. EnvisionFlow is the catalyst that makes your big ideas happen.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-about3">
                            <h3>Blueprint Anything</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-about3">
                            <p>Use it to build anything: a new website, a business plan, a marketing strategy, or a product roadmap. Our AI can handle a wide range of tasks to get your project off the ground.</p>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-header" aria-expanded="false" aria-controls="content-about4">
                            <h3>Hype for Your Vision</h3>
                            <span class="accordion-icon">+</span>
                        </button>
                        <div class="accordion-content" id="content-about4">
                            <p>This is more than a tool—it's a launchpad for your ambitions. We've designed every detail to be motivational, dynamic, and genuinely helpful. Your future is waiting; let's blueprint it.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <footer>
            <p>&copy; 2025 EnvisionFlow. All rights reserved. Crafted with passion by Graphical Studios.</p>
        </footer>
    </div>
    <script>
        const body = document.body;
        const modeToggle = document.getElementById('modeToggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        const projectDescription = document.getElementById('projectDescription');
        const charCounter = document.getElementById('charCounter');
        const startBuildingBtn = document.getElementById('startBuildingBtn');
        const promptSectionContainer = document.querySelector('.prompt-section-container');
        const startVisionBtns = document.querySelectorAll('#startVisionBtn, #startVisionBtnHero');
        const attachLinkBtn = document.getElementById('attachLinkBtn');
        const linkInputContainer = document.getElementById('linkInputContainer');
        const mobileNavToggle = document.getElementById('mobileNavToggle');
        const mobileNavLinks = document.getElementById('mobileNavLinks');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        // Dark/Light Mode Toggle
        modeToggle.addEventListener('click', () => {
            body.classList.toggle('light-mode');
            const isLightMode = body.classList.contains('light-mode');

            sunIcon.style.display = isLightMode ? 'none' : 'block';
            moonIcon.style.display = isLightMode ? 'block' : 'none';
            
            localStorage.setItem('theme', isLightMode ? 'light' : 'dark');
        });

        // Set initial theme based on user preference or local storage
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (savedTheme === 'light') {
                body.classList.add('light-mode');
            } else if (savedTheme === 'dark') {
                body.classList.remove('light-mode');
            } else if (prefersDark) {
                body.classList.remove('light-mode');
            } else {
                body.classList.add('light-mode');
            }

            const isLightMode = body.classList.contains('light-mode');
            sunIcon.style.display = isLightMode ? 'none' : 'block';
            moonIcon.style.display = isLightMode ? 'block' : 'none';
        });

        // Enable/Disable Start Button
        projectDescription.addEventListener('input', () => {
            const len = projectDescription.value.length;
            charCounter.textContent = `${len} / 1000`;
            startBuildingBtn.disabled = len === 0;
        });

        // Enter key support for prompt box
        projectDescription.addEventListener('keypress', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                if (!startBuildingBtn.disabled) {
                    startBuildingBtn.click();
                }
            }
        });

        attachLinkBtn.addEventListener('click', () => {
            linkInputContainer.style.display = 'block';
            linkInputContainer.querySelector('input').focus();
        });

        startVisionBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                promptSectionContainer.scrollIntoView({ behavior: 'smooth' });
                projectDescription.focus();
            });
        });

        // Main logic to redirect to chat.html
        startBuildingBtn.addEventListener('click', () => {
            const idea = projectDescription.value.trim();
            if (idea) {
                sessionStorage.setItem('initialIdea', idea);
                window.location.href = 'chat.html';
            }
        });

        // Mobile Navigation Toggle Logic
        mobileNavToggle.addEventListener('click', () => {
            const isMenuOpen = mobileNavLinks.classList.toggle('open');
            if (isMenuOpen) {
                hamburgerIcon.style.display = 'none';
                closeIcon.style.display = 'block';
            } else {
                hamburgerIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            }
        });

        // Close mobile menu when a link is clicked
        document.querySelectorAll('.mobile-nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                mobileNavLinks.classList.remove('open');
                hamburgerIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            });
        });

        // Accordion Toggle Logic
        document.querySelectorAll('.accordion-header').forEach(header => {
            header.addEventListener('click', () => {
                const content = header.nextElementSibling;
                const isExpanded = header.getAttribute('aria-expanded') === 'true' || false;

                // Close other open accordions in the same container
                document.querySelectorAll('.accordion-content.open').forEach(openContent => {
                    if (openContent !== content) {
                        openContent.classList.remove('open');
                        openContent.previousElementSibling.setAttribute('aria-expanded', 'false');
                    }
                });

                header.setAttribute('aria-expanded', !isExpanded);
                content.classList.toggle('open');
            });
        });
    </script>
</body>
</html>