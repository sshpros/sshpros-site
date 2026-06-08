# Homirx Child Theme Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a `homirx-child` WordPress theme with PHP templates that replace all 43 Elementor-built pages, eliminating the Elementor Pro dependency.

**Architecture:** Child theme inherits Homirx parent styles and overrides only what's needed. Shared template parts (header, footer, hero) are used across all page templates. Pages are migrated one template type at a time — Elementor stays active until all pages are switched.

**Tech Stack:** WordPress 6.7, PHP, CSS, Homirx parent theme, Directorist plugin, The Events Calendar plugin.

---

## File Map

| File | Purpose |
|------|---------|
| `wp-content/themes/homirx-child/style.css` | Child theme declaration + CSS overrides |
| `wp-content/themes/homirx-child/functions.php` | Enqueue styles, register menus |
| `wp-content/themes/homirx-child/front-page.php` | Homepage (post ID 406) |
| `wp-content/themes/homirx-child/template-parts/header.php` | Logo + nav |
| `wp-content/themes/homirx-child/template-parts/footer.php` | Footer |
| `wp-content/themes/homirx-child/template-parts/hero.php` | Reusable page banner |
| `wp-content/themes/homirx-child/page-templates/service.php` | 11 service pages |
| `wp-content/themes/homirx-child/page-templates/directory.php` | 9 directory/listing pages |
| `wp-content/themes/homirx-child/page-templates/content.php` | 10 general content pages |
| `wp-content/themes/homirx-child/page-templates/blog.php` | Blog + News pages |
| `wp-content/themes/homirx-child/page-templates/events.php` | Events page |

---

## Task 1: Scaffold the Child Theme

**Files:**
- Create: `wp-content/themes/homirx-child/style.css`
- Create: `wp-content/themes/homirx-child/functions.php`

- [ ] **Step 1: Create style.css**

```css
/*
Theme Name: Homirx Child
Template: homirx
Version: 1.0.0
Description: Child theme for Security & Smarthome Pros
*/
```

- [ ] **Step 2: Create functions.php**

```php
<?php
function homirx_child_enqueue_styles() {
    wp_enqueue_style(
        'homirx-parent-style',
        get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
        'homirx-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'homirx-parent-style' )
    );
}
add_action( 'wp_enqueue_scripts', 'homirx_child_enqueue_styles' );
```

- [ ] **Step 3: Activate the child theme in WordPress**

Go to `http://localhost:8080/wp-admin/themes.php` and activate **Homirx Child**.

- [ ] **Step 4: Verify the site still loads correctly**

Visit `http://localhost:8080` — should look identical to before (inheriting all parent styles).

- [ ] **Step 5: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: scaffold homirx-child theme"
```

---

## Task 2: Build Shared Template Parts — Header

**Files:**
- Create: `wp-content/themes/homirx-child/template-parts/header.php`

The child theme's `header.php` will call `get_template_part('template-parts/header')`. This replaces the Elementor header builder with plain PHP/HTML.

- [ ] **Step 1: Create `template-parts/header.php`**

```php
<?php
$homirx_options = homirx_get_options();
$logo = ( isset( $homirx_options['header_logo']['url'] ) && $homirx_options['header_logo']['url'] )
    ? $homirx_options['header_logo']['url']
    : get_template_directory_uri() . '/assets/images/logo.png';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="wrapper-page">

    <div class="header-mobile header_mobile_screen">
        <div class="header-mobile-content">
            <div class="header-content-inner clearfix">
                <div class="header-left">
                    <div class="logo-mobile">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                        </a>
                    </div>
                </div>
                <div class="header-right">
                    <button class="navbar-toggle mobile-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <header class="header-default">
        <div class="header_default_screen">
            <div class="header-bottom">
                <div class="container">
                    <div class="header-bottom-inner">
                        <div class="logo">
                            <a class="logo-theme" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                        <div class="main-menu-inner">
                            <div class="content-innter clearfix">
                                <div id="gva-mainmenu" class="main-menu">
                                    <?php
                                    wp_nav_menu( array(
                                        'theme_location' => 'primary',
                                        'container'      => 'div',
                                        'container_class'=> 'navbar-collapse',
                                        'menu_class'     => 'navbar-nav',
                                    ) );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="page-content">
```

- [ ] **Step 2: Create `header.php` in child theme root to load the template part**

```php
<?php get_template_part( 'template-parts/header' ); ?>
```

- [ ] **Step 3: Verify header renders on the site**

Visit `http://localhost:8080` — logo and nav should appear. Check mobile view too.

