# Webperf Changelog

All notable changes to this project will be documented in this file.

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
