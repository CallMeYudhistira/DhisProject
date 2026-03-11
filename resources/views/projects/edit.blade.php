@extends('layouts.app')
@section('title', 'Edit Project')
@section('content')
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
                <h2 class="h3 mb-0">Edit: {{ $project->title }}</h2>
                <a href="{{ url('/projects') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ url('/projects/' . $project->id) }}" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold text-dark small text-uppercase">Project Title</label>
                            <input type="text" class="form-control rounded-pill px-4 py-2 shadow-none border-light-subtle bg-light focus-ring" id="title" name="title" value="{{ $project->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-dark small text-uppercase">Description</label>
                            <textarea class="form-control rounded-4 px-4 py-3 shadow-none border-light-subtle bg-light focus-ring" id="description" name="description" rows="5" required>{{ $project->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label fw-bold text-dark small text-uppercase">Project URL (Optional)</label>
                            <input type="url" class="form-control rounded-pill px-4 py-2 shadow-none border-light-subtle bg-light focus-ring" id="url" name="url" value="{{ $project->url }}" placeholder="https://...">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase">Current Preview</label>
                            @if($project->preview)
                                <div class="mb-3">
                                    <img src="{{ url($project->preview) }}" alt="{{ $project->title }}" class="img-fluid rounded-4 shadow-sm" style="max-height: 200px; width: auto;">
                                </div>
                            @else
                                <div class="mb-3 text-muted small italic">No image currently uploaded.</div>
                            @endif

                            <label for="preview" class="form-label fw-bold text-dark small text-uppercase">Update Preview Image (Optional)</label>
                            <div class="p-3 border border-dashed rounded-4 bg-light text-center">
                                <input type="file" class="form-control d-none" id="preview" name="preview" accept="image/*">
                                <label for="preview" class="cursor-pointer mb-0 w-100">
                                    <i class="fa-solid fa-cloud-arrow-up fs-2 text-dark mb-2"></i>
                                    <div class="small text-muted">Click to change image</div>
                                    <div class="smaller text-muted mt-1">Leave blank to keep current image</div>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill fw-bold py-3 shadow">
                                <i class="fa-solid fa-check me-2"></i>Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .focus-ring:focus {
        border-color: #0d6efd !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    document.getElementById('preview').onchange = function() {
        const label = this.nextElementSibling;
        if (this.files.length > 0) {
            label.querySelector('.small').textContent = 'Selected: ' + this.files[0].name;
            label.querySelector('.small').classList.add('text-success', 'fw-bold');
        }
    };
</script>
@endsection
