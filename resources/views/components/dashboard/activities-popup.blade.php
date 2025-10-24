<!-- It is never too late to be what you might have been. - George Eliot -->
@php
    $modal_id = 'add-activity-modal';
@endphp

<div id="{{ $modal_id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-101 w-full h-modal">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto mx-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-slate-800">
            <button type="button"
                class="absolute top-2 right-2 text-slate-400 hover:bg-slate-200 rounded p-1.5 dark:hover:bg-slate-700"
                data-modal-hide="{{ $modal_id }}">
                <span class="sr-only">Close</span>
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="p-6 pt-10">
                <div class="flex items-end justify-between flex-wrap gap-4">
                    <div>
                        <h3 id="add-activity-modal-title"
                            class="text-lg font-medium text-slate-900 dark:text-slate-100">
                            Add activity
                        </h3>
                        <p id="add-activity-modal-subtitle" class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Select an activity and optionally set duration to calculate calories burned.
                        </p>
                    </div>
                    <x-mm-input name="activity-popup-search" placeholder="Search activity" />
                </div>

                <form id="add-activity-form" method="POST" action="#" class="mt-4">
                    @csrf
                    <input type="hidden" name="code" id="add-activity-code" value="">
                    <input type="hidden" name="time_spent" id="add-activity-time-spent" value="">
                    <input type="hidden" name="date" id="add-activity-date" value="{{ $date }}">
                </form>

                <div id="activity-popup-grid" class="mt-4">
                    @include('components.dashboard.activity-grid', ['activities' => $activities])
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script>
        (function() {
            const input = document.getElementById('activity-popup-search');
            const grid = document.getElementById('activity-popup-grid');
            if (!input || !grid) return;

            const original_html = grid.innerHTML;
            let timer = null;
            const DEBOUNCE = 300;
            const MIN = 2;

            function restore() {
                grid.innerHTML = original_html;
            }

            async function doSearch(q) {
                if (!q || q.length < MIN) {
                    restore();
                    return;
                }
                try {
                    grid.innerHTML = '<div class="text-sm text-slate-500 p-3">Searching…</div>';
                    const url = new URL("{{ route('activities.search') }}", window.location.origin);
                    url.searchParams.set('q', q);
                    const res = await fetch(url.toString(), {
                        credentials: 'same-origin'
                    });
                    if (!res.ok) throw new Error('Search failed');
                    const payload = await res.json();
                    grid.innerHTML = payload.html;
                } catch (err) {
                    console.error(err);
                    grid.innerHTML = '<div class="text-sm text-mm-error p-3">Search failed.</div>';
                }
            }

            input.addEventListener('input', (e) => {
                clearTimeout(timer);
                timer = setTimeout(() => doSearch(e.target.value.trim()), DEBOUNCE);
            });
        })();

        /* submit when Add clicked */
        (function() {
            const form = document.getElementById('add-activity-form');
            const activity_code_input = document.getElementById('add-activity-code');
            const activity_time_spent = document.getElementById('add-activity-time-spent');

            async function submitActivityAdd(activity_code, time_spent) {
                showGlobalLoader();

                form.action = `/user/activities/${encodeURIComponent(activity_code)}`;

                activity_code_input.value = activity_code;
                activity_time_spent.value = time_spent;

                form.submit();
            }

            document.addEventListener('click', function(ev) {
                const btn = ev.target.closest('.activity-add-btn');
                if (!btn) return;

                const activity_code = btn.dataset.activityCode;
                const time_input = document.querySelector(`[data-activity-time-input="${activity_code}"]`);

                const time_input_val = Number(time_input.value) || 0;
                if (time_input_val <= 0) {
                    alert('Please enter a time spent greater than 0.');
                    return;
                }

                submitActivityAdd(activity_code, time_input_val);
            });
        })
        ();
    </script>
@endpushOnce
