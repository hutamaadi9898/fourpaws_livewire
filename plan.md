# FourPaws Pet Memorial Roadmap

## Product Vision

-   Provide a self-service pet memorial builder that spins up branded subdomains like fourpaws.studio/anne with minimal friction.
-   Offer a high-converting marketing site that showcases the product, ranks well for grief support keywords, and drives signups.
-   Empower internal teams with Filament-based tooling to manage memorials, customers, and content safely.
-   Leverage Livewire 3 for interactive memorial experiences, Filament v4 for admin, Alpine.js for micro-interactions, and Tailwind CSS v4 for fast, accessible design iteration.

## Technical Guardrails

-   Use Laravel 12 with PHP 8.4.11, Livewire 3, Filament v4, Alpine.js, Tailwind CSS v4, and PostgreSQL 17 as the core stack.
-   Keep memorial pages server-rendered with standard Livewire components for SEO while layering interactive features for personalization.
-   Apply Filament v4 for all internal-facing admin experiences; extend with custom resources instead of ad-hoc dashboards.
-   Enforce consistent tenants through slugged subdomains and optional custom domains backed by HTTPS via a certificate automation job.
-   Favor queueable jobs for image processing, email dispatch, and background sync (Redis queue + Horizon or equivalent).
-   Maintain automated testing with Pest 4; cover Livewire components using Livewire::test() and Filament resources with livewire().
-   Format PHP with vendor/bin/pint --dirty and keep npm dependencies aligned with Tailwind v4 expectations.

## Multi-Tenant Memorial Architecture

-   Data model core tables: memorials (uuid, slug, title, story, theme, visibility, published_at), pets, tributes, media_assets, users, plans, orders, domains (custom domain mapping), memorial_settings (JSONB per memorial).
-   Postgres 17 features: use generated columns for search, trigram or full text indexes for tribute search, row level policies if multi-tenant isolation is required later.
-   Routing: configure wildcard subdomain in routes/web.php (tenant route group) and fallback route for marketing pages; consider Route model binding on slug and guard 404s.
-   File storage: memorial uploads via S3 (private visibility) with signed URLs; generate optimized variants and store references in media_assets.
-   Theming: define Tailwind theme tokens stored in JSONB for each memorial and hydrate Livewire components accordingly.

## Landing and Marketing Foundations

-   Build a Livewire-driven landing page with hero, feature grid, testimonials, pricing, and FAQs using Tailwind v4 design tokens.
-   Implement SEO essentials: meta tags, structured data (Organization, Product), Open Graph, Twitter Cards, XML sitemap, robots.txt.
-   Add a blog or resource hub using standard Laravel routes to target grief and memorial keywords (optional MVP+).
-   Integrate analytics (Plausible or GA4) and conversion tracking for trial signups.

## Admin and Internal Tooling

-   Create a dedicated Filament panel (AppPanelProvider) restricted to staff SSO or email+password with 2FA.
-   Resources: MemorialResource, TributeResource, UserResource, OrderResource, ContentBlockResource.
-   Actions: Approve tribute, Feature memorial on landing, Export memorial PDF, Trigger email sequences.
-   Dashboards: daily signups, active memorials, revenue, churn, uptime alerts.
-   Use Filament notifications to alert staff when new tributes need moderation.

## Phase 0 (Weeks 0-2) Discovery & Platform Setup

### Goals

-   Confirm core product requirements, audience, and tone.
-   Stand up the baseline Laravel stack, environment automation, and development workflow.

### Tasks

-   Requirement synthesis workshops; capture personas (pet owner, admin, support).
-   Set up repository secrets, environment configuration, Postgres provisioning (Dev/Stage/Prod), and S3 buckets.
-   Install Livewire 3, Filament v4, Tailwind v4, Pest; verify integration via smoke tests.
-   Configure CI (GitHub Actions) for test, lint, Pint, npm build, deploy previews.
-   Create base layout Blade templates with Tailwind imports and Livewire layouts.
-   Define domain wildcard strategy with Herd/nginx and document DNS expectations.
-   Draft ERD and migration stubs (memorials, pets, tributes, media, users, plans, orders).
-   Establish coding standards (naming, folder structure), component library for reusable Livewire components.
-   Prototype landing page wireframes and memorial page layout in low fidelity.

### Exit Criteria

-   CI pipeline green, base stacks installed, migrations stubbed, design wireframes approved, domain strategy documented.

## Phase 1 (Weeks 3-6) MVP Beta

### Goals

-   Allow invited users to create memorials on unique slugs and share them privately.
-   Launch a functional marketing landing page with waitlist capture.

### Features

-   Memorial creation wizard (Livewire component) with steps for pet info, story, media upload (temporary S3), theme selection, preview.
-   Public memorial page: hero, gallery (carousel lightbox), timeline tributes, guestbook (pending moderation), share CTA.
-   Tribute submission form with email verification, moderation queue, optional scheduled publish.
-   Landing page sections: hero with CTA, feature list, testimonials, pricing teaser, waitlist form integrated with email marketing provider.
-   Basic analytics dashboards (daily memorial creation) using Filament widgets.
-   Email notifications: memorial published, tribute submitted, moderation required (queued jobs + Markdown templates).

