<div id="{{ $id }}" data-modal="hidden" class="bg-black/10 w-screen h-screen absolute top-0 grid place-items-center overflow-auto z-30 data-[modal=hidden]:hidden opacity-0 data-[modal=visible]:opacity-100 backdrop-blur-0 data-[modal=visible]:backdrop-blur-sm transition-all duration-200">
    <div data-modal-child class="shadow-highlight flex flex-col p-8 bg-yellow-50 my-5 rounded-md translate-y-8 data-[modal-child=visible]:-translate-y-8 transition-all ease-out duration-300">
        <div class="text-2xl font-semibold border-b-2 border-yellow-900/10">
            {{ $header ?? ''}}
        </div>
        {{ $slot }}
        {{ $footer ?? '' }}
        <button data-modal-close class="absolute h-0 bottom-0 self-center text-black/50">click blank area to close</button>
    </div>
</div>