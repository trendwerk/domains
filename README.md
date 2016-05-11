# Domains
Domains for WordPress Multisite. 

Requires WordPress 4.5+. Specifically meant for using domains on *subdirectory* Multisite installs.

## Installation
This plugin needs Composer to manage WordPress. To add this plugin to your project's development dependencies, run:
```sh
composer require trendwerk/domains 0.1.0
```

Or manually add it to your `composer.json`:
```json
"require": {
	"trendwerk/domains": "0.1.0"
},
```

## Setup
The basic setup of this plugin consists of two steps:

1. [Define the correct constants](#constants) in your WordPress config file (default: `wp-config.php`)
2. [Setup the `.domains`](#domains-1) file which this plugin reads from

_Note: This plugin **does not** replace all URLs in the database so that everything is server from the right URL at all times. Therefore, it is recommended to install this immediately after creating a multisite install._

### Constants

#### SUNRISE

```php
define('SUNRISE', true);
```

This activates a WordPress drop-in plugin called `sunrise.php`. Allows this plugin to perform actions right before Multisite is loaded.

#### CONTENT_DIR

```php
define('CONTENT_DIR', '/app');
```

This is only necessary if your content folder is not located in the default `/wp-content` folder. The example above uses `/app`.

#### DOMAIN\_CURRENT\_SITE

```php
define('DOMAIN_CURRENT_SITE', 'www.example.com');
```

Probably not necessary to say, but this should be defined when using Multisite.

#### Omit these constants

Never define the following constants when using Multisite and this plugin:

- `WP_CONTENT_URL` - should be defined by this plugin
- `WP_HOME` - not used by Multisite
- `WP_SITEURL` - not used by Multisite

### .domains

