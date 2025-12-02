<div
    x-data="{ shown: false, timeout: null }"
    x-init="clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 5000);"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    class="fixed top-0 right-0 w-auto m-4 px-4 py-2 bg-sky-100 border border-sky-300 text-sky-800 rounded-lg shadow-md">
    {{ $slot }}
</div>
