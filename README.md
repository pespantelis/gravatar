# Gravatar
[Gravatar](http://gravatar.com/) is a service for providing globally unique avatars.

## Installation

Begin by installing this package through Composer.
```
composer require pespantelis/gravatar
```

## Usage

#### Create and initialize a gravatar url builder.
```php
<?php

// require the Gravatar autoloader
require 'vendor/autoload.php';

// set options (optional)
$options = [
  'size' => 256,
  'default-image' => 'identicon',
  'force-default' => false,
  'rating' => 'pg',
  'secure' => true
];

$gravatar = new Peslis\Gravatar\Factory($options);
```

#### Generate a Gravatar url for the requested email.
```php
echo $gravatar->url('pespantelis@gmail.com');
```

#### Check if the requested email has an associated image.
```php
echo $gravatar->exists('pespantelis@gmail.com');
// or
echo $gravatar->url('pespantelis@gmail.com')->exists();
```

#### Override the [options](http://gravatar.com/site/implement/images/).
```php
// size
echo $gravatar->url('pespantelis@gmail.com', 256);
// or
echo $gravatar->url('pespantelis@gmail.com')->size(256);

// secure requests
echo $gravatar->url('pespantelis@gmail.com')->secure();

// default image
echo $gravatar->url('pespantelis@gmail.com')->defaultImage('identicon');

// force default image
echo $gravatar->url('pespantelis@gmail.com')->forceDefault();

// rating level
echo $gravatar->url('pespantelis@gmail.com')->rating('pg');
```

#### Method chaining to set options.
```php
echo $gravatar->url('pespantelis@gmail.com', 256)->defaultImage('identicon')->rating('pg');
```

## Laravel Extension
If you are a Laravel user, there is a README.md [here](http://github.com/pespantelis/gravatar/blob/master/src/Laravel/README.md).

## License
Gravatar is released under the MIT Licence. See the bundled LICENSE file for details.
