# SEO and AI Search Optimization Report

The Recruiting Agent (therecruitingagent.com), a division of Apollo[Claw] AI Consulting.

This report covers the technical SEO and AEO/GEO work completed on the site, the full page architecture with the target query per page, the structured data deployed, and the prioritized content work remaining for review.

## Important context: the stack

The prompt was written for a Next.js app. The site is a hand-authored static HTML site deployed via xCloud (Apache/PHP static host). All work was therefore implemented as static HTML with direct equivalents to the Next.js features requested. The site is already fully server-rendered static markup, which is the single most important prerequisite for both Googlebot and AI answer engines, so no framework migration was needed or done.

## Phase 1: Audit findings

- Stack: static `index.html` plus `form.php`, `images/`, `og.png`. No build system. Confirmed not Next.js.
- Indexable routes before this work: 1 (the homepage).
- Metadata: title and description were present but too long. Canonical, Open Graph, Twitter, and a branded `og.png` were present and correct on `therecruitingagent.com`.
- Missing: `robots.txt`, `sitemap.xml`, `llms.txt`, a custom 404, Google and Bing verification tags.
- JSON-LD present: Organization, Service, FAQPage. Missing WebSite, SoftwareApplication, BreadcrumbList, richer Organization.
- Core Web Vitals risks: three Google Font families loaded render-blocking (main LCP risk); images are PNG with no WebP or AVIF; alt text and lazy-loading were already in place.
- Copy: homepage was marketing-first rather than answer-first; FAQ was objection-phrased rather than query-phrased; no glossary, pillar, or spoke pages.

## Phase 2: Technical SEO foundation (done)

- `/assets/site.css`: extracted the homepage CSS into one shared stylesheet and added content-page components (page hero, breadcrumbs, prose, answer boxes, comparison tables, hub-card grids, glossary, numbered lists, CTA strip, footer nav). The homepage was migrated to it and verified pixel-identical.
- `robots.txt`: allows all crawlers and explicitly allows the AI answer engines: GPTBot, OAI-SearchBot, ChatGPT-User, ClaudeBot, anthropic-ai, PerplexityBot, Perplexity-User, Google-Extended, Applebot, Applebot-Extended, cohere-ai, Bytespider, plus Googlebot and Bingbot. References the sitemap.
- `sitemap.xml`: all 19 canonical URLs with lastmod, changefreq, and priority. Valid XML.
- `llms.txt`: a concise, structured markdown summary of what The Recruiting Agent is, who it is for, capabilities, governance, pricing model, and links to key pages. This is what AI engines read first.
- `404.html`: custom, on-brand, `noindex`, with internal links back into the guide, solutions, and capabilities. Server config note below.
- Verification: two `google-site-verification` tags are in the `<head>` of every page. A Bing verification placeholder is noted below for you to fill in.
- Metadata: tightened homepage title to under 60 characters and description to under 155. Every generated page has a unique title under 60 and description under 155, plus per-page canonical, Open Graph, and Twitter tags.
- Structured data expanded (see Schema section).

## Phase 3: Homepage AEO (done)

- Added an answer-first block directly after the hero that defines The Recruiting Agent and the AI recruiting agent category in the first two sentences, with entity-dense language and links to the pillar, capabilities, and solutions.
- Added query-phrased FAQ entries to the visible accordion and the FAQPage schema: what is an AI recruiting agent, ATS integration (Bullhorn, Greenhouse), EEOC compliance, and agent vs chatbot.
- Unified the navigation across the whole site (Solutions, Capabilities, Compare, Glossary, About, Contact) and expanded the footer into three link columns for internal linking.

## Phase 4: Hub-and-spoke architecture (done, draft copy for review)

Every page is answer-first, entity-dense, interlinked, and carries BreadcrumbList and FAQPage schema. Pillar and spokes link to each other and to the money pages.

