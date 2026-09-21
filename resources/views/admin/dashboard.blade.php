@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
@php
    $cards = [
        ['Sliders',        $stats['sliders'],      'admin.sliders.index',         'bi-collection-play'],
        ['Photo albums',   $stats['albums'],       'admin.photo-galleries.index', 'bi-images'],
        ['Photos',         $stats['photos'],       'admin.photo-galleries.index', 'bi-image'],
        ['Videos',         $stats['videos'],       'admin.video-galleries.index', 'bi-camera-video'],
        ['News',           $stats['news'],         'admin.news-events.index',     'bi-newspaper'],
        ['Events',         $stats['events'],       'admin.news-events.index',     'bi-calendar-event'],
        ['FAQs',           $stats['faqs'],         'admin.faqs.index',            'bi-question-circle'],
        ['Testimonials',   $stats['testimonials'], 'admin.testimonials.index',    'bi-chat-quote'],
    ];
@endphp

<h4 class="mb-1">Welcome, {{ auth()->user()->name }}</h4>
<p class="text-secondary mb-4">Here is what is on the school website right now.</p>

<div class="row g-3 mb-4">
    @foreach ($cards as [$label, $count, $route, $icon])
        <div class="col-6 col-md-4 col-xl-3">
            <a href="{{ route($route) }}" class="text-decoration-none text-reset">
                <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ $count }}</div>
                            <div class="text-secondary mt-1">{{ $label }}</div>
                        </div>
                        <i class="bi {{ $icon }} fs-2 text-secondary opacity-50"></i>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header bg-white fw-semibold py-3">Latest news and events</div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <tbody>
            @forelse ($latest as $item)
                <tr>
                    <td style="width:110px"><span class="badge {{ $item->type === 'event' ? 'text-bg-warning' : 'text-bg-info' }}">{{ ucfirst($item->type) }}</span></td>
                    <td>{{ $item->title }}</td>
                    <td class="text-secondary text-end">{{ $item->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td class="text-center text-secondary py-4">Nothing yet. <a href="{{ route('admin.news-events.create') }}">Add the first news or event</a>.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
