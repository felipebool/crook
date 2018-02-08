[![Build Status](https://travis-ci.org/felipebool/crook.svg?branch=master)](https://travis-ci.org/felipebool/crook)
# crook
First of all, Crook is a work in progress. This tool is intended to integrate composer scripts to git hoooks.

## Usage
The usage is not well defined yet, but I'm working on it.

## Crook configuration file
Crook uses a json configuration file just like composer and it is called crook.json. The configuration is made, basically, by writting as a key the git hook name and as value the respective script entry in composer.json. See the following example
```json
{
  "pre-commit": "code-check",
  "composer": "/home/felipe/bin/composer"
}
```
## The mechanism
I'm still working on this, but now it is based on symbolic links, which I'm creating manually.
