<!-- When there is no desire, all things are at peace. - Laozi -->

@extends('layouts.app')

@section('title', 'Edit Plan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="title">Edit Plan</h1>
        <div class="flex items-center gap-2">
            <x-mm-button href="{{ route('admin.plans.index') }}" variant="secondary" label="Back" />
        </div>
    </div>

    <div class="bg-mm-card p-6 rounded-lg shadow-sm border border-mm-border">
        <form action="{{ route('admin.plans.update', $plan) }}" method="POST" novalidate>
            @csrf
            @method('PATCH')

            @include('admin.plans._form', [
                'plan' => $plan,
                'submit_label' => 'Save changes'
            ])
        </form>

        <div class="mt-4">
            <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Delete this plan?');">
                @csrf
                @method('DELETE')
                <x-mm-button type="submit" variant="danger" label="Delete plan" />
            </form>
        </div>
    </div>
</div>
@endsection
