# SSH Pros WordPress Site

Local development setup for [sshpros.com](https://sshpros.com).

## Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git](https://git-scm.com/)

## Local Setup

### 1. Clone the repo

```bash
git clone git@github.com:sshpros/sshpros-site.git
cd sshpros-site
```

### 2. Create a `.env` file

Create a `.env` file in the project root with these values:

```
MYSQL_DATABASE=sshpros
MYSQL_USER=sshpros
MYSQL_PASSWORD=sshpros
MYSQL_ROOT_PASSWORD=sshpros
```

### 3. Start Docker

```bash
docker-compose up -d
```

### 4. Import the database

Ask a team member for the latest database export (`database.sql`). The export comes from All-in-One WP Migration and uses `SERVMASK_PREFIX_` as a table prefix placeholder — replace it on import:

```bash
sed 's/SERVMASK_PREFIX_/wp_/g' database.sql | \
  docker exec -i sshpros-site-database-1 mysql -u sshpros -psshpros sshpros
```

Then update the site URL to localhost:

```bash
docker exec sshpros-site-database-1 mysql -u sshpros -psshpros sshpros -e \
  "UPDATE wp_options SET option_value='http://localhost:8080' WHERE option_name IN ('siteurl','home');"
```

Then do a deep URL replacement so Elementor and post content point to localhost:

```bash
docker exec sshpros-site-wordpress-1 bash -c \
  "wp search-replace 'https://sshpros.com' 'http://localhost:8080' --allow-root --recurse-objects --skip-columns=guid"
```

### 5. Remove the live site's object cache

The live site uses a Memcache object cache that doesn't exist locally — remove it:

```bash
docker exec sshpros-site-wordpress-1 rm -f /var/www/html/wp-content/object-cache.php
```

### 6. Increase PHP memory limit

The full plugin set needs more than the default 128M:

```bash
docker exec sshpros-site-wordpress-1 bash -c \
  "echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/uploads.ini"
docker restart sshpros-site-wordpress-1
```

### 7. Activate all plugins

```bash
docker exec sshpros-site-wordpress-1 bash -c "wp plugin activate --all --allow-root"
```

### 8. Flush Elementor CSS cache

```bash
docker exec sshpros-site-wordpress-1 bash -c \
  "wp eval '\Elementor\Plugin::instance()->files_manager->clear_cache();' --allow-root"
```

### 9. Log in

Go to [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin).

Ask a team member for credentials, or reset a user's password:

```bash
docker exec sshpros-site-wordpress-1 bash -c \
  "wp user update <username> --user_pass='newpassword' --allow-root"
```

The site should now look identical to the live site at sshpros.com.

---

## Useful URLs

| URL | Description |
|-----|-------------|
| http://localhost:8080 | WordPress site |
| http://localhost:8080/wp-admin | WordPress admin |
| http://localhost:8081 | phpMyAdmin (database UI) |

## Stopping Docker

```bash
docker-compose down
```

## Making Changes

1. Create a branch: `git checkout -b my-feature`
2. Edit files in `wp-content/themes/homirx-child/` (child theme) or `wp-content/plugins/`
3. Commit and push: `git add . && git commit -m "description" && git push`
4. Open a pull request on GitHub

## Active Theme

**Homirx Child** — `wp-content/themes/homirx-child/`  
Parent theme: **Homirx** — `wp-content/themes/homirx/`

Custom PHP templates live in `homirx-child/page-templates/`.  
Shared parts (header, footer, hero) live in `homirx-child/template-parts/`.
