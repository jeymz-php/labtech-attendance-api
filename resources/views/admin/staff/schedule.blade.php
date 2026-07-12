@extends('admin.layout')

@section('title', 'Staff schedule')
@section('page-title', 'Staff schedule')

@section('content')

    <a href="{{ route('admin.staff.show', $staff) }}" class="text-decoration-none small text-muted mb-3 d-inline-block">
        <i class="ti ti-arrow-left"></i> Back to staff details
    </a>

    <div class="card-section">
        <div class="card-section-header">Weekly duty schedule — {{ $staff->full_name }}</div>
        <div class="p-4">

            @if (session('success'))
                <div class="alert alert-success py-2 small">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.staff.schedule.update', $staff) }}">
                @csrf

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>On duty</th>
                            <th>Start time</th>
                            <th>End time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                        @endphp
                        @foreach ($days as $i => $dayName)
                            @php $s = $schedules->get($i); @endphp
                            <tr>
                                <td class="fw-medium">{{ $dayName }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="duty[{{ $i }}]" value="1" {{ $s && $s->is_duty ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <input type="time" name="start[{{ $i }}]" class="form-control form-control-sm" value="{{ $s && $s->start_time ? \Carbon\Carbon::parse($s->start_time)->format('H:i') : '08:00' }}" style="max-width:140px;">
                                </td>
                                <td>
                                    <input type="time" name="end[{{ $i }}]" class="form-control form-control-sm" value="{{ $s && $s->end_time ? \Carbon\Carbon::parse($s->end_time)->format('H:i') : '17:00' }}" style="max-width:140px;">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary mt-2">Save schedule</button>
            </form>

        </div>
    </div>

@endsection