# WPEngine site setup checklist

- [] Replace package comment `WPEngineSiteTemplate` with client name.

## Single site

This template defaults to multisite. If your client site is single site then update following items:

- [ ] Update [package.json](package.json) to update `npm run cli -- wp core multisite-install` to `npm run cli -- wp core install`
- [ ] Update [wp-config.php](local/public/wp-config.php) to remove lines from `#--------Multisite setup--------#` to `#--------Multisite setup end--------#`.
