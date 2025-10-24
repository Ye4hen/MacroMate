@extends("layouts.app")

@section("title", "Summary")

@section("content")
    <h1 class="title">Your summary</h1>
    <div class="flex flex-col pt-5 gap-y-5">
        <x-charts.mm-chart-line
            id="chart-calories"
            title="Calories"
            ajax_url="{{ route('profile.summary.data') }}"
            metric="calories"
            :initial_dates="$dates"
            :initial_series="[
                [
                    'name' => 'Calories',
                    'data' => $calories,
                    'color' => '#F97316'
                ]
            ]"
        />
        <x-charts.mm-chart-line
            id="chart-water"
            title="Water (ml)"
            ajax_url="{{ route('profile.summary.data') }}"
            metric="water"
            :initial_dates="$dates"
            :initial_series="[
                [
                    'name' => 'Water (ml)',
                    'data' => $water,
                    'color' => '#3B82F6'
                ]
            ]"
        />
        <x-charts.mm-chart-line
            id="chart-macros"
            title="Protein / Fat / Carbs"
            ajax_url="{{ route('profile.summary.data') }}"
            metric="macros"
            :initial_dates="$dates"
            :initial_series="[
                ['name' => 'Protein', 'data' => $protein, 'color' => '#1C64F2'],
                ['name' => 'Fat',     'data' => $fat,     'color' => '#F97316'],
                ['name' => 'Carbs',   'data' => $carbs,   'color' => '#10B981'],
            ]"
        />
        <x-charts.mm-chart-line
            id="chart-burned-calories"
            title="Burned calories"
            ajax_url="{{ route('profile.summary.data') }}"
            metric="burned_calories"
            :initial_dates="$dates"
            :initial_series="[
                [
                    'name' => 'Burned calories',
                    'data' => $burned_calories,
                    'color' => '#B91C1C'
                ]
            ]"
        />
    </div>
@endsection
