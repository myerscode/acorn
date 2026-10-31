# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Calendar Versioning](https://calver.org/).

## [Unreleased]

### Added
- The demo command now tours Acorn's building blocks: config, events, an interactive prompt and a progress bar.
- A proper getting-started README (project structure, first command, config, events, testing, `acorn:optimize`).
- A `DemoCommand` test demonstrating `acorn-testing`.

### Changed
- `composer.json` type is `project` (it is the starter template), with a skeleton-specific description.
- The demo emits its event with `time()` rather than a random future timestamp.

### Fixed
- The demo listener now runs: it implements `handle()` (the dispatcher's contract) instead of `__invoke()`, so the events feature no longer appears broken.
- The bootstrap validates `APP_BASE_PATH` (must resolve to a readable directory, otherwise warns and falls back to `./app`) and fixes a typo in the autoload error message.
