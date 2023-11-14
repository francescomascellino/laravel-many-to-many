@extends('layouts.admin.app')

@section('content')
    <div class="container">

        <h2 class="fs-4 text-secondary my-4">
            {{ __('New Project Page for') }} {{ Auth::user()->name }}.
        </h2>

        <div class="row justify-content-center my-3">
            <div class="col">

                @include('admin.projects.partials.error_alert')

                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label for="title" class="form-label"><strong>* Title</strong></label>

                        <input type="text" class="form-control @error('title') is-invalid"  @enderror name="title"
                            id="title" aria-describedby="helpTitle" placeholder="New Project Title"
                            value="{{ old('title') }}">
                        <div id="helpTitle" class="form-text">
                            Your title must be 3-200 characters long.
                        </div>

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="description" class="form-label "><strong>Description</strong></label>

                        <textarea class="form-control @error('description') is-invalid  @enderror" name="description" id="description"
                            aria-describedby="helpDescription" cols="30" rows="5" placeholder="New Project Description"></textarea>

                        <div id="helpDescription" class="form-text">
                            Your description must be 3-500 characters long.
                        </div>

                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select form-select @error('type_id') is-invalid @enderror" name="type_id"
                            id="type_id">
                            <option selected disabled>Select a Type</option>
                            <option value="">Uncategorized</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{-- SE VI E' UN ERRORE E LA PAGINA VIENE RICARICATA IL CAMPO PRECEDENTEMENTE SELEZIONATO RESTA selected --}}
                                    {{ $type->id == old('type_id') ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <label for="tech" class="form-label"><strong>Technologies Used</strong></label>

                        <input type="text" class="form-control @error('tech') is-invalid @enderror" name="tech"
                            id="tech" aria-describedby="helpTech" placeholder="Tech used creating the New Project"
                            value="{{ old('tech') }}">
                        <div id="helpTech" class="form-text">
                            Your tech list must be 3-500 characters long.
                        </div>

                        @error('tech')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="github" class="form-label"><strong>GitHub Link</strong></label>

                        <input type="text" class="form-control @error('github') is-invalid @enderror" name="github"
                            id="github" placeholder="Enter your GitHub Project Repository Link"
                            value="{{ old('github') }}">

                        @error('github')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="link" class="form-label"><strong>Project Link</strong></label>

                        <input type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                            id="link" placeholder="Enter your Project Link" value="{{ old('link') }}">

                        @error('link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label for="thumb" class="form-label"><strong>Choose a Thumbnail image file</strong></label>

                        <input type="file" class="form-control @error('thumb') is-invalid @enderror" name="thumb"
                            id="thumb" placeholder="Upload a new image file..." aria-describedby="helpThumb">
                        <div id="helpThumb" class="form-text">
                            Choose a valid image file with a max size of 500kb
                        </div>

                        @error('thumb')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-success my-3"><i class="fa-solid fa-floppy-disk"></i>
                        Save</button>
                    <a class="btn btn-primary" href="{{ route('admin.projects.index') }}"><i class="fa-solid fa-ban"></i>
                        Cancel</a>

                </form>
            </div>
        </div>

        {{-- <h1>ADMIN/PROJECTS/CREATE.BLADE</h1> --}}
    </div>
@endsection
