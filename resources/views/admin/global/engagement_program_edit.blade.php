@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Edit Program</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.global.engagement.dashboard') }}">Global Engagement</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Edit Program</a></li>
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
        <form action="{{ route('admin.global.engagement.program.update', $program->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $program->title) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $program->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="objectives" class="form-label">Objectives (Tujuan)</label>
                <textarea name="objectives" id="objectives" class="form-control" rows="5">{{ old('objectives', $program->objectives) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="activities" class="form-label">Activities (Kegiatan)</label>
                <textarea name="activities" id="activities" class="form-control" rows="5">{{ old('activities', $program->activities) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="order" class="form-label">Display Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $program->order) }}" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Program</button>
            <a href="{{ route('admin.global.engagement.dashboard') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#objectives')).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#activities')).catch(error => console.error(error));
</script>
@endsection
