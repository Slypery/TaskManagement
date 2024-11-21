<div class="grid grid-cols-12 gap-2 mt-2">
    <label for="{{ $id }}" class="col-span-{{ $label_span }} content-center font-semibold text-nowrap">{{ $label }}</label>
    <div class="col-span-{{ 12 - $label_span }} border-2 border-black rounded-[7px] flex-grow overflow-hidden">
        <select class="w-full py-1 bg-yellow-700/5 rounded-[5px] border-l-2 border-t-4 border-yellow-700/10"  name="{{ $name }}" id="{{ $id }}">
            {{ $slot }}
        </select>
    </div>
</div>
