# **phplx** Prize Raffle Console Application

[![Build Status](https://secure.travis-ci.org/phplx/prize-raffle-console-app.png?branch=master)](http://travis-ci.org/phplx/prize-raffle-console-app) [![Latest Stable Version](https://poser.pugx.org/phplx/prize-raffle-console-app/v/stable.png)](https://packagist.org/packages/phplx/prize-raffle-console-app) [![Total Downloads](https://poser.pugx.org/phplx/prize-raffle-console-app/downloads.png)](https://packagist.org/packages/phplx/prize-raffle-console-app) [![Latest Unstable Version](https://poser.pugx.org/phplx/prize-raffle-console-app/v/unstable.png)](https://packagist.org/packages/phplx/prize-raffle-console-app) [![License](https://poser.pugx.org/phplx/prize-raffle-console-app/license.png)](https://packagist.org/packages/phplx/prize-raffle-console-app) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/phplx/prize-raffle-console-app/badges/quality-score.png?s=72524ae87dea871365424192e3d6c3c545f538f5)](https://scrutinizer-ci.com/g/phplx/prize-raffle-console-app/) [![Code Coverage](https://scrutinizer-ci.com/g/phplx/prize-raffle-console-app/badges/coverage.png?s=4b76af8791a4609fbe569103f1d8987919e38045)](https://scrutinizer-ci.com/g/phplx/prize-raffle-console-app/) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/58b5aff5-2709-4ae7-8a3e-0f714c0115bd/mini.png)](https://insight.sensiolabs.com/projects/58b5aff5-2709-4ae7-8a3e-0f714c0115bd)

What this application do:

 * Get attendees by event from a Provider (actually only Eventbrite is available)
 * Load prizes from a **file**
 * Save **Event** and **Winners**
 * Raffle prizes
 * Tweet the winner with the respective prize

## How to use

```
# clone the repo
git clone git@github.com:phplx/prize-raffle-console-app.git
cd prize-raffle-console-app

# [Optional] Using Vagrant
vagrant up
vagrant ssh
cd /vagrant

# download composer
curl -sS https://getcomposer.org/installer | php
php composer.phar install -o --dev

# Run
php bin/phplx.php

# or
./bin/phplx

# Run tests
./vendor/bin/phpunit
```

## TODO

 * Add new commands like **listing all events**, **send email to winner**.
 * Add more **DataAdapters** and **Providers**
 * Make the twitter username maps dynamically without knowing the question text in the Eventbrite Provider

## Sponsor by

[![phplx](https://secure.gravatar.com/avatar/c67d21c0c2ba2be3bfe2c550039fc5d3?s=100)](http://phplx.net)

## LICENSE

Licensed under the [MIT LICENSE](https://github.com/phplx/prize-raffle-console-app/blob/master/LICENSE)