- [ ] **Step 4: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add child theme header template part"
```

---

## Task 3: Build Shared Template Parts — Footer + Hero

**Files:**
- Create: `wp-content/themes/homirx-child/template-parts/footer.php`
- Create: `wp-content/themes/homirx-child/template-parts/hero.php`
- Create: `wp-content/themes/homirx-child/footer.php`

- [ ] **Step 1: Create `template-parts/footer.php`**

```php
<?php $copyright = homirx_get_option( 'copyright_text', '' ); ?>

    </div><!-- end page-content -->
</div><!-- end wrapper-page -->

<footer id="wp-footer" class="clearfix">
    <div class="footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4><?php bloginfo( 'name' ); ?></h4>
                    <p><?php bloginfo( 'description' ); ?></p>
                </div>
                <div class="col-md-4">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'depth'          => 1,
                    ) );
                    ?>
                </div>
                <div class="col-md-4">
                    <?php get_template_part( 'templates/parts/socials' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="copyright-content">
                <?php
                if ( ! empty( $copyright ) ) {
                    echo esc_html( $copyright );
                } else {
                    echo esc_html__( 'Copyright ' . date( 'Y' ) . ' Security & Smarthome Pros. All rights reserved.', 'homirx' );
                }
                ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
```

- [ ] **Step 2: Create `footer.php` in child theme root**

```php
<?php get_template_part( 'template-parts/footer' ); ?>
```

- [ ] **Step 3: Create `template-parts/hero.php`**

```php
<?php
$title    = isset( $args['title'] ) ? $args['title'] : get_the_title();
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : '';
?>
<section class="page-hero">
    <div class="container">
        <div class="page-hero-inner">
            <h1 class="page-hero-title"><?php echo esc_html( $title ); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="page-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>
```

- [ ] **Step 4: Add hero styles to `style.css`**

```css
.page-hero {
    background-color: #0d1b2a;
    color: #fff;
    padding: 60px 0;
    margin-bottom: 40px;
}
.page-hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px;
}
.page-hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.85;
    margin: 0;
}
```

- [ ] **Step 5: Verify footer renders**

Visit `http://localhost:8080` — footer should show at the bottom.

- [ ] **Step 6: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add footer and hero template parts"
```

---

## Task 4: Build front-page.php (Homepage)

**Files:**
- Create: `wp-content/themes/homirx-child/front-page.php`

WordPress automatically loads `front-page.php` for the static front page (post ID 406).

- [ ] **Step 1: Create `front-page.php`**

```php
<?php get_header(); ?>

<main id="wp-main-content" class="clearfix main-page">
    <section class="home-hero">
        <div class="container">
            <div class="home-hero-inner">
                <h1 class="home-hero-title">
                    Security &amp; Smarthome Pros
                </h1>
                <p class="home-hero-subtitle">
                    Professional security, smart home, and AV solutions for your home or business.
                </p>
                <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-primary">
                    Get a Free Quote
                </a>
            </div>
        </div>
    </section>

    <section class="home-services">
        <div class="container">
            <h2 class="section-title text-center">Our Services</h2>
            <div class="row">
                <?php
                $service_pages = array(
                    'cameras'                            => 'Cameras',
                    'monitored-alarms'                   => 'Monitored Alarms',
                    'smart-locks'                        => 'Smart Locks',
                    'home-automation'                    => 'Home Automation',
                    'surveillance-cctv'                  => 'Surveillance (CCTV)',
                    'network-and-it-management'          => 'Network & IT',
                    'home-theatre-audio-visual-solutions'=> 'Home Theatre & AV',
                    'smart-climate-control'              => 'Smart Climate Control',
                    'access-control-and-ada-compliance'  => 'Access Control',
                );
                foreach ( $service_pages as $slug => $label ) :
                    $page = get_page_by_path( $slug );
                    if ( ! $page ) continue;
                ?>
                <div class="col-md-4 col-sm-6">
                    <div class="service-card">
                        <?php if ( has_post_thumbnail( $page->ID ) ) : ?>
                            <div class="service-card-image">
                                <?php echo get_the_post_thumbnail( $page->ID, 'medium' ); ?>
                            </div>
                        <?php endif; ?>
                        <h3 class="service-card-title">
                            <a href="<?php echo esc_url( get_permalink( $page->ID ) ); ?>">
                                <?php echo esc_html( $label ); ?>
                            </a>
                        </h3>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="home-cta">
        <div class="container text-center">
            <h2>Ready to protect your home?</h2>
            <p>Contact us today for a free consultation.</p>
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-primary">
                Contact Us
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 2: Add homepage styles to `style.css`**