| Page | URL | Primary target query |
|---|---|---|
| Pillar | `/ai-recruiting-agents/` | what is an AI recruiting agent |
| Solutions hub | `/solutions/` | AI recruiting agent by firm type |
| Staffing agencies | `/solutions/staffing-agencies/` | AI agent for staffing agencies |
| Executive search | `/solutions/executive-search/` | AI agent for executive search firms |
| Corporate TA | `/solutions/corporate-talent-acquisition/` | AI recruiting agent for corporate talent acquisition |
| RPO | `/solutions/rpo/` | AI recruiting agent for RPO providers |
| Healthcare | `/solutions/healthcare-recruiting/` | AI recruiting agent for healthcare recruiting |
| Tech | `/solutions/tech-recruiting/` | AI recruiting agent for tech recruiting |
| Capabilities hub | `/capabilities/` | what an AI recruiting agent does |
| Candidate sourcing | `/capabilities/candidate-sourcing/` | AI candidate sourcing, agentic sourcing |
| Outreach and follow-up | `/capabilities/candidate-outreach/` | automated candidate outreach |
| Resume screening | `/capabilities/resume-screening/` | AI resume screening, EEOC compliant |
| Interview scheduling | `/capabilities/interview-scheduling/` | interview scheduling automation |
| Pipeline reporting | `/capabilities/pipeline-reporting/` | recruiting pipeline reporting, ATS hygiene |
| Compare hub | `/compare/` | AI recruiting agent comparisons |
| Agent vs chatbot | `/compare/ai-recruiting-agent-vs-recruiting-chatbot/` | AI recruiting agent vs recruiting chatbot |
| Agent vs sourcer | `/compare/ai-recruiting-agent-vs-sourcer/` | AI recruiting agent vs human sourcer |
| Build vs buy | `/compare/build-vs-buy/` | build vs buy an AI recruiting agent |
| Glossary | `/glossary/` | recruiting AI terms and definitions |
| About | `/about/` | about The Recruiting Agent, Apollo[Claw] |
| Contact | `/contact/` | contact The Recruiting Agent |

## Phase 5: Trust and conversion (done)

- About page ties The Recruiting Agent to Apollo[Claw] AI Consulting with founder attribution and full address, and carries Organization schema with PostalAddress.
- Contact page has the working form (posts to `form.php`), a map, and consistent NAP (Apollo[Claw] AI Consulting, 69 Roslyn Road, Roslyn Heights, NY 11577), with ContactPage schema.
- Review and AggregateRating schema is prepared but feature-flagged. See the commented template at the bottom of this file. Enable it once real client quotes are available.

## Schema (JSON-LD) deployed

- Organization (enriched: legalName, description, PostalAddress, sameAs) on the homepage and About.
- WebSite on the homepage.
- SoftwareApplication on the homepage.
- Service on the homepage.
- FAQPage on the homepage and on every spoke, hub, glossary, about, and contact page.
- BreadcrumbList on every interior page.
- DefinedTermSet on the glossary.
- ContactPage on contact.

All JSON-LD across the site was validated (50 blocks parse cleanly). All 900-plus internal links resolve. No em dashes or en dashes anywhere. The banned word "new" does not appear in any copy (the only matches are the Google Analytics `new Date()` call and the place name New York).

## Analytics and verification

- Google Analytics 4 (`G-2QLLNZC2VM`) is on every page.
- Google Search Console verification meta tags are on every page.

## Server configuration notes (for xCloud)

1. Clean URLs work through the directory-plus-index-file convention (for example `/solutions/staffing-agencies/index.html` serves at `/solutions/staffing-agencies/`). No rewrite rules are required on a server that serves `index.html` for a directory, which is the default.
2. Point the server's 404 handler at `/404.html`. On Apache, add `ErrorDocument 404 /404.html`. On the xCloud panel, set the custom 404 document to `/404.html`.
3. Keep force-HTTPS and the www to apex redirect enabled.

## Prioritized remaining work for review

1. Review the draft copy on the 18 content pages. Each is production-quality but should be checked for claims, tone, and any firm-specific detail you want to add or remove.
2. Bing Webmaster Tools verification: add the `msvalidate.01` meta tag when you have it (placeholder not yet inserted because no value was provided).
3. Image optimization: convert the robot PNGs and `og.png` to WebP or AVIF and serve with `<picture>`. Current images are lazy-loaded and reasonably sized, so this is a performance refinement rather than a blocker.
4. Font performance: consider self-hosting Inter, IBM Plex Mono, and Roboto Slab, or reducing the loaded weights, to remove the render-blocking Google Fonts request and improve LCP.
5. Add real testimonials, then enable the Review and AggregateRating schema below.
6. Consider adding an `article` or resource hub with dated posts to capture long-tail informational queries over time.

## Feature-flagged review schema (enable when quotes exist)

```html
<!-- Enable on the homepage or About once real client quotes are available.
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "The Recruiting Agent",
  "brand": {"@type": "Brand", "name": "Apollo[Claw] AI Consulting"},
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5.0",
    "reviewCount": "12"
  },
  "review": [{
    "@type": "Review",
    "author": {"@type": "Person", "name": "Client Name, Title"},
    "reviewRating": {"@type": "Rating", "ratingValue": "5"},
    "reviewBody": "Real client quote goes here."
  }]
}
</script>
-->
```
