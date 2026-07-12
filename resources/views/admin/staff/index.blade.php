@extends('admin.layout')

@section('title', 'Staff accounts')
@section('page-title', 'Staff accounts')

@section('content')

    <div class="welcome-banner">
        <h5>Good day, Super Admin</h5>
        <p>Review pending registrations and manage staff access for the LabTech Office.</p>
        <span class="banner-pill"><i class="ti ti-calendar"></i> {{ now()->format('M d, Y') }}</span>
        <span class="banner-pill"><i class="ti ti-clock"></i> {{ now()->format('h:i A') }}</span>
    </div>

    @if (session('generated_password'))
        <div class="alert alert-warning">
            <strong>{{ session('approved_staff_id') }}</strong> approved. Generated password:
            <code class="fs-6">{{ session('generated_password') }}</code>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="ti ti-hourglass"></i></div>
                <div><div class="stat-num">{{ $pending->count() }}</div><div class="stat-label">Pending approval</div></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="ti ti-user-check"></i></div>
                <div><div class="stat-num">{{ $active->count() }}</div><div class="stat-label">Active staff</div></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="ti ti-user-x"></i></div>
                <div><div class="stat-num">{{ $disabled->count() }}</div><div class="stat-label">Disabled</div></div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="ti ti-users"></i></div>
                <div><div class="stat-num">{{ $pending->count() + $active->count() + $disabled->count() }}</div><div class="stat-label">Total accounts</div></div>
            </div>
        </div>
    </div>

    <div class="card-section">
        <div class="card-section-header">Pending approval ({{ $pending->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Full name</th>
                        <th>Student number</th>
                        <th>Campus</th>
                        <th>Program</th>
                        <th>Email</th>
                        <th class="pe-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pending as $staff)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $staff->full_name }}</td>
                            <td>{{ $staff->student_number }}</td>
                            <td>{{ $staff->campus }}</td>
                            <td>{{ $staff->program }}</td>
                            <td>{{ $staff->email }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                <form method="POST" action="{{ route('admin.staff.approve', $staff) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-primary btn-sm">Approve</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted text-center py-4">No pending registrations.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-section">
        <div class="card-section-header">Active staff ({{ $active->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Staff ID</th>
                        <th>Full name</th>
                        <th>Campus</th>
                        <th>Program</th>
                        <th>Email</th>
                        <th class="pe-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($active as $staff)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $staff->staff_id }}</td>
                            <td>{{ $staff->full_name }}</td>
                            <td>{{ $staff->campus }}</td>
                            <td>{{ $staff->program }}</td>
                            <td>{{ $staff->email }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                <span class="status-pill badge-active mx-2">Active</span>
                                <form method="POST" action="{{ route('admin.staff.disable', $staff) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-outline-danger btn-sm">Disable</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted text-center py-4">No active staff yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card-section">
        <div class="card-section-header">Disabled ({{ $disabled->count() }})</div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-3">Staff ID</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th class="pe-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($disabled as $staff)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $staff->staff_id }}</td>
                            <td>{{ $staff->full_name }}</td>
                            <td>{{ $staff->email }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                <span class="status-pill badge-disabled mx-2">Disabled</span>
                                <form method="POST" action="{{ route('admin.staff.reactivate', $staff) }}" class="d-inline">
                                    @csrf
                                    <button class="btn btn-outline-success btn-sm">Reactivate</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted text-center py-4">No disabled accounts.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection