# The Recruiting Agent

Marketing site for **The Recruiting Agent** (recruitingagent.com), an Apollo[Claw] LLC product: a dedicated AI agent deployed for search firm owners, staffing agency principals, and corporate talent acquisition leaders.

## Structure

- `index.html` — the complete single-page site (all ten sections, header, footer, SEO metadata, and JSON-LD). Static and self-contained; the only external requests are Google Fonts (Inter and IBM Plex Mono).
- `apolloclaw/the-recruiting-agent.html` — product card page to deploy on apolloclaw.ai at `/the-recruiting-agent`, linking out to recruitingagent.com.
- `form.php` — optional server-side handler for a discovery-call request form, delivering via Mandrill. The live page uses a Calendly link for the primary call-to-action, so this is only needed if a contact form is added later. Requires the `MANDRILL_API_KEY` environment variable.

## Design system

Matches the Apollo[Claw] agent-site system (theceoagent.ai). Red `#D72B2B` accent throughout. Dark navy hero and feature bands (`radial-gradient` from `#11182b` to `#03060e`) with a masked grid backdrop, cream content sections (`#F2F0EB` / `#FFFDF8`) with near-black text (`#0a0c19`) and red-accented cards, dark final CTA band and footer. Roboto Slab for the "The Recruiting [Agent]" wordmark (red brackets), Inter for headings and body, IBM Plex Mono for eyebrows, section labels, timestamps, and stats. No scroll animations or parallax.

## Deploy

Static hosting (xCloud push-to-deploy). Serve `index.html` at the root of recruitingagent.com.

Before launch:
- Confirm the Calendly URL in `index.html` (`https://calendly.com/therealdaveo/apolloai`).
- Add `og.png` at the site root for the Open Graph share image.
- Replace the styled text wordmark with the final logo asset when available.

---

© 2026 Apollo[Claw] LLC. All rights reserved.
