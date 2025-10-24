@props([
    'id',
    'series',
    'colors',
    'label',
    'label_tag' => 'h4',
    'stats' => [],
    'height' => 100,
    'width' => 100,
    'hollow_size' => '30%'
])

<div class="flex flex-col items-center">
    <<?= $label_tag ?>>{{ $label }}</<?= $label_tag ?>>
    <div class="flex flex-col">
        {{ $stats['value'] }}
        out of
        {{ $stats['full_value'] }}
    </div>
    <div id="{{ $id }}"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const getChartOptions = () => {
            return {
                series: @json($series),
                colors: @json($colors),
                chart: {
                    height: @json($height),
                    width: @json($width),
                    type: "radialBar",
                    sparkline: {
                        enabled: true,
                    },
                },
                plotOptions: {
                    radialBar: {
                        track: {
                            background: '#E5E7EB',
                        },
                        dataLabels: {
                            show: false,
                        },
                        hollow: {
                            margin: 0,
                            size: @json($hollow_size),
                        }
                    },
                },
                yaxis: {
                    show: false,
                    labels: {
                        formatter: function (value) {
                            return value + '%';
                        }
                    }
                }
            }
        }

        const el = document.getElementById(@json($id));
        if (el && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(el, getChartOptions());
            chart.render();
        }
    });
</script>
