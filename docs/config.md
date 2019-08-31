# Custom Configuration

First of all, publish the configuration file:

```
php artisan vendor:publish --provider="andcarpi\Popper\PopperServiceProvider" --tag=config
```

The file will be placed inside your config folder. 

Each option is self-explanatory, and you can modify the default behavior of all the tooltips you generate.

If you want to modify a single tooltip, check the [available functions](functions.md)