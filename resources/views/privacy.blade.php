<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Privacy Policy - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-slate-50 py-12 dark:bg-slate-900">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('landing') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                    ← Back to Home
                </a>
            </div>

            <div class="rounded-lg bg-white p-8 shadow dark:bg-slate-800">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Privacy Policy</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Last updated: October 5, 2025</p>

                <div class="prose prose-slate mt-8 max-w-none dark:prose-invert">
                    <h2>Introduction</h2>
                    <p>
                        FourPaws ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our memorial services.
                    </p>

                    <h2>Information We Collect</h2>
                    <h3>Personal Information</h3>
                    <p>We may collect personal information that you provide to us, including:</p>
                    <ul>
                        <li>Name and email address</li>
                        <li>Information about your pet (name, species, breed, dates)</li>
                        <li>Photos and media you upload</li>
                        <li>Memorial content and tributes</li>
                    </ul>

                    <h3>Automatically Collected Information</h3>
                    <p>When you access our services, we may automatically collect:</p>
                    <ul>
                        <li>IP address and browser information</li>
                        <li>Device and usage data</li>
                        <li>Cookies and similar tracking technologies</li>
                    </ul>

                    <h2>How We Use Your Information</h2>
                    <p>We use the information we collect to:</p>
                    <ul>
                        <li>Provide and maintain our memorial services</li>
                        <li>Create and display memorial pages</li>
                        <li>Communicate with you about your account</li>
                        <li>Improve our services and user experience</li>
                        <li>Ensure security and prevent fraud</li>
                    </ul>

                    <h2>Data Sharing and Disclosure</h2>
                    <p>
                        We do not sell your personal information. We may share your information only in the following circumstances:
                    </p>
                    <ul>
                        <li>With your consent</li>
                        <li>To comply with legal obligations</li>
                        <li>To protect our rights and safety</li>
                        <li>In connection with a business transfer</li>
                    </ul>

                    <h2>Data Security</h2>
                    <p>
                        We implement appropriate technical and organizational measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.
                    </p>

                    <h2>Your Rights</h2>
                    <p>You have the right to:</p>
                    <ul>
                        <li>Access your personal information</li>
                        <li>Correct inaccurate information</li>
                        <li>Request deletion of your information</li>
                        <li>Object to processing of your information</li>
                        <li>Export your data</li>
                    </ul>

                    <h2>Children's Privacy</h2>
                    <p>
                        Our services are not intended for children under 13. We do not knowingly collect information from children under 13.
                    </p>

                    <h2>Changes to This Policy</h2>
                    <p>
                        We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.
                    </p>

                    <h2>Contact Us</h2>
                    <p>
                        If you have questions about this Privacy Policy, please contact us at privacy@fourpaws.example.com.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
