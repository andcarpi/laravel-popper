@if(config('popper.files.mode') != 'asset')
    <script src="https://unpkg.com/popper.js@1"></script>
    <script src="https://unpkg.com/tippy.js@4"></script>
@else
    @foreach(config('popper.files.asset_paths') as $assetpath)
        <script src="{{asset($assetpath)}}"></script>
    @endforeach
@endif

