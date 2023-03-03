# WP Engine Template.

- Uses Composer for adding project dependencies, including plugins and themes.
- Uses Composer autoloader for using any of the popular PHP packages anywhere in the codebase.
- Includes a local development environment based on Docker with support for PHP Xdebug and a mail catcher.
- Includes automated build and deploy pipelines to WPEngine using GitHub actions.

## Requirements

- PHP 8.0
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org) version 16
- [Docker with Docker Compose](https://docs.docker.com/compose/install/)
- [rsync](https://rsync.samba.org) for deployments


### Install Dependencies

We suggest using [Homebrew](https://brew.sh) on macOS or [Chocolatey](https://chocolatey.org) for Windows to install the project dependencies.

	brew install git php@7.4 composer node@16 mkcert
	brew install --cask docker


### Code Editor and Git Client

This repository includes a list of suggested extensions for the [Visual Studio Code editor](https://code.visualstudio.com) and Xdebug support in the `.vscode` directory.

A user-friendly Git client such as [GitHub Desktop](https://desktop.github.com) or [Tower](https://www.git-tower.com/mac) enables smaller commits and simplifies merge conflict resolution.


## Overview

- Project plugins and themes can be added as Composer dependencies or manualy to this repository under `plugins/your-plugin` and `themes/your-theme`.
- Composer dependencies are placed under `plugins/vendor` since it has to be in the same location relative to the project root.
- Composer autoloader `plugins/vendor/autoload.php` is included in `mu-plugins/config.php`.

## Setup 🛠

1. Clone this repository:

		git clone git@github.com:xwp/xwp-wpengine-site-template.git

2. Move into the project directory:

		cd xwp-wpengine-site-template

3. Install the project dependencies:

		npm install

4. Start the development environment using Docker:

		npm run start

	and `npm run stop` to stop the virtual environment at any time. Run `npm run start-debug` to start the environment in debug mode where all output from containers is displayed. Run `npm run stop-all` to stop all active Docker containers in case you're running into port conflicts.

5. Install the local WordPress multisite environment:

		npm run setup

	with the configuration from `local/public/wp-cli.yml`.

6. Visit [local.wpengine.test](https://local.wpengine.test) to view the development environment. WordPress username `devgo` and password `devgo`.

7. Add the following to your hosts file:
    ```
   	127.0.0.1 local.wpengine.test
    ```

7. Visit [mail.local.wpengine.test](https://mail.local.wpengine.test) to view all emails sent by WordPress.

The local development environment uses a self-signed SSL certificate for HTTPS so the "Your connection is not private" error can be ignored to visit the site.

### Resolving Port Conflicts

Docker engine shares the networking interface with the host computer so all the ports used by the containers need to be free and unused by any other services such as a DNS resolver on port 53, MySQL service on port 3306 or another web server running on port 80.

Use the included `npm run stop-all` command to stop all containers running Docker containers on the host machine.

On Debian and Ubuntu systems use `sudo systemctl stop ...` to disable those services. For example:

- `sudo systemctl stop mysql` to stop MySQL
- `sudo systemctl stop apache2` to stop Apache
- `sudo systemctl stop systemd-resolved` to stop the local name server.

On macOS if you're using valet or valet plus you can run following:

- `valet stop` to stop valet services.
- `brew services list` to see all services running; There could be a service running with superuser in that case use `sudo brew services list` to see those and stop those by appending `sudo` to following commands.
- `brew services stop dnsmasq` to stop dnsmasq service.
- `brew services stop mariadb` to stop database service. (or mysql whichever database you're using.)
- `brew services stop redis` to stop redis service.

Alternatively, you can adjust the port mappings in `docker-compose.yml` to use different ports.

## Contribute

1. Setup the local environment as described in the "Setup" section above.

2. Create a Git branch such as `feature/name` or `fix/vertical-scroll` when starting work on a new feature or bug fix from the main branch. Committing your work to this branch until it is ready for quality assurance and testing is recommended.

3. Open [a pull request](https://help.github.com/en/desktop/contributing-to-projects/creating-a-pull-request) from the feature branch to the `main` branch.

4. Review the results of the automated checks and make note of any feedback. Remember that your local environment is set up to automatically check for issues before each commit, so there should be minimal issues if you commit frequently.

5. Merge the feature branch into the development branch by checking out the development branch locally, pulling in the feature branch, and then pushing the development branch. The automated process will deploy the code to the WPEngine dev environment for further testing.

6. After testing the feature on the dev server, assign the pull request for code review. Upon approval, the pull request will be merged into the main branch and automatically deployed to the production environment.

## Environment and branch mapping

| Branch    | Environment | URL                                 |
|-----------|-------------|-------------------------------------|
| `main`    | Production  | https://{slug}.wpengine.com/        |
| `staging` | Staging     | https://{slug}stg.wpengine.com |
| `develop` | Develop     | https://{slug}dev.wpengine.com |

## Plugins and Themes

Add new themes and plugins as Composer dependencies:

	composer require your/theme your/plugin another/plugin

or manually copy them to `themes`, `plugins` or `mu-plugins` directories. Remember to start tracking the directories copied manually by excluding them from being ignored in `themes/.gitignore` and `plugins/.gitignore`.

Use `mu-plugins/plugin-loader.php` to force-enable certain plugins.

To update plugins and themes added as Composer dependencies, use `composer install package/name` or `composer install --dev package/name` where `package/name` is the name of the plugin or theme package. Be sure to commit the updated `composer.json` with `composer.lock` to the GitHub repository.

For manually installed plugins and themes replace the directory with the updated set of files and commit them to the GitHub repository.


## Local Development Environment

We use Docker containers to replicate the WPEngine production environment as Composer packages and mapped to specific directories inside the containers as defined in `docker-compose.yml`.

Requests to port 80 of the container host are captured by an Nginx proxy container that routes all requests to the necessary service container based on the HTTP host name.


### Importing and Exporting Data

Use WPEngine web ui to download the database and media files from the production environment. Place the database file in the `local/public/wp` directory.

- Run `npm run cli -- wp db export` to export and backup the database of your local development environment which will place a file like `wordpress-2020-03-04-448b132.sql` in the `local/public/wp` directory.

- Run `npm run cli -- wp db import export.sql` to import `local/public/wp/export.sql` into your local development environment. Run `cat export/*.sql > combined.sql` to combine all `.sql` files in the `export` directory into one `combined.sql` file for quicker import.
  
- Run `npm run cli -- bash -c "pv import.sql | wp db query"` to import a large database file `local/public/wp/import.sql` while monitoring the progress with [`pv`](https://linux.die.net/man/1/pv) which is bundled with the WordPress container. The `bash -c` prefix allows us to run multiple commands inside the container without affecting the main `npm run cli` command.


## Scripts 🧰

We use `npm` as the canonical task runner for things like linting files and creating release bundles. Composer scripts (defined in `composer.json`) are used only for PHP related tasks and they have a wrapper npm script in `package.json` for consistency with the rest of the registered tasks.

- `npm run start` and `npm run stop` to start and stop the local development environment. Run `npm run start-debug` to start the environment in debug mode where all output from containers is displayed. Run `npm run stop-all` to stop all active Docker containers in case you're running into port conflicts. Run `npm run stop -- --volumes` to stop the project containers and delete the database data volume.

- `npm run lint` to check source code against the defined coding standards.

- `npm run cli -- wp help` where `wp help` is any command to run inside the WordPress docker container. For example, run `npm run cli -- wp plugin list` to list all of the available plugins or `npm run cli -- composer update` to update the Composer dependencies using the PHP binary in the container instead of your host machine. Run `npm run cli -- wp user create devgo local@wpengine.test --role=administrator --user_pass=devgo` to create a new administrator user with `devgo` as username and password.
