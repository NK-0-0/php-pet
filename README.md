# PetPal

A simple PHP demo app for browsing cute pets — dogs, cats, and birds. Built as a starter project for learning **GitHub Actions** and deploying to **GitHub Pages**.

## Features

- **Mock login** with pre-filled demo credentials
- **Pet gallery** with 8 mock pets (dogs, cats, birds)
- **Session-based auth** when running locally with PHP
- **Static export** for GitHub Pages (PHP runs at build time in CI)

## Demo credentials

| Field    | Value              |
|----------|--------------------|
| Email    | `demo@petpal.com`  |
| Password | `pets123`          |

## Run locally

Requires PHP 8.1+.

```bash
cd php-home
php -S localhost:8000
```

Open [http://localhost:8000](http://localhost:8000), click **Sign In**, and browse the pet gallery.

## Deploy to GitHub Pages

GitHub Pages serves **static files only** — it cannot run PHP on each request. This project handles that by rendering PHP templates to HTML during the GitHub Actions build.

### Setup steps

1. **Create a GitHub repo** and push this project:

   ```bash
   git init
   git add .
   git commit -m "Initial PetPal PHP project"
   git branch -M main
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO.git
   git push -u origin main
   ```

2. **Enable GitHub Pages** in your repo:
   - Go to **Settings → Pages**
   - Under **Build and deployment**, set **Source** to **GitHub Actions**

3. **Push to `main`** — the workflow in `.github/workflows/deploy.yml` will:
   - Run PHP to build static HTML into `public/`
   - Deploy the result to GitHub Pages

4. Your site will be live at `https://YOUR_USERNAME.github.io/YOUR_REPO/`

### Build static files manually

```bash
php scripts/build-static.php
```

Output lands in `public/` (`index.html`, `pets.html`, assets).

## Project structure

```
├── index.php              # Login page (auto-filled credentials)
├── pets.php               # Protected pet list
├── logout.php             # End session
├── includes/
│   ├── auth.php           # Session auth helpers
│   ├── config.php         # App config & mock user
│   ├── pets-data.php      # Mock pet data
│   ├── header.php
│   └── footer.php
├── assets/css/style.css
├── assets/js/static-auth.js   # Client auth for static build
├── scripts/build-static.php   # Static site generator
└── .github/workflows/deploy.yml
```

## How it works

| Environment   | Auth                         | Pets page        |
|---------------|------------------------------|------------------|
| Local PHP     | PHP sessions                 | `pets.php`       |
| GitHub Pages  | JS + pre-rendered HTML       | `pets.html`      |

Locally you get real PHP behavior. On GitHub Pages, the Action pre-renders pages so visitors still see the full site.
