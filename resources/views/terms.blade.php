<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Terms of Service - {{ config('app.name') }}</title>
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
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Terms of Service</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Last updated: October 5, 2025</p>

                <div class="prose prose-slate mt-8 max-w-none dark:prose-invert">
                    <h2>Agreement to Terms</h2>
                    <p>
                        By accessing or using FourPaws, you agree to be bound by these Terms of Service and all applicable laws and regulations. If you do not agree with any of these terms, you are prohibited from using our services.
                    </p>

                    <h2>Use License</h2>
                    <p>
                        Permission is granted to temporarily use FourPaws for personal, non-commercial memorial purposes. This license shall automatically terminate if you violate any of these restrictions.
                    </p>

                    <h2>User Content</h2>
                    <h3>Your Responsibilities</h3>
                    <p>You are responsible for the content you upload and share, including:</p>
                    <ul>
                        <li>Memorial information and descriptions</li>
                        <li>Photos and media files</li>
                        <li>Tributes and comments</li>
                    </ul>

                    <h3>Content Guidelines</h3>
                    <p>You agree not to post content that:</p>
                    <ul>
                        <li>Is illegal, harmful, or offensive</li>
                        <li>Violates intellectual property rights</li>
                        <li>Contains viruses or malicious code</li>
                        <li>Harasses or harms others</li>
                        <li>Is spam or misleading</li>
                    </ul>

                    <h3>Content License</h3>
                    <p>
                        By uploading content, you grant FourPaws a worldwide, non-exclusive, royalty-free license to use, display, and distribute your content solely for the purpose of providing our memorial services.
                    </p>

                    <h2>Memorial Pages</h2>
                    <h3>Creation and Management</h3>
                    <p>
                        You may create memorial pages for pets you have the right to memorialize. You are responsible for managing your memorial pages, including moderating tributes if enabled.
                    </p>

                    <h3>Duration</h3>
                    <p>
                        Memorial pages remain active indefinitely unless you request deletion or violate these terms. We reserve the right to remove content that violates our policies.
                    </p>

                    <h2>Privacy and Data</h2>
                    <p>
                        Your use of FourPaws is also governed by our Privacy Policy. Please review our Privacy Policy to understand how we collect and use your information.
                    </p>

                    <h2>Prohibited Uses</h2>
                    <p>You may not use FourPaws to:</p>
                    <ul>
                        <li>Violate any laws or regulations</li>
                        <li>Infringe on intellectual property rights</li>
                        <li>Transmit harmful code or malware</li>
                        <li>Attempt unauthorized access to our systems</li>
                        <li>Interfere with other users' experience</li>
                        <li>Use automated tools without permission</li>
                    </ul>

                    <h2>Disclaimer</h2>
                    <p>
                        FourPaws is provided "as is" without warranties of any kind. We do not guarantee that our services will be uninterrupted, secure, or error-free.
                    </p>

                    <h2>Limitation of Liability</h2>
                    <p>
                        To the maximum extent permitted by law, FourPaws shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of our services.
                    </p>

                    <h2>Indemnification</h2>
                    <p>
                        You agree to indemnify and hold FourPaws harmless from any claims, damages, or expenses arising from your use of our services or violation of these terms.
                    </p>

                    <h2>Termination</h2>
                    <p>
                        We may terminate or suspend your account and access to our services immediately, without prior notice, for conduct that we believe violates these Terms of Service or is harmful to other users, us, or third parties.
                    </p>

                    <h2>Changes to Terms</h2>
                    <p>
                        We reserve the right to modify these terms at any time. We will notify users of any material changes. Your continued use of FourPaws after changes constitutes acceptance of the new terms.
                    </p>

                    <h2>Governing Law</h2>
                    <p>
                        These terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law provisions.
                    </p>

                    <h2>Contact Information</h2>
                    <p>
                        If you have questions about these Terms of Service, please contact us at legal@fourpaws.example.com.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
