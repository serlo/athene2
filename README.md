# Status

[![Gitter chat](https://badges.gitter.im/gitterHQ/gitter.png)](https://gitter.im/serlo-org)  
[![Build Status](https://travis-ci.org/serlo-org/athene2.svg)](https://travis-ci.org/serlo-org/athene2)  
[![Code Coverage](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/coverage.png?s=1d2264eb2b7376e91de5a8f58574da83fd156045)](https://scrutinizer-ci.com/g/serlo-org/athene2/)  
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/serlo-org/athene2/badges/quality-score.png?s=f163d3b21f6d3aeed19dd082958e71e544d6686e)](https://scrutinizer-ci.com/g/serlo-org/athene2/)

# Docs

There is an incomplete guide of Athene2 here: [Athene2 Guide](http://serlo-org.github.com/athene2-guide)

# Cloning


# Workflow

**tl;dr**. Basically, the directory `src/asssets/athene2-editor` will be treated as a own git repository and the `athene2` repository just refers to the commit to use. So to make changes, we both have to commit changes to the `athene2-editor` repository and update the reference in `athene2` to the new commit. Furthermore, cloning and pulling must include the submodule, too.

## Cloning

Add `--resursive` to clone submodules, too.

```
git clone git@github.com:serlo-org/athene2.git --recursive
```

## Pulling external changes (for athene2 and athene2-editor)

As usual, pull athene2. Also update submodules

```
git submodule update --init --recursive
```

**Note:** *This does not pull the latest commit of athene2-editor, but the proper commit specified in the athene2 repository. If you want to update the version of athene2-editor, follow the directions below.*

## Committing changes to athene2-editor

Either change the submodule in athene2 or work with the athene2-editor repository directly.

### Make changes to the submodule

**tl;dr**. Commit the changes in `src/assets/athene2-editor` and push resp. submit pull requests as usual.

First, commit the changes in athene2-editor:

```
cd src/assets/athene2-editor
git checkout -b BRANCH
git add .
git commit
git push -u REMOTE BRANCH
```

Now you can submit a pull request to athene2-editor.

### Directly modify athene2-editor

As usual, make changes to athene2-editor, and submit a pull request to athene2-editor.

## Updating the editor in the athene2 repository

**tl;dr**. Pull the changes in `src/assets/athene2-editor` and commit `src/assets/athene2-editor` (will be treaded as a file by the `athene2` directory and contains the reference to the `athene2-editor` commit)

To update the editor in athene2 (for example, after a pull request got merged), follow these steps:

```
git checkout -b BRANCH
cd src/assets/athene2-editor
git pull origin master
cd ..
git add athene2-editor
git commit
git push -u REMOTE BRANCH
```

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
