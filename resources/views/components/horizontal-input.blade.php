<div class="grid grid-cols-12 gap-2 mt-2">
    <label for="{{ $id }}" class="col-span-{{ $labelSpan }} content-center font-semibold text-nowrap grid">{{ $label }}</label>
    <div class="col-span-{{ 12 - $labelSpan }} border-2 border-black rounded-[7px] flex-grow">
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" value="{{ $value }}" @if ($required === true) required @endif @foreach ($others as $item) {{ $item }} @endforeach class="w-full max-h-[37px] px-1 py-1 bg-yellow-700/5 rounded-[5px] border-l-2 border-t-4 border-yellow-700/10 placeholder:font-semibold placeholder:text-yellow-950/50 focus:placeholder:opacity-0 focus:placeholder:translate-x-12 placeholder:transition-all">
    </div>

</div>
