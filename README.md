# Laravel Popper

This package provides an easy way to add tooltips in your Laravel blade views. Powered by Popper.js and Tippy.js.
With this, you will not lose time getting them done. Install and use, out of the box. 

## Install

First things, first... Use composer to install the package:

```
composer require andcarpi/laravel-popper
```

## Setup

When composer finish his job, add the Service Provider to your app.config in the config folder:

```
'providers' => [
    // ...
    // List of Service Providers...
    // ...
    andcarpi\Popper\PopperServiceProvider::class,
],
```

And to finish it, add the popper assets with
 
```
@include('popper::assets')
``` 

in the views you need tooltips, right before the body closing tag. 
> ps: If you have a Master View, add the assets on it :)

```
   @include(popper::assets)
</body>
```

## Usage

Now, it's time to use it. To generate a simple tooltip, just use the Popper facade inside any html element.

```
<button {{ Popper::pop('Tooltip!') }}>Click Me!</button
```

## License

Laravel Popper is open-sourced software licensed under the MIT License (MIT). Please see [License File](LICENSE.md) for more information.
