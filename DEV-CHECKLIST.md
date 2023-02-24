# WPEngine site setup checklist

- [ ] Replace package comment `WPEngineSiteTemplate` with client name.
- [ ] Generate and setup `WPE_SSHG_KEY_PRIVATE` in https://github.com/xwp/{client-name}/settings/secrets/actions and setup public key in client's account https://my.wpengine.com/ssh_keys
- [ ] Replace `WPE_ENV` with client's environment name.
- [ ] Verify postfix for `WPE_ENV` for staging (stg) and development (dev) environments. [deploy-staging.yml](.github/workflows/deploy-staging.yml) and [deploy-development.yml](.github/workflows/deploy-development.yml).

## Single site

This template defaults to multisite. If your client site is single site then update following items:

- [ ] Update [package.json](package.json) to update `npm run cli -- wp core multisite-install` to `npm run cli -- wp core install`
- [ ] Update [wp-config.php](local/public/wp-config.php) to remove lines from `#--------Multisite setup--------#` to `#--------Multisite setup end--------#`.
