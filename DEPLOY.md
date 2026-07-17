# Deploy runbook: therecruitingagent.com

Static single-page site served from this repo. Deployed via xCloud push-to-deploy, DNS at the domain registrar for therecruitingagent.com.

## Source of truth

- **Repo:** `doralevich/the-recruiting-agent` (private)
- **Branch:** `main`
- **Web root:** repository root (serve `index.html` at `/`)
- **Canonical host:** `https://therecruitingagent.com` (apex; `www` should redirect to apex)
- **Runtime:** static HTML. PHP is only needed if the optional `form.php` contact handler is wired up later; the live page uses a Calendly link for its call-to-action, so PHP is not required for launch.

## 1. xCloud: create the site

1. In xCloud, add a site/application for **therecruitingagent.com** on the target server.
2. Site type: **static site** (or PHP site if you want `form.php` active; either serves the static `index.html` fine).
3. Connect the Git source: provider **GitHub**, repository **doralevich/the-recruiting-agent**, branch **main**.
4. Set the web/document root to the **repository root**.
5. Enable **auto-deploy on push** to `main` so future commits redeploy automatically.
6. Trigger the first deploy.
7. Note the server's **public IP address** from the xCloud panel; DNS needs it in step 2.

## 2. DNS: point the domain at xCloud

At the registrar / DNS host for **therecruitingagent.com**, set:

| Type  | Name / Host | Value                        | Notes |
|-------|-------------|------------------------------|-------|
| A     | `@`         | `<xCloud server IP>`         | apex domain |
| A     | `www`       | `<xCloud server IP>`         | or a CNAME to `therecruitingagent.com` if the DNS host supports CNAME flattening at the apex |

Remove any conflicting existing A / AAAA / parking records on `@` and `www`. Keep TTL low (e.g. 300s) during cutover.

## 3. SSL

After DNS resolves to the xCloud server (allow up to a few hours for propagation), issue a **Let's Encrypt** certificate in xCloud for both `therecruitingagent.com` and `www.therecruitingagent.com`. Enable **force HTTPS** and set the `www` to apex redirect.

## 4. Optional: contact form handler

Only if `form.php` is used later:
- Set the environment variable **`MANDRILL_API_KEY`** on the site.
- The handler emails `david@apolloclaw.ai` and also appends to `form-submissions.log` (already gitignored).

## 5. Post-deploy verification

- [ ] `https://therecruitingagent.com` loads with a valid SSL padlock
- [ ] `https://www.therecruitingagent.com` redirects to the apex
- [ ] "Book a Discovery Call" opens the Calendly link in a new tab
- [ ] Mobile at 375px and desktop at 1280px both render cleanly
- [ ] No console errors
- [x] `og.png` is present at the site root (used by Open Graph)

## Pre-launch content notes

- Confirm the Calendly URL in `index.html` (`https://calendly.com/therealdaveo/apolloai`).
- og.png is in place at the repository root for the social share image.
- Swap the styled text wordmark for the final logo asset when available.
