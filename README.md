# [WordPress Vanilla Boilerplate](https://github.com/gaambo/vanilla-wp)

WordPress boilerplate for vanilla WordPress installations with modern development tools and src directory for theme assets.

## Quick Links

- [Installation](#Installation)
- [Getting Started](https://github.com/gaambo/vanilla-wp/wiki/Getting-Started)

## Features

**Gaambos Vanilla WP** takes vanilla WordPress and enhances it through the following features:

- [Docker Compose](https://docs.docker.com/compose/) for local developing (and for making deployment easier) including [Xdebug](https://xdebug.org/)
- A [WP-CLI](https://wp-cli.org/) Docker container
- JavaScript linting via [ESLint](https://eslint.org/) configuration
- PHP linting with [PSR2 Standards](https://www.php-fig.org/psr/psr-2/) via [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer)
- Deploying via [Deployer](https://deployer.org/) (coming soon)
- [Snippets](https://github.com/gaambo/vanilla-wp/wiki/Snippets) for often used tools and plugins (e.g. installing of WordPress premium plugins like ACF Pro)
- A Src Directory for theme assets plus a gulpfile for building the assets.

## Requirements

- PHP >= 7.2
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- NodeJS / npm - [Install](https://www.npmjs.com/get-npm)

## Installation

1. Create a new project  
   Clone git repository
   ```sh
   $ git clone https://github.com/gaambo/vanilla-wp website-dir
   $ cd website-dir && rm -rf .git
   $ git init
   ```
2. Start Docker containers
   ```sh
   docker-compose -f "docker.compose.development.yml" up -d --build
   ```
3. Install WordPress ([See Wiki](https://github.com/gaambo/vanilla-wp/wiki/WP-CLI))
   ```sh
   $ .\build\wpcli.bat core download --path='./public'
   ```
   Then run `.\build\wpcli.bat core install` with the [according arguments](https://developer.wordpress.org/cli/commands/core/install/) or just open up the website in your browser to start WordPress famous 5 minute installation.
4. Install dependencies
   ```sh
   $ composer install
   $ npm install
   ```
5. Install plugins:
   ```sh
   $ ./build/wpcli.sh plugin install autodescription
   ```
6. Add theme(s) in `public/wp-content/themes/` as you would for a normal WordPress site.
7. If developing a custom theme or plugin which you want to include in the repository exclude it in `.gitignore`.
8. If developing a custom theme or plugin which you want to have JavaScript linting available exclude it in `.eslintignore`.
9.  If developing a custom theme or plugin which you want to have Style (CSS/SCSS) linting available exclude it in `.stylelintignore`.
10. If developing a custom theme or plugin which you want to have PHP linting available include it in `phpcs.xml` via `<include-pattern>PATH</include-pattern>`.
11. Set the document root on your webserver to the public folder: `/path/to/site/public/`
12. Access WordPress admin at `https://example.com/wp-admin/`

## Documentation

Documentation can be found in our [GitHub wiki](https://github.com/gaambo/vanilla-wp/wiki)

## Contributing

Contributions are welcome from everyone. Just open an [issue](https://github.com/gaambo/vanilla-wp/issues) or contact me.