```css
.home-hero {
    background-color: #0d1b2a;
    color: #fff;
    padding: 100px 0;
    text-align: center;
}
.home-hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 20px;
}
.home-hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 30px;
    opacity: 0.9;
}
.home-services {
    padding: 60px 0;
}
.section-title {
    margin-bottom: 40px;
}
.service-card {
    border: 1px solid #eee;
    border-radius: 6px;
    padding: 20px;
    margin-bottom: 30px;
    transition: box-shadow 0.2s;
}
.service-card:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}
.service-card-title a {
    color: #0d1b2a;
    text-decoration: none;
}
.home-cta {
    background-color: #f5f5f5;
    padding: 60px 0;
}
```

- [ ] **Step 3: Verify homepage at `http://localhost:8080`**

Should show hero, service grid, and CTA section. Nav and footer should be present.

- [ ] **Step 4: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add homepage front-page.php template"
```

---

## Task 5: Build Service Page Template

**Files:**
- Create: `wp-content/themes/homirx-child/page-templates/service.php`

- [ ] **Step 1: Create `page-templates/service.php`**

```php
<?php
/*
 * Template Name: Service Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="service-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?php if ( have_posts() ) : the_post(); ?>
                        <div class="service-body">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4">
                    <div class="service-sidebar">
                        <div class="sidebar-cta">
                            <h3>Get a Free Quote</h3>
                            <p>Contact us to discuss your security needs.</p>
                            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-primary btn-block">
                                Contact Us
                            </a>
                        </div>
                        <div class="sidebar-services">
                            <h4>Our Services</h4>
                            <?php
                            wp_nav_menu( array(
                                'theme_location' => 'services',
                                'container'      => false,
                                'menu_class'     => 'sidebar-services-menu',
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ) );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service-cta">
        <div class="container text-center">
            <h2>Ready to get started?</h2>
            <a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="btn btn-primary">
                Request a Consultation
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 2: Add service page styles to `style.css`**

```css
.service-content {
    padding: 40px 0;
}
.service-body {
    font-size: 1rem;
    line-height: 1.7;
}
.service-sidebar {
    position: sticky;
    top: 20px;
}
.sidebar-cta {
    background: #0d1b2a;
    color: #fff;
    padding: 30px;
    border-radius: 6px;
    margin-bottom: 30px;
    text-align: center;
}
.sidebar-cta h3 {
    color: #fff;
    margin-top: 0;
}
.sidebar-services {
    background: #f5f5f5;
    padding: 20px;
    border-radius: 6px;
}
.sidebar-services-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar-services-menu li a {
    display: block;
    padding: 8px 0;
    border-bottom: 1px solid #ddd;
    color: #0d1b2a;
    text-decoration: none;
}
.service-cta {
    background: #0d1b2a;
    color: #fff;
    padding: 50px 0;
}
.service-cta h2 {
    color: #fff;
    margin-bottom: 20px;
}
```

- [ ] **Step 3: Assign template to one service page and verify**

In wp-admin, open **Cameras** page → Page Attributes → Template → select **Service Page** → Update.
Visit `http://localhost:8080/cameras/` — should show hero, content, sidebar, CTA.

- [ ] **Step 4: Assign template to all 11 service pages**

Pages to update: Cameras, Monitored Alarms, Smart Locks, Home Automation, Surveillance (CCTV), Network and IT Management, Home Theatre & AV, Pre-Wire for Custom Builds, Smart Climate Control, Access Control and ADA Compliance, Subcontracting and "Smarthands".

Run via WP-CLI:
```bash
docker exec sshpros-site-wordpress-1 bash -c "wp post list --post_type=page --fields=ID,post_name --allow-root 2>&1 | grep -E 'cameras|monitored-alarms|smart-locks|home-automation|surveillance|network-and-it|home-theatre|pre-wire|smart-climate|access-control|subcontracting'"
```

Then for each ID:
```bash
docker exec sshpros-site-wordpress-1 bash -c "wp post meta update <ID> _wp_page_template 'page-templates/service.php' --allow-root"
```

- [ ] **Step 5: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add service page template"
```

---

## Task 6: Build Directory Page Template

**Files:**
- Create: `wp-content/themes/homirx-child/page-templates/directory.php`

- [ ] **Step 1: Create `page-templates/directory.php`**

```php
<?php
/*
 * Template Name: Directory Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="directory-content">
        <div class="container">
            <?php if ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 2: Assign template to directory pages via WP-CLI**

```bash
docker exec sshpros-site-wordpress-1 bash -c "
for id in 415 426 432 433 278 2 421 420 424 434 427 428 425; do
  wp post meta update \$id _wp_page_template 'page-templates/directory.php' --allow-root
done
" 2>&1
```

- [ ] **Step 3: Verify one directory page**

Visit `http://localhost:8080/properties/` — should show hero and the Directorist listings shortcode output.

- [ ] **Step 4: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add directory page template"
```

---

## Task 7: Build Content, Blog, and Events Templates

**Files:**
- Create: `wp-content/themes/homirx-child/page-templates/content.php`
- Create: `wp-content/themes/homirx-child/page-templates/blog.php`
- Create: `wp-content/themes/homirx-child/page-templates/events.php`

- [ ] **Step 1: Create `page-templates/content.php`**

```php
<?php
/*
 * Template Name: Content Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero' ); ?>

    <section class="content-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <?php if ( have_posts() ) : the_post(); ?>
                        <div class="content-body">
                            <?php the_content(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 2: Create `page-templates/blog.php`**

```php
<?php
/*
 * Template Name: Blog Page
 */
