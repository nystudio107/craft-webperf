# Webperf Changelog

## 1.1.21 - UNRELEASED
### Changed
* Updated build system infra

## 1.0.20 - 2021.02.09
### Changed
* Updated Axios to `^0.21.1`

### Fixed
* Fixed an incompatibility with PHP 8 caused by trait aliases not being fully qualified

## 1.0.19 - 2020.12.09
### Changed
* Moved the CSS/JS buildchain over to webpack 5
* Updated to latest npm deps

## 1.0.18 - 2020.03.11
### Fixed
* Fixed an issue where outlier samples were not being properly trimmed due to the computed threshold being non-integral

## 1.0.17 - 2019.12.11
### Security
* Throw an exception if an invalid sort field is passed into the controller methods, to eliminate a low-impact SQL injection vulnerability

## 1.0.16 - 2019.12.09
### Changed
* Updated to the latest datepicker package

### Fixed
* Fixed a low-impact SQL injection vulnerability
* Fixed an issue where Webperf was erroneously showing "0 data samples" on the Dashboard

## 1.0.15 - 2019.11.19
### Changed
* Updated packages as per `npm audit fix`

## 1.0.14 - 2019.09.09
### Changed
* Replaced frontend api route with an actionUrl()

## 1.0.13 - 2018.08.07
### Changed
* Updated assets build to update to the latest npm packages
* Fixed a `bootstrap` error when viewing entries with Webperf sidebar is visible

## 1.0.12 - 2018.06.25
### Changed
* Fixed an issue where an error could be thrown rendering the Webperf Twig template if the title contained characters that need escaping in a JavaScript context
* Added the frontend routes for `/retour` and `/seomatic/` to the default exclusion list
* Added database indexes to improve performance

## 1.0.11 - 2018.06.05
### Changed
* Fixed an issue where the sidebar preview would log JavaScript errors
* Updated to Tailwind CSS `^1.0.0`
* Updated to the latest ApexCharts, fixed issues due to changed APIs

## 1.0.10 - 2018.05.21
### Changed
* Updated to the latest version of the beacon (Boomerang 1.650.0), which fixes some issues
* Updated build system

## 1.0.9 - 2018.05.01
### Changed
* Removed vestigial debugging code
* Added a Sample Trimming Rate Limit that defaults to once per hour, to prevent the sample trimming from impacting performance

## 1.0.8 - 2018.04.19
### Changed
* Fixed an issue where an empty **Exclude Patterns** table and the use of Project Config on Craft 3.1 or later could cause an exception to be thrown when a 404 is thrown
* Fixed an issue where Webperf would fire during Live Preview when it shouldn't
* Updated Twig namespacing to be compliant with deprecated class aliases in 2.7.x

## 1.0.7 - 2019-03-15
### Changed
* Fixed a potential `Undefined property` in the MetricsController 
* Don't allow editing of the plugin settings if `allowAdminChanges` is false
* Fixed an issue where an error would be thrown on the Performance Detail page if you were not running Craft 3.1 or later

## 1.0.6 - 2019-02-28
### Changed
* Fixed a potential division by zero error in the memory limit recommendation under rare circumstances

## 1.0.5 - 2019-02-27
### Changed
* Fixed a `A non well formed numeric value` if you have your `memory_limit` set a certain way in your `php.ini`

## 1.0.4 - 2019-02-26
### Changed
* Fixed an issue with Craft 3.1.5 no longer allowing non-numeric values in the nav `badgeCount`
* Fixed a potential division by zero error in the memory limit recommendation

## 1.0.3 - 2019-02-22
### Changed
* Updated the beacon to remove `AutoXHR` and add in `MD5`
* If you're using Craft 3.1, Webperf will use Craft [environmental variables](https://docs.craftcms.com/v3/config/environments.html#control-panel-settings) for secrets

## 1.0.2 - 2019-02-20
### Changed
* Removed the unimplemented Widget stub

## 1.0.1 - 2019-02-12
### Changed
* Fixed the docs and changelog URLs in composer.json
* Price is now $59; I want as many people using Webperf as possible

## 1.0.0 - 2019-02-12
### Added
* Initial release
