@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Edit Partner</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.global.engagement.dashboard') }}">Global Engagement</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Edit Partner</a></li>
        </ul>
    </div>
</div>

<div class="card my-4">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.global.engagement.partner.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Partner Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $partner->name) }}" required>
            </div>
             <div class="mb-3">
                <label for="website_url" class="form-label">Website URL (Optional)</label>
                <input type="url" name="website_url" id="website_url" class="form-control" value="{{ old('website_url', $partner->website_url) }}">
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">New Logo (Optional)</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                <small class="form-text text-muted">Leave blank to keep the current logo.</small>
            </div>
             @if($partner->logo_path)
            <div class="mb-3">
                <label>Current Logo</label>
                <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" width="150" class="d-block rounded">
            </div>
            @endif
            <div class="mb-3">
                <label for="order" class="form-label">Display Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $partner->order) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Partner</button>
            <a href="{{ route('admin.global.engagement.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