get_header();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
) );
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero', null, array( 'title' => 'News & Updates' ) ); ?>

    <section class="blog-archive">
        <div class="container">
            <div class="row">
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="col-md-4">
                    <article class="blog-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="blog-card-image">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </a>
                        <?php endif; ?>
                        <div class="blog-card-body">
                            <h3 class="blog-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <p class="blog-card-meta"><?php echo get_the_date(); ?></p>
                            <p class="blog-card-excerpt"><?php the_excerpt(); ?></p>
                        </div>
                    </article>
                </div>
                <?php endwhile; endif; wp_reset_postdata(); ?>
            </div>
            <div class="blog-pagination text-center">
                <?php
                echo paginate_links( array(
                    'total'   => $query->max_num_pages,
                    'current' => $paged,
                ) );
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 3: Create `page-templates/events.php`**

```php
<?php
/*
 * Template Name: Events Page
 */
get_header();
?>

<main id="wp-main-content" class="clearfix main-page">

    <?php get_template_part( 'template-parts/hero', null, array( 'title' => 'Events' ) ); ?>

    <section class="events-content">
        <div class="container">
            <?php if ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php get_footer(); ?>
```

- [ ] **Step 4: Assign content template to general pages via WP-CLI**

```bash
docker exec sshpros-site-wordpress-1 bash -c "
for id in 411 419 422 269 418 412 293; do
  wp post meta update \$id _wp_page_template 'page-templates/content.php' --allow-root
done
" 2>&1
```

- [ ] **Step 5: Assign blog template**

```bash
docker exec sshpros-site-wordpress-1 bash -c "
for id in 413 414 315; do
  wp post meta update \$id _wp_page_template 'page-templates/blog.php' --allow-root
done
" 2>&1
```

- [ ] **Step 6: Assign events template**

```bash
docker exec sshpros-site-wordpress-1 bash -c "wp post meta update 416 _wp_page_template 'page-templates/events.php' --allow-root" 2>&1
```

- [ ] **Step 7: Verify each template type**

- Visit `http://localhost:8080/contact/` — content template
- Visit `http://localhost:8080/blog/` — blog loop with posts
- Visit `http://localhost:8080/events-page/` — events content

- [ ] **Step 8: Commit**

```bash
git add wp-content/themes/homirx-child/
git commit -m "feat: add content, blog, and events page templates"
```

---

## Task 8: Deactivate Elementor and Final Cleanup

Once all pages are verified on PHP templates:

- [ ] **Step 1: Deactivate Elementor and Elementor Pro**

```bash
docker exec sshpros-site-wordpress-1 bash -c "wp plugin deactivate elementor elementor-pro --allow-root 2>&1"
```

- [ ] **Step 2: Verify the site still renders correctly**

Visit each template type:
- `http://localhost:8080/` — homepage
- `http://localhost:8080/cameras/` — service
- `http://localhost:8080/properties/` — directory
- `http://localhost:8080/contact/` — content
- `http://localhost:8080/blog/` — blog

Check browser devtools Network tab — confirm no `elementor` JS or CSS files are loading.

- [ ] **Step 3: Push to GitHub**

```bash
git push origin main
```

- [ ] **Step 4: Export updated database for team**

```bash
docker exec sshpros-site-database-1 mysqldump -u sshpros -psshpros sshpros > ~/Downloads/sshpros-local-$(date +%Y%m%d).sql
```
