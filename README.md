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

## Configuration

### Custom Tooltip Options 

You can change the Tooltip default options publishing and editing the config file.

```
php artisan vendor:publish --provider="andcarpi\Popper\PopperServiceProvider" --tag=config
```

The file will be placed inside your config folder. 

Each option is self-explanatory, and you can modify the default behavior of all the tooltips you generate.

### Single Tooltip Options

Each tooltip can be customized using functions. They can also be chained!

- Enable Arrows in the tooltip
```
{{ Popper::arrow()->pop('Tooltip with arrow!'); }}
{{ Popper::arrow('round')->pop('Tooltip with a rounded arrow!'); }}
```

- Modify Tooltip Placement
```
{{ Popper::placement('bottom', 'start')->pop('Bottom Tooltip!'); //position, alignment }}
{{ Popper::position('left')->pop('Left Tooltip!'); // top, right, bottom, left }}
{{ Popper::alignment('end')->pop('Tooltip with end alignment!'); // start, center, end }}
```

- Modify Tooltip distance from the element
```
//Use integers!
{{ Popper::distance(50)->pop('Tooltip far away!'); }}
```

- Modify Tooltip size
```
{{ Popper::size('small')->pop('Small tooltip!'); // 'small', 'regular', 'large' }}
```

- Modify Tooltip Triggers (What will make tooltip appear)
```
// 1st param is mouseenter, 2nd is focus, 3rd is click
{{ Popper::trigger(true, true, false)->pop('This tooltip appears onmouseover and onfocus!'); }} 
```

- Modify Tooltip Show and Hide Delay
```
// Use integer values! 
{{ Popper::delay(500,0)->pop('500ms to appear, but vanishes instantly!');  }}
```

- Options Chain!
```
{{ Popper::arrow()->size('large')->distance(50)->position('bottom')->pop('Arrow, Large, Far and at Bottom!'); }}
```

## License

Laravel Popper is open-sourced software licensed under the MIT License (MIT). Please see [License File](LICENSE.md) for more information.
