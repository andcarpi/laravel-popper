@if(Popper::hasThemes() or config('popper.fix-bs3'))
    <script type="text/javascript">function injectCSS(e){if("undefined"!=typeof window&&"undefined"!=typeof document){var t=document.createElement("style");t.type="text/css",t.textContent=e,t.setAttribute("data-tippy-stylesheet","");var n=document.head,d=n.querySelector("style,link");d?n.insertBefore(t,d):n.appendChild(t)}}</script>
    @if(config('popper.fix-bs3'))
        <script type="text/javascript">injectCSS('.tippy-tooltip{font-size:.9rem;padding:.3rem .6rem}')</script>
    @endif
    {{ Popper::injectThemes() }}
@endif
@if(! Config::has('popper'))
    <script src="https://unpkg.com/popper.js@1"></script>
    <script src="https://unpkg.com/tippy.js@4"></script>
@else
    {{--POPPER--}}
    @if(config('popper.popper.active'))
        <script @if(config('popper.popper.mode') == 'cdn') src="{{config('popper.popper.cdn')}}" @else src="{{asset(config('popper.popper.asset'))}}" @endif></script>
    @endif
    {{--TIPPY--}}
    @if(config('popper.tippy.active'))
        <script @if(config('popper.tippy.mode') == 'cdn') src="{{config('popper.tippy.cdn')}}" @else src="{{asset(config('popper.tippy.asset'))}}" @endif></script>
    @endif
@endif