@extends('admin.admin')

@section('contentadmin')
<style>
    .card-header-custom {
        background-color: #f1f1f1;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="head-title">
    <div class="left">
        <h1>Global Engagement Management</h1>
        <ul class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="#">Global Engagement</a></li>
        </ul>
    </div>
</div>

{{-- 1. "TENTANG" SECTION --}}
<div class="card my-4">
    <div class="card-header card-header-custom">
        <h3 class="mb-0">Manage "Tentang" Section</h3>
    </div>
    <div class="card-body">
        @if (session('success_about'))
            <div class="alert alert-success">{{ session('success_about') }}</div>
        @endif
        @if ($errors->any() && $errors->has('content'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="about-form" action="{{ route('admin.global.engagement.about.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="about_content" class="form-label">Content</label>
                <textarea name="content" id="about_content" class="form-control" rows="10">{{ old('content', $about->content ?? '') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save "Tentang" Content</button>
        </form>
    </div>
</div>

{{-- 2. "PROGRAM" SECTION --}}
<div class="card my-4">
    <div class="card-header card-header-custom">
        <h3 class="mb-0">Manage Programs</h3>
    </div>
    <div class="card-body">
         @if (session('success_program'))
            <div class="alert alert-success">{{ session('success_program') }}</div>
        @endif
        
        {{-- PROGRAM VALIDATION ERRORS --}}
        @if ($errors->any() && ($errors->has('title') || $errors->has('description') || $errors->has('objectives') || $errors->has('activities')))
            <div class="alert alert-danger">
                <ul>
                    @if($errors->has('title'))
                        <li>{{ $errors->first('title') }}</li>
                    @endif
                    @if($errors->has('description'))
                        <li>{{ $errors->first('description') }}</li>
                    @endif
                    @if($errors->has('objectives'))
                        <li>{{ $errors->first('objectives') }}</li>
                    @endif
                    @if($errors->has('activities'))
                        <li>{{ $errors->first('activities') }}</li>
                    @endif
                </ul>
            </div>
        @endif
        
        {{-- ADD NEW PROGRAM FORM --}}
        <h4 class="mb-3">Add New Program</h4>
        <form id="program-form" action="{{ route('admin.global.engagement.program.store') }}" method="POST" class="mb-5" novalidate>
            @csrf
            <div class="mb-3">
                <label for="prog_title" class="form-label">Title</label>
                <input type="text" name="title" id="prog_title" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label for="prog_desc" class="form-label">Description</label>
                <textarea name="description" id="prog_desc" class="form-control" rows="3" required>{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="prog_obj" class="form-label">Objectives (Tujuan)</label>
                <textarea name="objectives" id="prog_obj" class="form-control" rows="4" required>{{ old('objectives') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="prog_act" class="form-label">Activities (Kegiatan)</label>
                <textarea name="activities" id="prog_act" class="form-control" rows="4" required>{{ old('activities') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Program</button>
        </form>

        <hr>

        {{-- EXISTING PROGRAMS TABLE --}}
        <h4 class="my-4">Existing Programs</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $program)
                    <tr>
                        <td>{{ $program->order }}</td>
                        <td>{{ $program->title }}</td>
                        <td>{{ Str::limit($program->description, 100) }}</td>
                        <td>
                            <a href="{{ route('admin.global.engagement.program.edit', $program->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.global.engagement.program.destroy', $program->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this program?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No programs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 3. "PARTNER" SECTION --}}
<div class="card my-4">
    <div class="card-header card-header-custom">
        <h3 class="mb-0">Manage Partners</h3>
    </div>
    <div class="card-body">
        @if (session('success_partner'))
            <div class="alert alert-success">{{ session('success_partner') }}</div>
        @endif

        {{-- ADD NEW PARTNER FORM --}}
        <h4 class="mb-3">Add New Partner</h4>
        <form action="{{ route('admin.global.engagement.partner.store') }}" method="POST" enctype="multipart/form-data" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="partner_name" class="form-label">Partner Name</label>
                <input type="text" name="name" id="partner_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="partner_url" class="form-label">Website URL (Optional)</label>
                <input type="url" name="website_url" id="partner_url" class="form-control">
            </div>
            <div class="mb-3">
                <label for="partner_logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="partner_logo" class="form-control" required accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Add Partner</button>
        </form>

        <hr>

        {{-- EXISTING PARTNERS TABLE --}}
        <h4 class="my-4">Existing Partners</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $partner)
                    <tr>
                        <td>{{ $partner->order }}</td>
                        <td><img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" width="100"></td>
                        <td>{{ $partner->name }}</td>
                        <td><a href="{{ $partner->website_url }}" target="_blank">{{ $partner->website_url }}</a></td>
                        <td>
                            <a href="{{ route('admin.global.engagement.partner.edit', $partner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                             <form action="{{ route('admin.global.engagement.partner.destroy', $partner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No partners found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Minimal script for debugging is RUNNING.");

        let descEditor, objectivesEditor, activitiesEditor;

        // Initialize ONLY the editors for the program form
        ClassicEditor
            .create(document.querySelector('#prog_desc'))
            .then(editor => {
                descEditor = editor;
                console.log("✅ Description editor loaded.");
            })
            .catch(error => console.error("❌ Description editor FAILED to load:", error));

        ClassicEditor
            .create(document.querySelector('#prog_obj'))
            .then(editor => {
                objectivesEditor = editor;
                console.log("✅ Objectives editor loaded.");
            })
            .catch(error => console.error("❌ Objectives editor FAILED to load:", error));

        ClassicEditor
            .create(document.querySelector('#prog_act'))
            .then(editor => {
                activitiesEditor = editor;
                console.log("✅ Activities editor loaded.");
            })
            .catch(error => console.error("❌ Activities editor FAILED to load:", error));

        // --- The Form Submission Logic ---
        const programForm = document.getElementById('program-form');

        if (programForm) {
            programForm.addEventListener('submit', function() {
                console.log("👍 Submit button clicked. Attempting to update textareas...");

                // Use CKEditor's built-in function to update the underlying textarea
                if (descEditor) {
                    descEditor.updateSourceElement();
                    console.log("Updated Description textarea.");
                }
                if (objectivesEditor) {
                    objectivesEditor.updateSourceElement();
                    console.log("Updated Objectives textarea.");
                }
                if (activitiesEditor) {
                    activitiesEditor.updateSourceElement();
                    console.log("Updated Activities textarea.");
                }
                console.log("Update complete. Allowing form to submit.");
            });
        }
    });
</script>
@endsection