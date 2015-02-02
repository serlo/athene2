# Status

[![Gitter chat](https://badges.gitter.im/gitterHQ/gitter.png)](https://gitter.im/serlo-org)  
[![Build Status](https://travis-ci.org/serlo-org/athene2.svg)](https://travis-ci.org/serlo-org/athene2)  
[![Code Coverage](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/coverage.png?s=1d2264eb2b7376e91de5a8f58574da83fd156045)](https://scrutinizer-ci.com/g/serlo-org/athene2/)  
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/quality-score.png?s=f163d3b21f6d3aeed19dd082958e71e544d6686e)](https://scrutinizer-ci.com/g/serlo-org/athene2/)

# Docs

There is an incomplete guide of Athene2 here: [Athene2 Guide](http://serlo-org.github.com/athene2-guide)

# Contributing

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
