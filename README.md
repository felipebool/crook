[![Build Status](https://travis-ci.org/felipebool/crook.svg?branch=master)](https://travis-ci.org/felipebool/crook)
[![Maintainability](https://api.codeclimate.com/v1/badges/dda7bbc045a955530da4/maintainability)](https://codeclimate.com/github/felipebool/crook/maintainability)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2849859fd1ad4d299bf7403a85171319)](https://www.codacy.com/app/felipebool/crook?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=felipebool/crook&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/2849859fd1ad4d299bf7403a85171319)](https://www.codacy.com/app/felipebool/crook?utm_source=github.com&utm_medium=referral&utm_content=felipebool/crook&utm_campaign=Badge_Coverage)

# Crook
First of all, Crook is a work in progress.

If you are not familiar with git hooks, you may want to read [Git Hooks documentation](https://git-scm.com/docs/githooks) first.

Crook is the simplest way to define and manage your Git Hooks. Its aim is to allow scripts from your composer.json run when git hook actions are triggered. 

## Usage
The aim of this project is to be as simple as possible, thus, you won't have to write any PHP code, you just need to install any packages from packagist and then make them run for partucular git hooks. The process is explained in the following sections.

### Init Crook
```$ vendor/bin/crook init``` will create crook.json configuration file and theHook in the root of your project.

### Add a new hook
```$ vendor/bin/crook add hook-name action-name``` will create a symbolic link from .git/hooks/hook-name to theHook, enabling that hook.

### Remove a hook
```$ vendor/bin/crook remove hook-name``` will remove the symbolic link .git/hooks/hook-name, disabling that hook.

### Add a action to composer.json
When you add a new action using ```add``` you need to add what is expected to run when that action is triggered inside you composer.json. To do that, you must create a new entry inside the section ```scripts``` and then define what must run there.

## Crook configuration file
Crook uses a json configuration file just like composer, it is called crook.json. The configuration is made, basically, by writting as a key the git hook name and as value the respective script entry in composer.json. See the following example
```json
{
  "pre-commit": "code-check",
  "composer": "/home/felipe/bin/composer"
}
```
Although you are able to edit crook.json by yourself, you should do it using ```$ vendor/bin/crook``` in order to create the symbolic links. The mechanism is explained in the next section.

## The mechanism
Every time you run a
```vendor/bin/crook add hook-name action-name```
Crook creates a symbolic link from .git/hooks/hook-name to /you/project/hook/theHook, simple as that.

Now, when git trigger the action hook-name, it will follow the link to /your/project/hook/theHook and Crook will then look for a script named action-name inside your project's composer.json and will execute the commands defined there.

### Adding code validation using phpcs before any commit
In order to check your code against PSR2, you must do this

#### Add the script action inside composer.json
```
"scripts": {
  "code-check": "phpcs --standard=PSR2 src/",
}
```

#### Initialize crook
```$ vendor/bin/crook init```

#### Bind code-check to pre-commit hook
```$ vendor/bin/crook add pre-commit code-check```

Next time you run ```$ git commit -m 'some message'``` crook will run the code defined inside code-check and will prevent code from being commited if the check fail.