### Technical

-   Subdomain routing: middleware to resolve memorial by slug, fallback to landing page for root domain.
-   Secure file uploads: use Livewire file uploads with temporary signed URLs, scan for size/type.
-   Rate limiting on tribute submissions (Laravel rate limiter) and hCaptcha integration.
-   SEO: static metadata for landing page, canonical tags, minimal schema.
-   Accessibility sweep: keyboard navigation, color contrast adherence via Tailwind tokens.
-   Tests: Pest feature coverage for memorial creation flow, Livewire component tests using Livewire::test(), Filament resource tests, smoke tests for landing page.

### Admin

-   Filament resources for Memorials and Tributes with moderation flow and quick actions.
-   Role-based access (Filament Shield or policies) for staff vs support roles.

### Exit Criteria

-   Beta cohort can create memorials, share preview URLs, admins moderate tributes, landing page collects waitlist signups, test suite passing.

## Phase 2 (Weeks 7-12) Version 1.0 Public Launch

### Goals

-   Open self-service memorial creation with payments and public discoverability.

### Enhancements

-   Subscription or one-time purchase flow using Cashier, Paddle, or Stripe; tie plan to memorial features (custom domain, extra storage).
-   Custom domain linking: DNS verification, auto certificate provisioning (ACME client), redirect handling.
-   Memorial templates: additional themes, typography and layout presets stored per memorial.
-   Advanced SEO: dynamic meta tags per memorial, JSON-LD for memorial event, sitemap generation, server-side social images.
-   Landing page: pricing table with plan comparison, case studies, FAQ accordions, press kit.
-   Content hub/blog with Filament-managed markdown posts or standard Blade views.
-   Integrations: CRM or webhook when new memorial created, Slack alert for support team.
-   Performance: optimize database indexes, implement HTTP caching headers, use Horizon for queue monitoring.
-   QA: cross-browser testing, Lighthouse performance budget, load test memorial page.

### Admin

-   Revenue dashboard, churn tracking, support tools (impersonate user, resend emails).
-   Audit log for admin actions (Laravel Auditing or custom model events).

### Exit Criteria

-   Payments live, custom domains functional, landing page ready for paid marketing, performance budgets met, support tooling in place.

## Phase 3 (Weeks 13-20) Version 2.0 Growth

### Goals

-   Enhance personalization, community features, and retention loops.

### Features

-   AI-assisted story drafting using queued integration with external LLM and user approval workflow.
-   Memory timeline: allow owners to add milestones with photos, video embeds, and map locations.
-   Collaborative editing with invited caretakers (multi-user memorial roles).
-   Advanced tribute interactions: reactions, shareable tribute cards, memorial anniversary reminders.
-   Gift store integration (merchandise, donation links) managed through Filament catalog.
-   Mobile responsiveness refinements with Tailwind component library extraction and dark mode toggle.
-   Accessibility audit with external review and remediation backlog.
-   Internationalization: localization of memorial content and UI, multi-currency pricing.
-   Marketing: referral program, affiliate tracking, expanded blog and downloadable guides.

### Data & Analytics

-   Cohort analysis dashboards, funnel tracking, automated churn emails.
-   Data warehouse export (BigQuery or Postgres replica) with nightly sync.

### Exit Criteria

-   Users engage with collaborative and AI features, retention metrics improve, international beta live.

## Phase 4 (21+ Weeks) Version 3.0 and Beyond

-   Mobile app wrapper or PWA with offline tribute drafting.
-   Marketplace for memorial designers to submit theme packs reviewed via Filament workflow.
-   Public memorial directory with search filters and recommendation engine.
-   Partner API for vets and shelters to auto-provision memorials.
-   Endowment fund for donations with transparency dashboard and payout workflows.
-   Advanced personalization (voice memories, AR markers) and archival exports (print-ready books).

## Continuous Workstreams

-   DevOps: infrastructure as code, blue-green deploys, automated backups, disaster recovery drills.
-   Security: quarterly pen tests, dependency scanning, SSO for admin, enhanced logging with retention policies.
-   Customer support: knowledge base, in-app onboarding tours, ticketing integration.
-   Compliance: GDPR/CCPA readiness, data retention controls, cookie consent banner.
-   Observability: metrics via Laravel Pulse, log aggregation, uptime monitoring.

## KPIs & Reporting

-   Acquisition: landing page conversion rate, cost per acquisition, waitlist to paid conversion.
-   Activation: time to publish memorial, number of tributes per memorial in first week.
-   Engagement: repeat visits, average tributes, photo uploads, collaborative editors added.
-   Revenue: MRR, ARPU, churn, LTV, add-on attach rate.
-   Reliability: uptime, API error rate, queue latency, page load metrics (LCP, CLS, TBT).

## Documentation & Next Steps

-   Maintain living product spec in productivity suite, referencing this roadmap.
-   Prioritize backlog items using RICE scoring per phase.
-   Schedule user interviews post-MVP to validate roadmap assumptions.
-   Before coding, confirm design system tokens and component inventory aligned with Tailwind v4 naming.
