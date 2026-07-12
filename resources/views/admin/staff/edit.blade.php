@extends('admin.layout')

@section('title', 'Edit staff')
@section('page-title', 'Edit staff')

@section('content')

    <a href="{{ route('admin.staff.show', $staff) }}" class="text-decoration-none small text-muted mb-3 d-inline-block">
        <i class="ti ti-arrow-left"></i> Back to staff details
    </a>

    <div class="card-section">
        <div class="card-section-header">Edit account — {{ $staff->full_name }}</div>
        <div class="p-4">

            @if ($errors->any())
                <div class="alert alert-danger py-2 small">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.staff.update', $staff) }}" enctype="multipart/form-data">
                @csrf

                <div class="d-flex gap-3 align-items-center mb-4">
                    @if ($staff->profile_picture_url)
                        <img src="{{ $staff->profile_picture_url }}" alt="Current photo" style="width:64px; height:64px; border-radius:50%; object-fit:cover; border:1px solid var(--border);">
                    @else
                        <div style="width:64px; height:64px; border-radius:50%; background-color:var(--tint); display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:600; color:var(--primary);">
                            {{ strtoupper(substr($staff->full_name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <label class="form-label small text-muted mb-1">Replace profile picture</label>
                        <input type="file" name="profile_picture" accept="image/*" class="form-control form-control-sm">
                    </div>
                    @if ($staff->profile_picture_url)
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" name="remove_picture" value="1" id="removePicture">
                            <label class="form-check-label small text-muted" for="removePicture">Remove photo</label>
                        </div>
                    @endif
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Full name</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $staff->full_name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Student number</label>
                        <input type="text" name="student_number" class="form-control" value="{{ old('student_number', $staff->student_number) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Campus</label>
                        <select name="campus" class="form-select" required>
                            @foreach (['Main Campus', 'Congressional Extension Campus', 'Camarin Extension Campus', 'Bagong Silang Campus'] as $campus)
                                <option value="{{ $campus }}" {{ $staff->campus === $campus ? 'selected' : '' }}>{{ $campus }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Program</label>
                        <select name="program" class="form-select" required>
                            @foreach (['BS in Information Technology', 'BS in Computer Science', 'BS in Information Systems', 'BS in Entertainment and Multimedia Computing'] as $program)
                                <option value="{{ $program }}" {{ $staff->program === $program ? 'selected' : '' }}>{{ $program }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Email address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Save changes</button>
            </form>

        </div>
    </div>

@endsection