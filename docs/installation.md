# Installation

First things, first... Use composer to install the package:

```
composer require andcarpi/laravel-popper
```

> Skip this in Laravel 5.5 or above

When composer finish his job, add the Service Provider to your app.config in the config folder:

```
'providers' => [
    // ...
    // List of Service Providers...
    // ...
    andcarpi\Popper\PopperServiceProvider::class,
],
```

You can also [publish the config file](config.md) to modify the tooltip behavior, but the package works out of the box!