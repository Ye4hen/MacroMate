<!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
@extends("layouts.app")

@section("title", "Admin Panel. Activities.")

@section("content")
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between mb-4">
            <h1 class="title">Activities Admin</h1>

            <x-mm-button
                href="{{ route('admin.activities.create') }}"
                variant="accent"
                label="Add activity"
                class="shadow inline-flex items-center gap-2"
            />
        </div>

        <form method="GET" class="mb-4" onsubmit="return false;">
            <div class="flex gap-2">
                <div class="relative w-full">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>

                    <x-mm-input
                        name="q"
                        id="admin_activities_q"
                        :value="$q ?? ''"
                        placeholder="Search name/code"
                        class="pl-10 pr-3 py-2 rounded-lg bg-transparent"
                        autocomplete="off"
                    />

                    <div
                        id="admin-activities-search-results"
                        class="absolute left-0 w-full mt-2 rounded bg-mm-accent border border-mm-border z-50 hidden"
                        style="display: none"
                    >
                        <div
                            id="admin-activities-search-list"
                            class="divide-y divide-gray-700 max-h-80 overflow-auto"
                        ></div>
                    </div>
                </div>
            </div>
        </form>

        <div
            class="overflow-x-auto relative border border-mm-border bg-mm-card shadow-sm rounded-lg"
        >
            <table class="w-full text-sm text-left">
                <thead
                    class="uppercase text-xs text-mm-light-gray"
                    style="background: rgba(255, 255, 255, 0.03)"
                >
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Cals/hour</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr class="border-t border-mm-border">
                            <td class="px-4 py-3 align-middle">
                                <div>
                                    <div class="font-medium text-white">
                                        {{ $activity->ma_name }}
                                    </div>
                                </div>
                            </td>

                            <td
                                class="px-4 py-3 align-middle text-mm-light-gray"
                            >
                                {{ $activity->ma_cals }}
                            </td>

                            <td class="px-4 py-3 align-middle">
                                <div class="flex items-center gap-2">
                                    <x-mm-button
                                        href="{{ route('admin.activities.edit', $activity->ma_code) }}"
                                        label="Edit"
                                        variant="secondary"
                                        class="px-3 py-1 text-sm"
                                    />

                                    <form
                                        method="POST"
                                        action="{{ route("admin.activities.destroy", $activity->ma_code) }}"
                                        onsubmit="return confirm('Delete this activity?');"
                                    >
                                        @csrf
                                        @method("DELETE")
                                        <x-mm-button
                                            type="submit"
                                            label="Delete"
                                            variant="danger"
                                            class="px-3 py-1 text-sm"
                                        />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($activities->isEmpty())
                        <tr>
                            <td
                                colspan="6"
                                class="px-4 py-6 text-center text-mm-light-gray"
                            >
                                No activities found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="p-4 flex items-center justify-between">
                <div class="text-mm-gray">
                    {{ $activities->total() }} results
                </div>
                <div>
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        (function () {
            function debounce(fn, wait) {
                let t;
                return function (...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), wait);
                };
            }

            const input = document.getElementById('admin_activities_q');
            const results_panel = document.getElementById(
                'admin-activities-search-results',
            );
            const results_list = document.getElementById(
                'admin-activities-search-list',
            );

            const search_url = '{{ route("admin.activities.search") }}';

            async function doSearch(q) {
                if (!q || !q.trim().length) {
                    results_panel.style.display = 'none';
                    results_list.innerHTML = '';
                    return;
                }

                try {
                    const params = new URLSearchParams({
                        q: q.trim(),
                    });
                    const res = await fetch(
                        search_url + '?' + params.toString(),
                        {
                            headers: {
                                Accept: 'application/json',
                            },
                        },
                    );

                    if (!res.ok) {
                        results_panel.style.display = 'none';
                        results_list.innerHTML = '';
                        return;
                    }

                    const payload = await res.json();
                    const items = payload.results || [];

                    if (!items.length) {
                        results_list.innerHTML =
                            '<div class="p-3 text-sm text-mm-light-gray">No results</div>';
                        results_panel.style.display = 'block';
                        return;
                    }

                    results_list.innerHTML = items
                        .map((item) => {
                            return `
                    <a href="/admin/activities/${encodeURIComponent(item.code)}/edit" class="flex items-center p-3 hover:bg-mm-accent-hover transition-colors">
                        <div class="text-sm">
                            <div class="font-medium text-white">${item.name}</div>
                            <div class="text-xs text-mm-light-gray">${item.code} · ${item.cals ?? ''} kcal</div>
                        </div>
                    </a>
                `;
                        })
                        .join('');

                    results_panel.style.display = 'block';
                } catch (err) {
                    console.error('Search error', err);
                    results_panel.style.display = 'none';
                    results_list.innerHTML = '';
                }
            }

            const debouncedSearch = debounce(function () {
                doSearch(input.value);
            }, 500);

            input.addEventListener('input', debouncedSearch);

            if (input.value) debouncedSearch();

            document.addEventListener('click', function (ev) {
                if (!results_panel.contains(ev.target) && ev.target !== input) {
                    results_panel.style.display = 'none';
                }
            });
        })();
    </script>
@endpush
