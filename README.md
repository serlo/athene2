# Status

| Branch  | Status        | Coverage  | Quality |
| ------- | ------------- | --------- | ------- |
| Master        | [![Build Status](https://magnum.travis-ci.com/serlo-org/athene2.png?token=gtodfPz6nLDS6xphYxdJ&branch=master)](https://magnum.travis-ci.com/serlo-org/athene2)              | [![Code Coverage](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/coverage.png?s=1d2264eb2b7376e91de5a8f58574da83fd156045)](https://scrutinizer-ci.com/g/serlo-org/athene2/)          | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/quality-score.png?s=f163d3b21f6d3aeed19dd082958e71e544d6686e)](https://scrutinizer-ci.com/g/serlo-org/athene2/)        |
| PTR        | [![Build Status](https://magnum.travis-ci.com/serlo-org/athene2.png?token=gtodfPz6nLDS6xphYxdJ&branch=ptr)](https://magnum.travis-ci.com/serlo-org/athene2)              | [![Code Coverage](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/coverage.png?s=1d2264eb2b7376e91de5a8f58574da83fd156045)](https://scrutinizer-ci.com/g/serlo-org/athene2/)          | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/quality-score.png?s=f163d3b21f6d3aeed19dd082958e71e544d6686e)](https://scrutinizer-ci.com/g/serlo-org/athene2/)       |
| Develop        | [![Build Status](https://magnum.travis-ci.com/serlo-org/athene2.png?token=gtodfPz6nLDS6xphYxdJ&branch=develop)](https://magnum.travis-ci.com/serlo-org/athene2)              | [![Code Coverage](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/coverage.png?s=1d2264eb2b7376e91de5a8f58574da83fd156045)](https://scrutinizer-ci.com/g/serlo-org/athene2/)          | [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/quality-score.png?s=f163d3b21f6d3aeed19dd082958e71e544d6686e)](https://scrutinizer-ci.com/g/serlo-org/athene2/)        |

# Commit rules

## Branches

Always open up new branches for your commits.
Do not commit into `develop` (unstable), `master` (stable) or `ptr` (beta) directly.
Those branches deploy automatically and may break stuff.

### Branches for issues

If you're fixing an issue name the branch `solves-issueid`.

Examples:
* `solves-233`
* `solves-313`

### Branches implementing feature requests

If you're implementing a new feature request, name the branch `implements-issueid`

Example:
* `implements-233`
* `implements-131`

### Branches for new features

If you're implementing a new feature name the branch `feature-my-feature`.

Examples: 

* `feature-database-caching`
* `feature-authorization`

### Create Pull Requests

Use rebase to bring your branches up to speed with the latest develop, master or ptr branch.
Now you can create a pull request which can be fast-forwarded (no merge necessary) instantly.

## Commit Messages

Example: Bad commit message
> finally fixed this dumb rendering bug that Joe talked about ... LOL
  -------------------------------------------------------------------
  also added another form field for password validation

Example: Good Commit Message
> BUG Formatting through prepValueForDB()
  -------------------------------------------------------------------
  Added prepValueForDB() which is called on DBField->writeToManipulation()
  to ensure formatting of value before insertion to DB on a per-DBField type basis (fixes #1234).
  Added documentation for DBField->writeToManipulation() (related to a4bd42fd).

# Code Rules

* Strictly follow [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md).

# Knowledge base

* Common ZF2 knowledge: http://zf2cheatsheet.com/
* ZF2 Docs: http://framework.zend.com/manual/2.2/en/index.html
* Doctrine Docs: http://docs.doctrine-project.org/en/latest/
* Doctrine ZF2 Module Docs: https://github.com/doctrine/DoctrineORMModule/tree/master/docs
* ZfcRbac Docs: https://github.com/ZF-Commons/zfc-rbac/tree/master/docs
* Athene2 Docs: http://serlo-org.github.io/athene2-guide

# Server Install

* Make sure to use fastmod-cgi
* Install all locales: `apt-get install locales-all`