# Domains
Domains for WordPress Multisite. 

Requires WordPress 4.5+. Specifically meant for using domains on *subdirectory* Multisite installs.

_Note: This plugin **does not** replace all URLs in the database so that everything is server from the right URL at all times. Therefore, it is recommended to install this immediately after creating a multisite install._

## Installation
If you're using Composer to manage WordPress, add this plugin to your project's dependencies. Run:
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

1. [Define the correct constants](#constants) in your WordPress configuration file (default: `wp-config.php`)
2. [Configure the `.domains` file](#configuration), which is the main configuration file for this plugin

### Constants

```php
define('SUNRISE', true);
```

This activates a WordPress drop-in plugin called `sunrise.php`. Allows this plugin to perform actions right before Multisite is loaded.

```php
define('CONTENT_DIR', '/app');
```

This is only necessary if your content folder is not located in the default `/wp-content` folder. The example above uses `/app`.

```php
define('DOMAIN_CURRENT_SITE', 'www.example.com');
```

Probably not necessary to say, but this should be defined when using Multisite. This plugin relies on it being defined as well.

#### Omit these constants

Never define the following constants when using Multisite and this plugin:

- `WP_CONTENT_URL` - should be defined by this plugin
- `WP_HOME` - not used by Multisite
- `WP_SITEURL` - not used by Multisite

### Configuration

The `.domains` file is the main configuration file for this plugin and contains all domains. It is set up in the format `blogId:url`. For example:

```
2:www.example.com
3:www.example.org
```

The domains file should be located in the root of your project. This file should probably be excluded from version control, since enviroments are usually run on different URLs. When using [Capistrano](http://capistranorb.com/) for deployment, it should be defined as a linked file.

_Note: This plugin searches for the `.domains` file in the folder where WordPress is located and a maximum of two folders up._
