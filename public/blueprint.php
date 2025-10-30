<?php
session_start();

$blueprintData = null;
$error = null;

// Check if a new blueprint session has just been created
if (isset($_SESSION['blueprintData'])) {
    // Corrected: Decode the JSON string into a PHP array for JavaScript to use
    $blueprintData = json_decode($_SESSION['blueprintData'], true);
    
    // Do NOT unset the session data here. Let's keep it for a page refresh.
    // The blueprint will be cleared when the user starts a new one.
} else {
    $error = "No blueprint data found. Please start again from the main page.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EnvisionFlow - AI Generated Blueprint</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet" />
     <link rel="icon" type="image/x-icon" href="logo.jpg">
    <style>
        /* CSS Variables */
        :root {
            --dark-bg: #0A0A0A;
            --dark-surface: #1C1C1E;
            --dark-card-bg: #2C2C2E;
            --dark-text: #F2F2F7;
            --dark-secondary-text: #A9A9B2;
            --dark-tertiary-text: #6D6D73;
            --dark-border: #3A3A3C;
            --dark-input-bg: #222;
            --dark-hover: #48484A;

            --light-bg: #F9F9F9;
            --light-surface: #FFFFFF;
            --light-card-bg: #F5F5F7;
            --light-text: #1C1C1E;
            --light-secondary-text: #6A6A6A;
            --light-tertiary-text: #8E8E93;
            --light-border: #E5E5EA;
            --light-input-bg: #FFFFFF;
            --light-hover: #F2F2F7;

            --gradient-start: #B16CEA;
            --gradient-end: #6CEAC7;
            --gradient-hover: #9D5BD2;
            --success-color: #34C759;
            --warning-color: #FF9500;
            --error-color: #FF3B30;
            --info-color: #007AFF;

            --transition-speed: 0.3s ease;
            --border-radius: 16px;
            --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-medium: 0 8px 32px rgba(0, 0, 0, 0.12);
            --shadow-heavy: 0 16px 48px rgba(0, 0, 0, 0.2);
        }

        /* Animations */
        @keyframes gradient-flow {
            0% { background-position: 0% 0%; }
            50% { background-position: 100% 100%; }
            100% { background-position: 0% 0%; }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--dark-bg);
            background-image:
                radial-gradient(at 0% 100%, rgba(108, 234, 199, 0.15) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(177, 108, 234, 0.15) 0, transparent 50%);
            background-size: 200% 200%;
            animation: gradient-flow 45s ease infinite;
            color: var(--dark-text);
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-weight: 400;
        }

        body.light-mode {
            background-color: var(--light-bg);
            background-image:
                radial-gradient(at 0% 100%, rgba(108, 234, 199, 0.08) 0, transparent 50%),
                radial-gradient(at 100% 0%, rgba(177, 108, 234, 0.08) 0, transparent 50%);
            color: var(--light-text);
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 72px;
            background: rgba(28, 28, 30, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            border-bottom: 1px solid var(--dark-border);
            z-index: 1000;
            transition: all var(--transition-speed);
        }

        body.light-mode nav {
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid var(--light-border);
        }

        .logo {
            font-weight: 800;
            font-size: 1.75rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            user-select: none;
        }

        .logo a {
            text-decoration: none;
            color: inherit;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            font-weight: 500;
            color: var(--dark-secondary-text);
            text-decoration: none;
            transition: all var(--transition-speed);
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            transition: width var(--transition-speed);
        }

        .nav-links a:hover,
        .nav-links a:focus-visible {
            color: var(--dark-text);
        }

        .nav-links a:hover::after,
        .nav-links a:focus-visible::after {
            width: 100%;
        }

        body.light-mode .nav-links a {
            color: var(--light-secondary-text);
        }

        body.light-mode .nav-links a:hover,
        body.light-mode .nav-links a:focus-visible {
            color: var(--light-text);
        }

        .nav-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: 50px;
            font-weight: 600;
            color: #FFFFFF;
            text-decoration: none;
            font-size: 0.95rem;
            box-shadow: 0 4px 16px rgba(108, 234, 199, 0.3);
            transition: all var(--transition-speed);
            border: none;
            cursor: pointer;
        }

        .cta-button:hover,
        .cta-button:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(108, 234, 199, 0.4);
            filter: brightness(1.1);
        }

        .cta-button:active {
            transform: translateY(0);
        }

        .cta-button.secondary {
            background: transparent;
            border: 2px solid var(--dark-border);
            color: var(--dark-text);
            box-shadow: none;
        }

        .cta-button.secondary:hover {
            border-color: var(--gradient-end);
            color: var(--gradient-end);
            box-shadow: 0 4px 16px rgba(108, 234, 199, 0.2);
        }

        body.light-mode .cta-button.secondary {
            border-color: var(--light-border);
            color: var(--light-text);
        }

        body.light-mode .cta-button.secondary:hover {
            border-color: var(--gradient-start);
            color: var(--gradient-start);
            box-shadow: 0 4px 16px rgba(177, 108, 234, 0.2);
        }

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--dark-card-bg);
            color: var(--dark-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all var(--transition-speed);
            font-size: 18px;
        }

        .theme-toggle:hover {
            background: var(--dark-hover);
            transform: scale(1.05);
        }

        body.light-mode .theme-toggle {
            background: var(--light-card-bg);
            color: var(--light-text);
        }

        body.light-mode .theme-toggle:hover {
            background: var(--light-hover);
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 72px;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            animation: fadeIn 0.6s ease-out;
        }

        .blueprint-header {
            text-align: center;
            margin-bottom: 1rem;
        }

        .blueprint-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .blueprint-subtitle {
            font-size: 1.125rem;
            color: var(--dark-secondary-text);
            font-weight: 500;
            max-width: 600px;
            margin: 0 auto;
        }

        body.light-mode .blueprint-subtitle {
            color: var(--light-secondary-text);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            background: var(--dark-surface);
            border-radius: var(--border-radius);
            border: 1px solid var(--dark-border);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-light);
        }

        body.light-mode .action-bar {
            background: var(--light-surface);
            border-color: var(--light-border);
        }

        /* Blueprint Content */
        .blueprint-content {
            background: var(--dark-surface);
            border-radius: var(--border-radius);
            border: 1px solid var(--dark-border);
            overflow: hidden;
            box-shadow: var(--shadow-medium);
            animation: slideInUp 0.6s ease-out 0.2s both;
        }

        body.light-mode .blueprint-content {
            background: var(--light-surface);
            border-color: var(--light-border);
        }

        /* Accordion Styles */
        .accordion {
            border-bottom: 1px solid var(--dark-border);
            transition: all var(--transition-speed);
        }

        .accordion:last-child {
            border-bottom: none;
        }

        body.light-mode .accordion {
            border-bottom-color: var(--light-border);
        }

        .accordion-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2rem;
            cursor: pointer;
            user-select: none;
            background: transparent;
            transition: all var(--transition-speed);
            border: none;
            width: 100%;
            text-align: left;
        }

        .accordion-header:hover {
            background: var(--dark-card-bg);
        }

        body.light-mode .accordion-header:hover {
            background: var(--light-card-bg);
        }

        .accordion-header.active {
            background: var(--dark-card-bg);
            border-bottom: 1px solid var(--dark-border);
        }

        body.light-mode .accordion-header.active {
            background: var(--light-card-bg);
            border-bottom-color: var(--light-border);
        }

        .accordion-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-text);
        }

        body.light-mode .accordion-title {
            color: var(--light-text);
        }

        .accordion-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 16px;
            flex-shrink: 0;
        }

        .accordion-chevron {
            width: 24px;
            height: 24px;
            transition: transform var(--transition-speed);
            color: var(--dark-secondary-text);
        }

        .accordion-chevron.active {
            transform: rotate(180deg);
        }

        body.light-mode .accordion-chevron {
            color: var(--light-secondary-text);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: all var(--transition-speed);
            background: var(--dark-bg);
        }

        .accordion-content.active {
            max-height: 2000px;
            border-bottom: 1px solid var(--dark-border);
        }

        body.light-mode .accordion-content {
            background: var(--light-bg);
        }

        body.light-mode .accordion-content.active {
            border-bottom-color: var(--light-border);
        }

        .accordion-inner {
            padding: 2rem;
        }

        /* Content Styling */
        .content-text {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--dark-text);
            margin-bottom: 1rem;
        }

        body.light-mode .content-text {
            color: var(--light-text);
        }

        .content-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .content-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .content-list li:last-child {
            border-bottom: none;
        }

        body.light-mode .content-list li {
            border-bottom-color: rgba(0, 0, 0, 0.05);
        }

        .list-bullet {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gradient-end);
            margin-top: 0.5rem;
            flex-shrink: 0;
        }

        .list-content {
            flex: 1;
            font-size: 1rem;
            line-height: 1.6;
            color: var(--dark-text);
        }

        body.light-mode .list-content {
            color: var(--light-text);
        }

        /* Error State */
        .error-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--error-color);
            animation: fadeIn 0.6s ease-out;
        }

        .error-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1rem;
            color: var(--dark-secondary-text);
            margin-bottom: 2rem;
        }

        body.light-mode .error-message {
            color: var(--light-secondary-text);
        }

        /* Loading State */
        .loading-state {
            text-align: center;
            padding: 4rem 2rem;
            animation: fadeIn 0.6s ease-out;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--dark-border);
            border-top: 4px solid var(--gradient-end);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 2rem;
        }

        body.light-mode .loading-spinner {
            border-color: var(--light-border);
            border-top-color: var(--gradient-start);
        }

        .loading-text {
            font-size: 1.125rem;
            color: var(--dark-secondary-text);
            animation: pulse 2s ease-in-out infinite;
        }

        body.light-mode .loading-text {
            color: var(--light-secondary-text);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 2rem;
            color: var(--dark-tertiary-text);
            font-size: 0.9rem;
            border-top: 1px solid var(--dark-border);
            margin-top: auto;
        }

        body.light-mode footer {
            color: var(--light-tertiary-text);
            border-top-color: var(--light-border);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        body.light-mode ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
        }

        body.light-mode ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.25);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .container {
                max-width: 100%;
                padding: 1.5rem;
            }
            
            nav {
                padding: 0 1.5rem;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 0 1rem;
                height: 64px;
            }

            .main-wrapper {
                padding-top: 64px;
            }

            .logo {
                font-size: 1.5rem;
            }

            .nav-links {
                display: none;
            }

            .nav-controls {
                gap: 0.75rem;
            }

            .cta-button {
                padding: 0.6rem 1.25rem;
                font-size: 0.875rem;
            }

            .container {
                padding: 1rem;
                gap: 1.5rem;
            }

            .blueprint-title {
                font-size: 2rem;
            }

            .blueprint-subtitle {
                font-size: 1rem;
            }

            .action-bar {
                padding: 1rem;
                flex-direction: column;
                align-items: stretch;
            }

            .accordion-header {
                padding: 1rem 1.5rem;
            }

            .accordion-title {
                font-size: 1.125rem;
                gap: 0.75rem;
            }

            .accordion-icon {
                width: 28px;
                height: 28px;
                font-size: 14px;
            }

            .accordion-inner {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0.75rem;
            }

            .action-bar {
                padding: 0.75rem;
            }

            .accordion-header {
                padding: 0.875rem 1rem;
            }

            .accordion-inner {
                padding: 1rem;
            }

            .theme-toggle {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus styles */
        button:focus-visible,
        a:focus-visible,
        .accordion-header:focus-visible {
            outline: 2px solid var(--gradient-end);
            outline-offset: 2px;
        }

        body.light-mode button:focus-visible,
        body.light-mode a:focus-visible,
        body.light-mode .accordion-header:focus-visible {
            outline-color: var(--gradient-start);
        }

        /* Print Styles */
        @media print {
            nav, .action-bar, footer {
                display: none !important;
            }
            
            .main-wrapper {
                padding-top: 0 !important;
            }
            
            .accordion-content {
                max-height: none !important;
                overflow: visible !important;
            }
            
            .accordion-header {
                background: transparent !important;
            }
            
            body {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</head>
<body>
    <nav role="navigation">
        <div class="logo">
            <a href="index.php" aria-label="EnvisionFlow Home">EnvisionFlow</a>
        </div>
        <ul class="nav-links">
            <li><a href="index.php#how-it-works">How It Works</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#blueprint">Blueprint</a></li>
        </ul>
        <div class="nav-controls">
            <a href="index.php" class="cta-button secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                    <path d="M2 17l10 5 10-5"/>
                    <path d="M2 12l10 5 10-5"/>
                </svg>
                New Blueprint
            </a>
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme" title="Toggle light/dark mode">
                <svg id="sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                <svg id="moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: none;">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="container">
            <div class="blueprint-header">
                <h1 class="blueprint-title" id="blueprint-title">AI Generated Blueprint</h1>
                <p class="blueprint-subtitle">Your comprehensive business plan, generated by AI and ready to guide your journey.</p>
            </div>

            <div class="action-bar">
                <a href="export_blueprint.php?format=pdf" class="cta-button" id="exportPdfBtn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10,9 9,9 8,9"/>
                    </svg>
                    Download PDF
                </a>
                <button class="cta-button secondary" onclick="window.print()" title="Print blueprint">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6,9 6,2 18,2 18,9"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="8"/>
                    </svg>
                    Print
                </button>
                <button class="cta-button secondary" onclick="shareBlueprint()" title="Share blueprint">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="18" cy="5" r="3"/>
                        <circle cx="6" cy="12" r="3"/>
                        <circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                    Share
                </button>
            </div>

            <div class="blueprint-content" id="content">
                <div class="loading-state">
                    <div class="loading-spinner"></div>
                    <p class="loading-text">Loading your blueprint...</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 EnvisionFlow — Transforming ideas into actionable plans</p>
    </footer>

    <script>
        // Global variables
        const body = document.body;
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        const contentDiv = document.getElementById('content');
        const blueprintTitle = document.getElementById('blueprint-title');

        // Section icons mapping
        const sectionIcons = {
            project_name: '🚀',
            project_description: '📝',
            executive_summary: '📊',
            market_analysis: '📈',
            target_audience: '👥',
            business_model: '💼',
            marketing_strategy: '📢',
            financial_projections: '💰',
            implementation_plan: '⚡',
            risk_analysis: '⚠️',
            team_structure: '👨‍💼',
            competitive_analysis: '🏆',
            product_development: '🛠️',
            operations_plan: '⚙️',
            funding_requirements: '💵',
            milestones: '🎯',
            timeline: '📅',
            success_metrics: '📊',
            challenges: '🚧',
            opportunities: '🌟',
            resources_needed: '📋',
            next_steps: '➡️',
            default: '📄'
        };

        // Utility functions
        function toTitleCase(str) {
            return str.replace(/_/g, ' ')
                     .replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
        }

        function getRandomId() {
            return Math.random().toString(36).substr(2, 9);
        }

        function getSectionIcon(key) {
            const lowerKey = key.toLowerCase();
            for (const [iconKey, icon] of Object.entries(sectionIcons)) {
                if (lowerKey.includes(iconKey.replace('_', ''))) {
                    return icon;
                }
            }
            return sectionIcons.default;
        }

        // Theme management
        function initTheme() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = savedTheme === 'dark' || (!savedTheme && prefersDark);
            
            if (!shouldUseDark) {
                body.classList.add('light-mode');
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            } else {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            }
        }

        function toggleTheme() {
            const isLightMode = body.classList.toggle('light-mode');
            localStorage.setItem('theme', isLightMode ? 'light' : 'dark');
            
            if (isLightMode) {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            } else {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            }
        }

        // Share functionality
        async function shareBlueprint() {
            const blueprintData = {
                title: blueprintTitle.textContent,
                url: window.location.href
            };

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: blueprintData.title,
                        text: 'Check out my AI-generated business blueprint!',
                        url: blueprintData.url
                    });
                } catch (err) {
                    console.log('Share cancelled or failed');
                }
            } else {
                // Fallback: copy to clipboard
                try {
                    await navigator.clipboard.writeText(blueprintData.url);
                    showNotification('Link copied to clipboard!', 'success');
                } catch (err) {
                    console.error('Failed to copy link:', err);
                    showNotification('Failed to copy link', 'error');
                }
            }
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                padding: 1rem 1.5rem;
                background: ${type === 'success' ? 'var(--success-color)' : 
                           type === 'error' ? 'var(--error-color)' : 'var(--info-color)'};
                color: white;
                border-radius: 12px;
                font-weight: 500;
                z-index: 10000;
                box-shadow: 0 8px 24px rgba(0,0,0,0.2);
                transform: translateX(100%);
                transition: transform 0.3s ease;
                max-width: 300px;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => notification.style.transform = 'translateX(0)', 100);
            
            // Animate out and remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => document.body.removeChild(notification), 300);
            }, 3000);
        }

        // Content creation functions
        function createAccordionSection(key, value) {
            const sectionId = getRandomId();
            const section = document.createElement('div');
            section.className = 'accordion';
            section.setAttribute('role', 'region');

            const header = document.createElement('button');
            header.className = 'accordion-header';
            header.setAttribute('aria-expanded', 'false');
            header.setAttribute('aria-controls', `content-${sectionId}`);
            header.setAttribute('id', `header-${sectionId}`);

            const title = document.createElement('div');
            title.className = 'accordion-title';
            
            const icon = document.createElement('div');
            icon.className = 'accordion-icon';
            icon.textContent = getSectionIcon(key);
            
            const titleText = document.createElement('span');
            titleText.textContent = toTitleCase(key);
            
            title.appendChild(icon);
            title.appendChild(titleText);

            const chevron = document.createElement('svg');
            chevron.className = 'accordion-chevron';
            chevron.setAttribute('width', '24');
            chevron.setAttribute('height', '24');
            chevron.setAttribute('viewBox', '0 0 24 24');
            chevron.setAttribute('fill', 'none');
            chevron.setAttribute('stroke', 'currentColor');
            chevron.setAttribute('stroke-width', '2');
            chevron.innerHTML = '<polyline points="6,9 12,15 18,9"></polyline>';

            header.appendChild(title);
            header.appendChild(chevron);

            const content = document.createElement('div');
            content.className = 'accordion-content';
            content.setAttribute('id', `content-${sectionId}`);
            content.setAttribute('aria-labelledby', `header-${sectionId}`);

            const inner = document.createElement('div');
            inner.className = 'accordion-inner';

            // Handle different data types
            if (typeof value === 'string') {
                const text = document.createElement('p');
                text.className = 'content-text';
                text.textContent = value;
                inner.appendChild(text);
            } else if (Array.isArray(value)) {
                const list = document.createElement('ul');
                list.className = 'content-list';
                
                value.forEach(item => {
                    const listItem = document.createElement('li');
                    
                    const bullet = document.createElement('div');
                    bullet.className = 'list-bullet';
                    
                    const itemContent = document.createElement('div');
                    itemContent.className = 'list-content';
                    itemContent.textContent = typeof item === 'string' ? item : JSON.stringify(item);
                    
                    listItem.appendChild(bullet);
                    listItem.appendChild(itemContent);
                    list.appendChild(listItem);
                });
                
                inner.appendChild(list);
            } else if (typeof value === 'object' && value !== null) {
                // Handle nested objects
                Object.entries(value).forEach(([subKey, subValue]) => {
                    const subSection = createAccordionSection(subKey, subValue);
                    inner.appendChild(subSection);
                });
            } else {
                const text = document.createElement('p');
                text.className = 'content-text';
                text.textContent = value ? value.toString() : 'No data available';
                inner.appendChild(text);
            }

            content.appendChild(inner);

            // Event handlers
            function toggleAccordion() {
                const isActive = header.classList.contains('active');
                
                if (isActive) {
                    header.classList.remove('active');
                    content.classList.remove('active');
                    chevron.classList.remove('active');
                    header.setAttribute('aria-expanded', 'false');
                } else {
                    header.classList.add('active');
                    content.classList.add('active');
                    chevron.classList.add('active');
                    header.setAttribute('aria-expanded', 'true');
                }
            }

            header.addEventListener('click', toggleAccordion);
            header.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleAccordion();
                }
            });

            section.appendChild(header);
            section.appendChild(content);
            
            return section;
        }

        function renderBlueprint(data) {
            if (!data || typeof data !== 'object') {
                showErrorState('Invalid blueprint data format');
                return;
            }

            contentDiv.innerHTML = '';
            
            // Update title if project name exists
            if (data.project_name) {
                blueprintTitle.textContent = data.project_name;
                document.title = `${data.project_name} - EnvisionFlow Blueprint`;
            }

            // Create accordion sections
            Object.entries(data).forEach(([key, value], index) => {
                if (key === 'project_name') return; // Skip project name as it's in the title
                
                const section = createAccordionSection(key, value);
                
                // Add staggered animation
                section.style.animationDelay = `${index * 0.1}s`;
                section.style.opacity = '0';
                section.style.animation = 'slideInUp 0.6s ease-out forwards';
                
                contentDiv.appendChild(section);
            });

            // Auto-expand first section
            setTimeout(() => {
                const firstHeader = contentDiv.querySelector('.accordion-header');
                if (firstHeader) {
                    firstHeader.click();
                }
            }, 800);
        }

        function showErrorState(message = 'No blueprint data found') {
            contentDiv.innerHTML = `
                <div class="error-state">
                    <div class="error-icon">⚠️</div>
                    <h2 class="error-title">Oops! Something went wrong</h2>
                    <p class="error-message">${message}</p>
                    <a href="index.php" class="cta-button">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        Go Home
                    </a>
                </div>
            `;
        }

        // Keyboard shortcuts
        function initKeyboardShortcuts() {
            document.addEventListener('keydown', (e) => {
                // Ctrl/Cmd + P for print
                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                    e.preventDefault();
                    window.print();
                }
                
                // Ctrl/Cmd + S for share/save
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    shareBlueprint();
                }
                
                // Escape to close any open accordions
                if (e.key === 'Escape') {
                    const activeHeaders = document.querySelectorAll('.accordion-header.active');
                    activeHeaders.forEach(header => header.click());
                }
                
                // Space or Enter to expand/collapse focused accordion
                if ((e.key === ' ' || e.key === 'Enter') && e.target.classList.contains('accordion-header')) {
                    e.preventDefault();
                    e.target.click();
                }
            });
        }

        // Initialize everything
        function init() {
            // Initialize theme
            initTheme();
            
            // Add event listeners
            themeToggle.addEventListener('click', toggleTheme);
            
            // Initialize keyboard shortcuts
            initKeyboardShortcuts();
            
            // Load blueprint data
            const blueprintData = <?php echo json_encode($blueprintData); ?>;
            const error = "<?php echo addslashes($error ?? ''); ?>";
            
            if (blueprintData && typeof blueprintData === 'object') {
                // Add a small delay for better UX
                setTimeout(() => {
                    renderBlueprint(blueprintData);
                }, 1000);
            } else {
                setTimeout(() => {
                    showErrorState(error || 'No blueprint data found. Please create a new blueprint.');
                }, 1000);
            }
        }

        // Handle page visibility changes
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                // Re-focus the page when it becomes visible
                document.body.focus();
            }
        });

        // Handle online/offline status
        window.addEventListener('online', () => {
            showNotification('Connection restored', 'success');
        });

        window.addEventListener('offline', () => {
            showNotification('Connection lost', 'error');
        });

        // Start the application when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    </script>
</body>
</html>