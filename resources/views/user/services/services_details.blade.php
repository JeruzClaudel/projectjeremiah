@extends('layouts.user')

@section('styles')
    @vite('resources/css/styles.css')
@endsection

@section('content')
<div class="container my-5">

    <div class="card shadow p-5 border-0">
        <h2 class="text-primary fw-bold mb-4">{{ $service->name }}</h2>

        <p class="text-dark fs-5" style="line-height: 1.8;">{{ $service->description }}</p>

        @if($service->consultation)
            <div class="mt-5 bg-light rounded p-4 border-start border-4 border-primary">
                <h4 class="text-gold mb-2">🔗 Related Consultation</h4>
                <p class="mb-1 fw-semibold">{{ $service->consultation->name }}</p>
                <p class="text-muted">{{ $service->consultation->description }}</p>
                <a href="{{ $service->consultation->request_link }}" class="btn btn-primary mt-2" target="_blank">
                    Request Consultation →
                </a>
            </div>
        @else
            <div class="alert alert-secondary mt-4">
                <i class="fas fa-info-circle me-2"></i> No related consultation linked.
            </div>
        @endif

        <a href="" class="btn btn-outline-secondary mt-5">
            ← Back to Services
        </a>
    </div>

</div>
@endsection
