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

### 4. Open WordPress

Go to [http://localhost:8080](http://localhost:8080) and complete the WordPress install wizard.

### 5. Import the database

Ask a team member for the latest database export (`database.sql`), then run:

```bash
sed 's/SERVMASK_PREFIX_/wp_/g' database.sql | \
  docker exec -i sshpros-site-database-1 mysql -u sshpros -psshpros sshpros
```

Then update the site URL to localhost:

```bash
docker exec sshpros-site-database-1 mysql -u sshpros -psshpros sshpros -e \
  "UPDATE wp_options SET option_value='http://localhost:8080' WHERE option_name IN ('siteurl','home');"
```

### 6. Log in

Go to [http://localhost:8080/wp-admin](http://localhost:8080/wp-admin).

Ask a team member for credentials, or reset a user's password:

```bash
docker exec sshpros-site-wordpress-1 bash -c \
  "wp user update <username> --user_pass='newpassword' --allow-root"
```

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
2. Edit files in `wp-content/themes/homirx/` or `wp-content/plugins/`
3. Commit and push: `git add . && git commit -m "description" && git push`
4. Open a pull request on GitHub

## Active Theme

**Homirx** — located at `wp-content/themes/homirx/`
