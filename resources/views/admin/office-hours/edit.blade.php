@extends('admin.layout')

@section('title', 'Office hours')
@section('page-title', 'Office hours')

@section('content')

    <div class="card-section">
        <div class="card-section-header">LabTech Office attendance window</div>
        <div class="p-4">

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.office-hours.update') }}">
                @csrf

                <label class="form-label small text-muted mb-2">Mode</label>
                <div class="d-flex flex-column gap-2 mb-4">

                    <div class="border rounded-3 p-3" style="border-color: var(--border) !important;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="modeNormal" value="normal" {{ $settings->mode === 'normal' ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="modeNormal">Scheduled hours</label>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Attendance is only allowed within the time window below.</p>

                        <div class="row g-2 mt-2" style="max-width: 400px;">
                            <div class="col-6">
                                <label class="form-label small text-muted">Opens at</label>
                                <input type="time" name="open_time" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($settings->open_time)->format('H:i') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label small text-muted">Closes at</label>
                                <input type="time" name="close_time" class="form-control form-control-sm" value="{{ \Carbon\Carbon::parse($settings->close_time)->format('H:i') }}">
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-3 p-3" style="border-color: var(--border) !important;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="modeForceOpen" value="force_open" {{ $settings->mode === 'force_open' ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="modeForceOpen">Force open</label>
                        </div>
                        <p class="small text-muted mb-0 mt-1">Attendance is allowed at any time, ignoring the hours above. Staff schedules (duty days) still apply.</p>
                    </div>

                    <div class="border rounded-3 p-3" style="border-color: var(--border) !important;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mode" id="modeForceClosed" value="force_closed" {{ $settings->mode === 'force_closed' ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="modeForceClosed">Force closed</label>
                        </div>
                        <p class="small text-muted mb-0 mt-1">No one can time in or out, regardless of schedule. Use for holidays or system maintenance.</p>
                    </div>

                </div>

                <label class="form-label small text-muted">Late grace period</label>
                <div class="d-flex align-items-center gap-2" style="max-width: 220px;">
                    <input type="number" name="late_grace_minutes" class="form-control" min="0" max="120" value="{{ $settings->late_grace_minutes }}">
                    <span class="text-muted small">minutes</span>
                </div>
                <p class="small text-muted mt-1">Staff timing in more than this many minutes after their scheduled start (or office opening time) are marked "Late" and notified.</p>

                <button type="submit" class="btn btn-primary mt-4">Save changes</button>
            </form>

        </div>
    </div>

@endsection