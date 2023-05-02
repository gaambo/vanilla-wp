# [WordPress Vanilla Boilerplate](https://github.com/gaambo/vanilla-wp)

WordPress boilerplate for vanilla WordPress installations with modern development Tools (Docker, WP CLI, PHPCS).

## Quick Links

- [Installation](#Installation)
- [Getting Started](https://github.com/gaambo/vanilla-wp/wiki/Getting-Started)

## Features

**Gaambos Vanilla WP** takes vanilla WordPress and enhances it through the following features:

- [Docker Compose](https://docs.docker.com/compose/) for local developing (and for making deployment easier) including [Xdebug](https://xdebug.org/)
- A [WP-CLI](https://wp-cli.org/) Docker container
- PHP linting with [PSR2 Standards](https://www.php-fig.org/psr/psr-2/) via [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer)
- Deploying via [Deployer](https://deployer.org/)

## Requirements

- PHP >= 8.0
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Installation

1. Create a new project  
   Clone git repository
   ```sh
   $ git clone git@github.com:gaambo/vanilla-wp.git website-dir
   $ cd website-dir && rm -rf .git
   $ git init
   ```
2. Set file Permissions (when on WSL2 or Linux)
   1. Choose which user should WordPress/the server run as and you want to edit the files (in most cases it's your user)
   2. Create a `.env` file in the root directory to set the the user
         ```env
         DOCKER_USER=0 # output from $(id -u)
         DOCKER_USER_GROUP=0 # output from $(id -g)
         ```
   3. Ensure the project-folder (and public) belong to this user
         ```bash
            chown -R 1000:1000 ./public
         ```
   [More Information](https://github.com/gaambo/vanilla-wp/issues/3)
3. Start Docker containers
   ```sh
   docker-compose -f "docker.compose.development.yml" up -d --build
   ```
4. Install WordPress ([See Wiki](https://github.com/gaambo/vanilla-wp/wiki/WP-CLI))
   ```sh
   $ .\util\wpcli.bat core download --path='./public'
   ```
   Then run `.\util\wpcli.bat core install` with the [according arguments](https://developer.wordpress.org/cli/commands/core/install/) or just open up the website in your browser to start WordPress famous 5 minute installation.
5. Install dependencies
   ```sh
   $ composer install
   ```
6. Install Theme  
   My [\_g Theme](https://github.com/gaambo/_g-wp-theme) works perfectly with this boilerplate. I suggest you use this one:
   ```sh
   $ cd public/wp-content/themes/${themename}
   $ git clone git@github.com:gaambo/_g-wp-theme.git .
   $ rm -rf .git
   $ npm install
   $ composer install
   ```
   Then exclude the path in gitignore: `!public/wp-content/themes/${themename}`

All other themes can be installed as usual (unzip in public/wp-content/themes, upload via FTP,...). You can also use wpcli:

```sh
$ ./util/wpcli.sh plugin theme twentynineteen
```

6. Install Core Functionality Plugin (optional)  
   My [Core Functionality Plugin](https://github.com/gaambo/wp-core-functionality-plugin) works perfectly with this boilerplate. I suggst you use it to for complete site-projects to put all site-specific functionality in it:
   ```sh
   $ git clone git@github.com:gaambo/wp-core-functionality-plugin.git public/wp-content/mu-plugins/core-functionality
   $ rm -rf .git
   ```
   Then exclude the path in gitignore: `!public/wp-content/mu-plugins/core-functionality`
7. Install plugins:
   ```sh
   $ ./util/wpcli.sh plugin install autodescription
   ```
8. If developing a custom theme or plugin which you want to include in the repository exclude it in `.gitignore`.
9. If developing a custom theme or plugin which you want to have PHP linting available include it in `phpcs.xml` via `<include-pattern>PATH</include-pattern>`.
10. Set the document root on your webserver to the public folder: `/path/to/site/public/`
11. Access WordPress admin at `https://example.com/wp-admin/`

## Deployment

[PHP Deployer](https://deployer.org/) in conjunction with [gaambos WordPress recipes](https://github.com/gaambo/deployer-wordpress) is used. A documentation of all available tasks can be found in the `README.md` of the package. The `deploy.php` is based on the default/vanilla deploy recipe from this package and edits localhost settings for setting document root and using Docker for WP CLI.

Before running any tasks you have to configure SSH acces to the hosts defined in `util/hosts.yml` via `~/.ssh/config`.

Run scripts in `scripts` dir via `.\util\wpcli.bat eval-file ./scripts/roles-capabilities.php` (on server).

## Documentation

Documentation can be found in our [GitHub wiki](https://github.com/gaambo/vanilla-wp/wiki)

## Contributing

Contributions are welcome from everyone. Just open an [issue](https://github.com/gaambo/vanilla-wp/issues) or contact me.
