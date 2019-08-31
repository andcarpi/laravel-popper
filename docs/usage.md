# Usage

To use Popper in your views, you need some assets, so use this
 
```
@include('popper::assets')
``` 

in the views you need tooltips, right before the body closing tag. 
> ps: If you have a Master View, add the assets on it :)

```
   @include(popper::assets)
</body>
```

Now, let's generate a tooltip. Just use the Popper facade inside any html element.

```
<button {{ Popper::pop('Tooltip!') }}>Click Me!</button
```

The Popper facade also has a lot a of functions to customize each tooltip before popping it!

Check them here!