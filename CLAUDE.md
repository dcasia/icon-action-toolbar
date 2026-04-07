# Icon Action Toolbar

## Context
Fork of `dcasia/icon-action-toolbar` maintained by Bora-Bora-Community. Upstream is inactive (Nova 4 only). We maintain Nova 5+ compatibility.

## Build
This plugin cannot be built standalone. It must be built from within a Laravel Nova project's `vendor/` directory:
```bash
cd vendor/digital-creative/icon-action-toolbar
npm ci
npm run production
```
The webpack `@` alias resolves to `vendor/laravel/nova/resources/js/` from the host project.

## GitHub
- **Our repo:** `Bora-Bora-Community/icon-action-toolbar`
- **Upstream (inactive):** `dcasia/icon-action-toolbar`
- Always use `--repo Bora-Bora-Community/icon-action-toolbar` with `gh` commands
- Never create PRs or issues on the upstream repo
