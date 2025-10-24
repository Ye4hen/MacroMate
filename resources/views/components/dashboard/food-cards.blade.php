<!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->

@php use App\Enums\FoodTypeEnum; @endphp

@forelse($foods as $food)
    @php
        $code = $food->mf_code;
        $name = $food->mf_name;
        $img = $food->getImageVariantUrl('webp', 300);
        $cals = (int) $food->mf_cals;
        $unit_label = $food->mf_type === FoodTypeEnum::DRINK ? 'ml' : 'g';
    @endphp

    <div class="food-card bg-white dark:bg-slate-900 border rounded-lg p-3 flex items-start gap-3"
        data-food-code="{{ $code }}">
        <div class="flex-shrink-0">
            @if ($img)
                <img src="{{ $img }}" alt="Image of the {{ $name }}" class="w-14 h-14 rounded object-cover">
            @else
                <div
                    class="w-14 h-14 rounded bg-mm-light-gray flex items-center justify-center text-sm text-mm-gray">
                    N/A
                </div>
            @endif
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2 flex-wrap">
                <div>
                    <div class="font-medium text-slate-800 dark:text-slate-100 break-word">{{ $name }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        {{ $cals ?? '—' }} kcal / 100{{ $unit_label }}
                    </div>
                </div>

                <div class="text-right ml-auto">
                    <div class="flex items-center gap-2">
                        <x-mm-input type="number" name="quantity_{{ $code }}"
                            label="{{ $unit_label === 'ml' ? 'ml' : 'grams' }}"
                            data-food-qty-input="{{ $code }}" min="0" step="0.1" value="100" />
                    </div>
                    <div class="mt-2">
                        <x-mm-button type="button" class="food-add-btn inline-flex items-center px-3 py-1"
                            data-food-code="{{ $code }}" data-food-unit="{{ $unit_label }}" variant="accent"
                            title="Add {{ $name }}">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Add
                        </x-mm-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="text-sm text-slate-500">No foods found.</div>
@endforelse

@if (!$is_last)
    <div class="food-sentinel h-2" data-next-url="{{ route('foods.more', ['page' => $page + 1]) }}"
        aria-hidden="true" />
@endif

@pushOnce('scripts')
    <script>
        (function() {
            async function initFoodInfinite() {
                const grid_wrapper = document.getElementById('food-popup-grid');
                if (!grid_wrapper) return;

                const scroll_container = grid_wrapper.querySelector('#food-grid');
                if (!scroll_container) return;

                let loading = false;
                let observer;

                function observeSentinel(sentinel) {
                    if (!sentinel) {
                        if (observer) {
                            observer.disconnect();
                            observer = null;
                        }
                        return;
                    }

                    if (observer) observer.disconnect();

                    observer = new IntersectionObserver(async (entries) => {
                        for (const entry of entries) {
                            if (!entry.isIntersecting) continue;
                            if (loading) return;

                            loading = true;
                            const s = entry.target;
                            const url = s.dataset.nextUrl;
                            if (!url) {
                                loading = false;
                                observer.disconnect();
                                return;
                            }

                            s.classList.add('opacity-50');

                            try {
                                const res = await fetch(url, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'text/html'
                                    }
                                });

                                if (!res.ok) throw new Error('Failed to load page');

                                const html = await res.text();

                                s.insertAdjacentHTML('afterend', html);
                                s.remove();

                                const new_sentinel = grid_wrapper.querySelector('.food-sentinel');
                                if (new_sentinel) {
                                    observeSentinel(new_sentinel);
                                } else {
                                    if (observer) {
                                        observer.disconnect();
                                        observer = null;
                                    }
                                }
                            } catch (err) {
                                console.error('load more foods failed', err);
                            } finally {
                                loading = false;
                            }
                        }
                    }, {
                        root: scroll_container,
                        rootMargin: '0px',
                        threshold: 0.1
                    });

                    observer.observe(sentinel);
                }

                const first_sentinel = grid_wrapper.querySelector('.food-sentinel');
                if (first_sentinel) observeSentinel(first_sentinel);

                document.addEventListener('click', (ev) => {
                    const btn = ev.target.closest(
                        '[data-modal-target="#add-food-modal"], [data-modal-toggle="add-food-modal"], [data-modal-target="add-food-modal"]'
                        );
                    if (!btn) return;
                    setTimeout(() => {
                        const s = grid_wrapper.querySelector('.food-sentinel');
                        if (s) observeSentinel(s);
                    }, 120);
                }, true);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initFoodInfinite);
            } else {
                initFoodInfinite();
            }
        })
        ();
    </script>
@endpushOnce
