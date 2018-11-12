# Changelog

All notable changes to this project will be documented in this file. The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

### Added

- Add `package.json` so that we can use `yarn` as task runner
- Add yarn script `start` that executes `docker-compose up`
- Add yarn script `format:prettier` that executes prettier (formats Markdown, YAML, JSON, etc.)
- Add yarn script `format:php` that executes php-cs-fixer (formats PHP according to PSR-2 with some additional rules)
- Add yarn script `license` that handles license headers in our source code files

### Changed

- Make list of unrevised revisions (e.g. https://de.serlo.org/mathe/entity/unrevised) faster ([#790](https://github.com/serlo-org/athene2/pull/790), [#780](https://github.com/serlo-org/athene2/pull/780))
- Show all unrevised revisions of an entity (and not only the newest one) ([#790](https://github.com/serlo-org/athene2/pull/790))

## [Build 2] - 2017-10-30

This release uses athene2-assets@3 (blue) ([Changelog](https://github.com/serlo-org/athene2-assets/blob/master/CHANGELOG.md))

### Added

- Allow special characters (e.g. `<`, `*`) in entities' fields (e.g. title, reasoning) ([#729](https://github.com/serlo-org/athene2/pull/729))
- Hide trashed entities and dead nodes in sorting actions (e.g. sorting of course pages) ([#752](https://github.com/serlo-org/athene2/pull/752))
- Allow sorting of trashed entities by timestamp ([#763](https://github.com/serlo-org/athene2/pull/763))
- Allow embedding of videos from BR Mediathek ([#775](https://github.com/serlo-org/athene2/pull/775))
- Add content type as meta data ([#777](https://github.com/serlo-org/athene2/pull/777))

### Changed

- Update translations ([#769](https://github.com/serlo-org/athene2/issues/769))
- Make [trash bin](https://de.serlo.org/uuid/recycle-bin) faster ([#763](https://github.com/serlo-org/athene2/pull/763))
- Enable newsletter pop-up on [Ressourcen für PädagogInnen](https://de.serlo.org/community/ressourcen-paedagoginnen) ([#778](https://github.com/serlo-org/athene2/pull/778))

### Fixed

- Using the same page alias on two different language tenants works as intended now ([#738](https://github.com/serlo-org/athene2/pull/738))
- Translate all strings used in the registration form ([#760](https://github.com/serlo-org/athene2/issues/760))
- Fix title on starting page ([#767](https://github.com/serlo-org/athene2/issues/767))
- Show only one side bar on entities' pages ([#771](https://github.com/serlo-org/athene2/issues/771))

## [Build 1] - 2017-10-05

[unreleased]: https://github.com/serlo-org/athene2/compare/2...HEAD
[build 2]: https://github.com/serlo-org/athene2/compare/e485b49b632799c6011e9ddf0be1efa56325a7ab...2
[build 1]: https://github.com/serlo-org/athene2/commit/e485b49b632799c6011e9ddf0be1efa56325a7ab
