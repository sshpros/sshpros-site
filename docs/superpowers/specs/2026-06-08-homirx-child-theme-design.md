# Homirx Child Theme Design

**Date:** 2026-06-08
**Goal:** Replace Elementor-built pages with plain PHP templates in a child theme, eliminating the Elementor Pro dependency and improving performance and code maintainability.

---

## Background

The live sshpros.com WordPress site uses the Homirx theme with Elementor Pro. 43 published pages are built with Elementor, meaning their layouts are stored as JSON in the database — not in version-controlled files. The goal is to move all layout and styling into PHP template files and CSS that can be edited directly and tracked in git.

A child theme is the first step. A full custom theme is the long-term goal.

---

## Architecture

A WordPress child theme `homirx-child` inherits all Homirx parent styles and PHP logic, then selectively overrides templates and adds new ones. Elementor remains installed but inactive once all 43 pages are migrated.

```
wp-content/themes/homirx-child/
├── style.css              # Child theme declaration + custom CSS overrides
├── functions.php          # Enqueue parent + child styles, register menus/widgets
├── front-page.php         # Homepage (ID 406, Home 1)
├── template-parts/
│   ├── header.php         # Logo + primary navigation
│   ├── footer.php         # Footer columns + copyright
│   └── hero.php           # Reusable page banner/hero section
└── page-templates/
    ├── service.php        # Service detail pages (11 pages)
    ├── directory.php      # Listings, categories, locations, search (9 pages)
    ├── content.php        # Contact, About, Testimonial, Partners, etc. (10 pages)
    ├── blog.php           # Blog, News pages (3 pages)
    └── events.php         # Events page (1 page)
```

---

## Templates

### `front-page.php` — Homepage
WordPress automatically uses this file for the site front page. Replaces Home 1 (ID 406). Contains the hero, services overview, and featured content sections specific to the homepage.

### `page-templates/service.php` — Service Pages
Covers 11 pages: Cameras, Monitored Alarms, Smart Locks, Home Automation, Surveillance (CCTV), Network and IT Management, Home Theatre & AV, Pre-Wire for Custom Builds, Smart Climate Control, Access Control, Subcontracting.

All share the same layout: hero banner with page title, rich text content area, optional feature list, CTA section. Assigned via Page Attributes → Template in the WordPress editor.

### `page-templates/directory.php` — Directory & Listings
Covers 9 pages: All Listings, All Categories, All Locations, Single Category, Single Location, Properties (grid/list/map/filter views), Search Result, Add Listing, Agents.

Renders Directorist shortcodes or template tags within the PHP layout shell. The PHP template provides the wrapper; Directorist handles the listing content.

### `page-templates/content.php` — General Content Pages
Covers ~10 pages: Contact, Services overview, Testimonial, Our Partner, How it Works, Members, Sign In.

Standard layout: hero + `the_content()` for the main body. Contact page gets the Contact Form 7 shortcode embedded.

### `page-templates/blog.php` — Blog & News
Covers Blog, News 02, News 03. Renders a post loop with pagination using `WP_Query`.

### `page-templates/events.php` — Events
Covers the Events Page. Renders The Events Calendar output within the PHP template shell.

---

## Template Parts

### `template-parts/header.php`
Plain PHP/HTML header replacing the Elementor header builder. Includes:
- Logo (pulled from Homirx theme options via `homirx_get_options()`)
- Primary navigation via `wp_nav_menu()`
- Mobile hamburger menu

### `template-parts/footer.php`
Footer with service links, contact info, social icons, and copyright. Static HTML with dynamic WordPress fields where needed (`bloginfo()`, `wp_nav_menu()`).

### `template-parts/hero.php`
Reusable banner section. Accepts the page title and optional subtitle. Used at the top of service, content, and other interior pages.

---

## CSS

`style.css` in the child theme:
- Declares the child theme and points to Homirx as the parent
- Contains only overrides and new styles — no duplication of parent CSS
- Homirx's existing CSS (Bootstrap, template.css, fontawesome) loads automatically via parent

---

## Migration Strategy

1. Build child theme scaffold (style.css, functions.php)
2. Build shared template parts (header, footer, hero)
3. Build and test `front-page.php` — verify homepage matches live
4. Build each page template one at a time, assign pages, verify
5. Once all 43 pages are on PHP templates, deactivate Elementor
6. Remove Elementor and Elementor Pro from plugins folder
7. Commit final state to GitHub

Pages stay on Elementor until their template is ready — no big-bang switchover.

---

## Success Criteria

- All 43 pages render correctly without Elementor active
- Layout is roughly similar to the live site
- No Elementor JS/CSS loads on any page
- All template files are in git and editable directly
- Child theme passes WordPress theme check (no fatal errors)
