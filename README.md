# WpEngine Site Template
## How to setup a new site

1. Create a full back-up of the production site from WpEngine.
2. Create a new GitHub repository using the [wpengine-site](https://github.com/xwp/wpengine-site) as a template.
3. Clone the repository locally and extract the backup archive inside of it.
4. Add your SSH key to the staging & production push accesses. 
5. Add the staging & production WpEngine remotes locally.
6. Do a push to the staging environment and ensure this works correctly. Sometimes copying the production environment to staging is required to get this through.

## How to setup auto-deployment with Branch CI
1. [Branch GitHub app](https://github.com/settings/connections/applications/9f95269ac29d7797f9d5) permissions should be granted on the organisation owning the repository.
2. [Login or sign-up with GitHub to Branch CI](https://www.branchci.com/).
3. [Add a new project](https://app.branchci.com/projects/create) by selecting the GitHub repository
4. Go to the Settings tab and copy the project's SSH public key. Paste it for both staging & production Git push access next to your own.
5. (Optional) Add a build step by selecting compile frontend assets with NPM and fill in the necessary commands to be run.
6. Add the Wp Engine Git Deployment part once for production and swap out $WPENGINE_GIT_URL by your own production remote like _git@git.wpengine.com:production/xxx.git_
`git remote add wpengine $WPENGINE_GIT_URL`
`git push wpengine master`
and select from the Advanced options only for branch `master`
7. Add the Wp Engine Git Deployment part for staging too and swap out $WPENGINE_GIT_URL by your own staging remote like _git@git.wpengine.com:production/stagexxx.git_
and select from the Advanced options only for branch `staging`.
8. (Optional) If the develop environment is also used, take the same steps as for staging, but limit the build just to the `develop` branch.

## Local development environment
We recommend either [vvv](https://github.com/Varying-Vagrant-Vagrants/VVV) or [Local by Flywheel](https://localbyflywheel.com/) for setting it up. Local by Flywheel joined WpEngine, hence it's likely that more features will be built to improve the experience when working on sites hosted with them.
