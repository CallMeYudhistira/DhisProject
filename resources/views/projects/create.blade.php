@extends('layouts.app')
@section('title', 'Add Project')
@section('content')
<div class="container py-4 py-md-5" id="projects">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
                <h2 class="h3 mb-0">Add New Project</h2>
                <a href="{{ url('/projects') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back
                </a>
            </div>

            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <form action="{{ url('/projects') }}" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold text-dark small text-uppercase">Project Title</label>
                            <input type="text" class="form-control rounded-pill px-4 py-2 shadow-none border-light-subtle bg-light focus-ring" id="title" name="title" placeholder="Enter project name..." required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold text-dark small text-uppercase">Description</label>
                            <textarea class="form-control rounded-4 px-4 py-3 shadow-none border-light-subtle bg-light focus-ring" id="description" name="description" rows="5" placeholder="Describe your amazing project..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label fw-bold text-dark small text-uppercase">Project URL (Optional)</label>
                            <input type="url" class="form-control rounded-pill px-4 py-2 shadow-none border-light-subtle bg-light focus-ring" id="url" name="url" placeholder="https://your-live-project.com">
                        </div>

                        <div class="mb-4">
                            <label for="preview" class="form-label fw-bold text-dark small text-uppercase">Preview Image</label>
                            <div class="p-3 border border-dashed rounded-4 bg-light text-center">
                                <input type="file" class="form-control d-none" id="preview" name="preview" accept="image/*">
                                <label for="preview" class="cursor-pointer mb-0">
                                    <i class="fa-solid fa-cloud-arrow-up fs-2 text-dark mb-2"></i>
                                    <div class="small text-muted">Click to upload or drag and drop</div>
                                    <div class="smaller text-muted mt-1">PNG, JPG or GIF (max. 2MB)</div>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-dark btn-lg rounded-pill fw-bold py-3 shadow">
                                <i class="fa-solid fa-save me-2"></i>Save Project
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
    // Preview image name on file select
    document.getElementById('preview').onchange = function() {
        const label = this.nextElementSibling;
        if (this.files.length > 0) {
            label.querySelector('.small').textContent = 'Selected: ' + this.files[0].name;
            label.querySelector('.small').classList.add('text-success', 'fw-bold');
        }
    };
</script>
@endsection
