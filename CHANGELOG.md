# Webperf Changelog

## 4.0.1 - 2024.02.09
### Added
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

### Changed
* Switch over to Vite `^5.0.0` & Node `^20.0.0` for the buildchain
* Move to using `ServicesTrait` and add getter methods for services
* Add `allow-plugins` for CI
* Update the Test on Google PageSpeed Insights URL to `pagespeed.web.dev`
* Clean up search bar CSS
* Updated docs to use node 20 & a new sitemap plugin
* ECS code cleanup

### Fixed
* Ensure that `$driver` is nullable in the install migration
* Update to Boomerang Loader Snippet version 15 to modernize the loader, and eliminage `document.write` warnings
* Fix the sidebar CSS so the radial bar chart is not cropped, and there is padding around the text labels ([#51](https://github.com/nystudio107/craft-webperf/issues/51))
* Added  the unused `static` to the Tailwind CSS `blocklist` to avoid a name collision with a Craft CSS class ([#1412](https://github.com/nystudio107/craft-seomatic/issues/1412))

## 4.0.0 - 2022.06.23
### Added
* Initial Craft CMS 4 release

### Changed
* Removed the sub resource integrity on the built JavaScript, which could fail if systems were set up that manipulated the incoming JavaScript resources dynamically

## 4.0.0-beta.3 - 2022.03.18

### Fixed

* Fix registering permissions ([#352](https://github.com/craftcms/docs/issues/352))

## 4.0.0-beta.2 - 2022.03.04

### Fixed

* Updated types for Craft CMS `4.0.0-alpha.1` via Rector

## 4.0.0-beta.1 - 2022.02.27

### Added

* Initial Craft CMS 4 compatibility
