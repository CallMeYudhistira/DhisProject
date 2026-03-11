@extends('layouts.app')
@section('title', 'Manage Projects')
@section('content')
<div class="container py-4 py-md-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
        <h2 class="h3 mb-0">Manage Projects</h2>
        <a href="{{ url('/projects/create') }}" class="btn btn-dark rounded-pill px-4 shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>Add Project
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Preview</th>
                            <th>Title</th>
                            <th class="d-none d-md-table-cell">Description</th>
                            <th class="d-none d-lg-table-cell">URL</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td class="ps-4">
                                @if($project->preview)
                                    <img src="{{ url($project->preview) }}" alt="{{ $project->title }}" style="width: 180px; height: 120px; object-fit: cover;" class="rounded shadow-sm">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center shadow-sm" style="width: 180px; height: 120px;">
                                        <i class="fa-regular fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $project->title }}</div>
                                <div class="d-md-none small text-muted">{{ \Illuminate\Support\Str::limit($project->description, 40) }}</div>
                            </td>
                            <td class="d-none d-md-table-cell text-muted">
                                {{ \Illuminate\Support\Str::limit($project->description, 60) }}
                            </td>
                            <td class="d-none d-lg-table-cell">
                                @if($project->url)
                                    <a href="{{ $project->url }}" target="_blank" class="text-decoration-none text-dark small">
                                        <i class="fa-solid fa-link me-1"></i>Visit
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="{{ url('/projects/' . $project->id . '/edit') }}" class="btn btn-sm btn-white border rounded-start-pill px-3" title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-secondary"></i>
                                    </a>
                                    <form action="{{ url('/projects/' . $project->id . '/delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                        <button type="submit" class="btn btn-sm btn-white border rounded-end-pill px-3" title="Delete">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">
                                <i class="fa-regular fa-folder-open d-block fs-2 mb-3"></i>
                                No projects found. Start by adding one!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 text-center text-sm-start">
        <a href="{{ url('/') }}" class="text-decoration-none text-muted small transition-hover d-inline-block">
            <i class="fa-solid fa-arrow-left me-1"></i>Back to Portfolio
        </a>
    </div>
</div>

<style>
    .btn-white:hover {
        background-color: #f8f9fa;
        transition: 0.4s ease-in-out;
    }
    .transition-hover:hover {
        transform: translateX(-5px);
        transition: 0.4s ease-in-out;
    }
</style>
@endsection
