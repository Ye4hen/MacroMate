@props([
    'id' => null,
    'title' => '',
    'ajax_url' => '',
    'metric' => 'calories',
    'initial_dates' => [],
    'initial_series' => [],
])

@php
    $chart_id = $id ?? 'chart-' . uniqid();
    $dropdown_id = $chart_id . '-dropdown';
@endphp

<div {{ $attributes->merge(['class' => 'max-w-full w-full bg-white rounded-lg shadow-sm p-4']) }}>
    <div class="flex items-center justify-between mb-3">
        <h2 class="sub-title text-mm-dark-blue">{{ $title }}</h2>

        <div class="relative">
            <button id="{{ $dropdown_id }}-btn" type="button"
                    class="px-3 py-2 text-sm text-mm-dark-blue bg-white rounded border border-mm-dark-blue">
                <span class="dropdown-label">Last 7 days</span>
                <svg class="w-3 h-3 inline-block ml-2" viewBox="0 0 10 6">
                    <path d="m1 1 4 4 4-4" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>
            </button>

            <div id="{{ $dropdown_id }}"
                 class="hidden absolute right-0 mt-2 text-mm-dark-blue bg-white shadow border border-mm-dark-blue rounded w-44 z-20">
                <ul class="py-1">
                    <li>
                        <button data-range="7" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Last 7 days
                        </button>
                    </li>
                    <li>
                        <button data-range="30" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Last 30
                            days
                        </button>
                    </li>
                    <li>
                        <button data-range="90" class="block w-full text-left px-4 py-2 hover:bg-gray-100">Last 90
                            days
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="{{ $chart_id }}"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ajax_url = @json($ajax_url);
        const metric = @json($metric);
        const chart_el = document.getElementById(@json($chart_id));
        if (!chart_el) return;

        const initial_dates = @json($initial_dates) ??
        [];
        const initial_series = @json($initial_series) ??
        [];


        const options = {
            chart: {
                height: "100%",
                maxWidth: "100%",
                type: 'line',
                toolbar: {show: false},
            },
            stroke: {curve: 'smooth', width: 3},
            series: initial_series,
            xaxis: {
                categories: initial_dates,
                labels: {
                    hideOverlappingLabels: true,
                    trim: true,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            legend: {show: true},
            dataLabels: {enabled: false},
            responsive: [
                {
                    breakpoint: 3000,
                    options: {
                        stroke: {width: 3},
                        xaxis: {
                            labels: {rotate: -45, style: {fontSize: '10px'}},
                            tickAmount: Math.min(5, Math.max(1, initial_dates.length - 1)),
                        },
                    }
                }
            ],
        };

        // create chart
        let chart;
        if (chart_el && typeof ApexCharts !== 'undefined') {
            chart = new ApexCharts(chart_el, options);
            chart.render();
        }

        // dropdown toggle and click handling
        const dropdown_id = @json($dropdown_id);
        const dd_btn = document.getElementById(dropdown_id + '-btn');
        const dd_box = document.getElementById(dropdown_id);

        if (dd_btn && dd_box) {
            dd_btn.addEventListener('click', (e) => {
                dd_box.classList.toggle('hidden');
            });

            dd_box.querySelectorAll('button[data-range]').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const range = btn.getAttribute('data-range');
                    // update label
                    dd_btn.querySelector('.dropdown-label').textContent = btn.textContent;
                    dd_box.classList.add('hidden');

                    // fetch new data
                    try {
                        const url = new URL(ajax_url, window.location.origin);
                        url.searchParams.set('metric', metric);
                        url.searchParams.set('range', range);

                        const resp = await fetch(url.toString(), {
                            credentials: 'same-origin', // include cookies
                            headers: {'Accept': 'application/json'},
                        });

                        if (!resp.ok) throw new Error('Network response not ok');

                        const json = await resp.json();
                        const new_dates = json.dates ?? [];
                        const new_series = json.series ?? [];

                        dates_length = new_dates.length;

                        if (chart) {
                            chart.updateOptions({xaxis: {categories: new_dates}}, false, true);
                            chart.updateSeries(new_series, true);
                        }
                    } catch (err) {
                        console.error('Chart data fetch failed', err);
                    }
                });
            });
        }
    });
</script>
