@extends('admin.layout')

@section('title', 'Staff details')
@section('page-title', 'Staff details')

@section('content')

    <a href="{{ route('admin.staff.index') }}" class="text-decoration-none small text-muted mb-3 d-inline-block">
        <i class="ti ti-arrow-left"></i> Back to staff accounts
    </a>

    <div class="card-section">
        <div class="card-section-header">Profile</div>
        <div class="p-4 d-flex gap-4 align-items-start flex-wrap">

            <div>
                @if ($staff->profile_picture_url)
                    <img src="{{ $staff->profile_picture_url }}" alt="{{ $staff->full_name }}"
                         style="width:96px; height:96px; border-radius:50%; object-fit:cover; border:1px solid var(--border);">
                @else
                    <div style="width:96px; height:96px; border-radius:50%; background-color:var(--tint); display:flex; align-items:center; justify-content:center; font-size:28px; font-weight:600; color:var(--primary);">
                        {{ strtoupper(substr($staff->full_name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="flex-grow-1">
                <h5 class="fw-semibold mb-1">{{ $staff->full_name }}</h5>

                @if ($staff->status === 'pending')
                    <span class="status-pill badge-pending">Pending</span>
                @elseif ($staff->status === 'active')
                    <span class="status-pill badge-active">Active</span>
                @else
                    <span class="status-pill badge-disabled">Disabled</span>
                @endif

                <div class="row mt-4 gy-3">
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Staff ID</div>
                        <div class="fw-medium">{{ $staff->staff_id ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Student number</div>
                        <div class="fw-medium">{{ $staff->student_number }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Campus</div>
                        <div class="fw-medium">{{ $staff->campus }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Program</div>
                        <div class="fw-medium">{{ $staff->program }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Email address</div>
                        <div class="fw-medium">{{ $staff->email }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Registered on</div>
                        <div class="fw-medium">{{ $staff->created_at->format('M d, Y · h:i A') }}</div>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-outline-secondary btn-sm">Edit details</a>
                    <a href="{{ route('admin.staff.schedule.edit', $staff) }}" class="btn btn-outline-secondary btn-sm">Manage schedule</a>

                    @if ($staff->status === 'pending')
                        <form method="POST" action="{{ route('admin.staff.approve', $staff) }}">
                            @csrf
                            <button class="btn btn-primary btn-sm">Approve</button>
                        </form>
                    @elseif ($staff->status === 'active')
                        <form method="POST" action="{{ route('admin.staff.disable', $staff) }}">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm">Disable</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.staff.reactivate', $staff) }}">
                            @csrf
                            <button class="btn btn-outline-success btn-sm">Reactivate</button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection