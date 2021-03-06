# Phpcraft Proxy

A Minecraft: Java Edition proxy based on Phpcraft.

> **This project has been abandoned!** The limited subset of 1.8.x - 1.15.x that has been implemented should work fine. If and how anything after that works is entirely dependant on what changed about the protocol.

## Prerequisites

You'll need PHP, Composer, and Git.

### Instructions

- **Debian**: `apt-get -y install php-cli composer git`
- **Windows**:
  1. Install [Cone](https://getcone.org), which will install the latest PHP with it.
  2. Run `cone get composer` as administrator.
  3. Install [Git for Windows](https://git-scm.com/download/win).

## Setup

First, we'll clone the repository and generate the autoload script:

```Bash
git clone https://github.com/Phpcraft/proxy
cd proxy
composer install --no-suggest --ignore-platform-reqs
```

Next, we'll run a self check:

```Bash
php vendor/craft/core/selfcheck.php
```

If any dependencies are missing, follow the instructions, and then run the self check again.

### That's it!

Now that you've got the proxy all set up, you can start it using:

```Bash
php proxy.php
```

## Updating

To update the proxy and its dependencies:

``` Bash
git stash
git pull
composer update --no-dev --no-suggest --ignore-platform-reqs
git stash pop
``` 

If you have made local changes, they will be saved and re-applied after the update.
