# WpEngine Site Template

## How to use this repo

This repository can be used as a template to build out a new repository for a WPEngine hosted site.

## How to setup a new site

1. Create a full back-up of the production site from WpEngine.
2. Create a new GitHub repository using the [xwp-wpengine-site-template](https://github.com/xwp/xwp-wpengine-site-template) as a template with two branches:
  - main (for production)
  - develop (for staging)
3. Clone the repository locally and extract the backup archive inside of it.
4. Add your SSH key to the [staging & production git push accesses](https://wpengine.com/support/git/). 
5. Add the staging & production WpEngine remotes to your local Git repo.
  - `git remote add production git@git.wpengine.com:production/EXAMPLE.git`
  - `git remote add staging git@git.wpengine.com:staging/EXAMPLE.git`
6. Do a push to the staging environment and ensure this works correctly. Sometimes copying the production environment to staging is required to get this through.
  - `git push staging develop`

Note: It is not required to set up a push to staging, however this can be useful if you do not wish to set up automated deployments immediately.

## How to setup auto-deployment with Github Actions

WP Engine provides their own official [Github Action](https://github.com/marketplace/actions/deploy-wordpress-to-wp-engine) which can be used to handle auto deployments.

For a detailed walkthrough, refer to [our Best Practices for Deployment](https://github.com/xwp/engineering-best-practices/blob/ecbe4101083134be129ff38b0f288d5540d5c6e6/workflows/deployments.md#wp-engine)

1. [Generate a new SSH key pair](https://wpengine.com/support/ssh-keys-for-shell-access/#Generate_New_SSH_Key) for this project. 
  - The key should be owned by the client, not someone at XWP.
  - Make sure the key is _passwordless_
2. Add SSH Public Key to [WP Engine SSH Gateway Key settings](https://wpengine.com/support/ssh-gateway/).
3. Add the SSH **Private** Key to the [Repository Secrets](https://docs.github.com/en/actions/security-guides/encrypted-secrets#creating-encrypted-secrets-for-a-repository).
  - use the name `WPE_SSHG_KEY_PRIVATE`.
4. Create two files in `.github/workflows/` with the same names as the primary branches:
  - `main.yml` (production)
  - `develop.yml` (staging)
5. Copy and paste the configuration from [WP Engine's action](https://github.com/marketplace/actions/deploy-wordpress-to-wp-engine) into each file, replacing the value under `branches:` and the value for `WPE_ENV:` as appropriate.

An example.yml file is included in this repository to demonstrate some common XWP configurations, such as running NPM. This can be expanded to delete development files if needed via their custom flags.

### Caveats

* Launchpad requires the use of `composer install` in the run line (i.e. `npm install && composer install && npm run build`) 

## Local development environment

We recommend either [vvv](https://github.com/Varying-Vagrant-Vagrants/VVV) or [Local by Flywheel](https://localbyflywheel.com/) for setting it up. Local by Flywheel joined WpEngine, hence it's likely that more features will be built to improve the experience when working on sites hosted with them.

See also [Local Environment for Small Projects](https://docs.google.com/document/d/1u6G9AbEkL3O2KBoUfSooF10UvD9yBcnbaHjl2_s8YaI/edit?usp=sharing)