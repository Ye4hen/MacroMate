@if (session("success"))
    <div
        id="flash-message"
        class="fixed top-0 -inset-x-0 z-50 text-center bg-green-50 border border-green-200 text-green-800 px-4 py-2 rounded transition duration-500"
    >
        {{ session("success") }}
    </div>
@endif

@if (session("error"))
    <div
        id="flash-message"
        class="fixed top-0 -inset-x-0 z-50 text-center bg-red-50 border border-red-200 text-red-800 px-4 py-2 rounded transition duration-500"
    >
        {{ session("error") }}
    </div>
@endif
