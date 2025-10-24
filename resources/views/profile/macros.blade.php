@extends("layouts.app")

@section("title", "Your Macros")

@section("content")
    <h1 class="title">{{ $user->mu_name }}, here are your macros!</h1>
    <h3 class="mb-6 text-lg text-center md:text-start">
        Plan:
        <span class="font-semibold">
            {{ $plan->mp_name ?? "No plan selected" }}
        </span>
    </h3>

    <div class="space-y-4">
        <div class="grid md:grid-cols-2 items-center gap-7">
            <div class="text-center md:text-start">
                <h4 class="text-lg mb-4">
                    Calories:
                    <strong>{{ $macros["calories"] }} kcal</strong>
                </h4>
                <ul class="space-y-2">
                    <li>
                        Protein:
                        <strong>{{ $macros["protein"]["grams"] }} g</strong>
                        ({{ $macros["protein"]["percent"] }}%)
                    </li>
                    <li>
                        Fat:
                        <strong>{{ $macros["fat"]["grams"] }} g</strong>
                        ({{ $macros["fat"]["percent"] }}%)
                    </li>
                    <li>
                        Carbs:
                        <strong>{{ $macros["carbs"]["grams"] }} g</strong>
                        ({{ $macros["carbs"]["percent"] }}%)
                    </li>
                    <li>
                        Fiber:
                        <strong>{{ $macros["fiber"] }} g</strong>
                    </li>
                    <li>
                        Water:
                        <strong>{{ $macros["water"] }} ml</strong>
                    </li>
                </ul>
            </div>
            <x-charts.mm-chart-pie
                class="mx-auto md:mx-0"
                title="PFC Chart"
                :labels="['Proteins', 'Fats', 'Carbs']"
                :series="[(float)$macros['protein']['percent'], (float)$macros['fat']['percent'], (float)$macros['carbs']['percent']]"
                :colors="['#4CAF50', '#FF9800', '#2196F3']"
            />
        </div>

        <x-mm-button
            class="block mt-6 text-center w-full"
            label="Edit"
            href="{{ route('profile-macros-edit') }}"
        />
    </div>
@endsection
