@extends('layouts.admin.app')

@section('content')
    <div class="container">

        <h2 class="fs-4 text-secondary my-4">
            {{ __('Project Edit Page for') }} {{ Auth::user()->name }}.
        </h2>
        <h3 class="fs-5 text-secondary">
            {{ __('Editing Project') }} ID: {{ $project->id }}
        </h3>

        <div class="row justify-content-center my-3">
            <div class="col">

                @include('admin.projects.partials.error_alert')

                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    {{-- TITLE FORM --}}
                    <div class="mb-3">

                        <label for="title" class="form-label"><strong>Title</strong></label>

                        <input type="text" class="form-control" name="title" id="title"
                            aria-describedby="helpTitle" value="{{ old('title') ? old('title') : $project->title }}">

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- DESCRIPTION FORM --}}
                    <div class="mb-3">

                        <label for="description" class="form-label"><strong>Description</strong></label>

                        <textarea class="form-control" name="description" id="description" aria-describedby="helpDescription" cols="30"
                            rows="5">{{ old('description') ? old('description') : $project->description }}</textarea>

                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- TYPE FORM --}}
                    <div class="mb-3">
                        <label for="type_id" class="form-label">Type</label>
                        <select class="form-select form-select @error('type_id') is-invalid @enderror" name="type_id"
                            id="type_id">
                            <option selected disabled>Select a Type</option>
                            <option value="">Uncategorized</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{-- SE VI E' UN ERRORE E LA PAGINA VIENE RICARICATA IL CAMPO PRECEDENTEMENTE SELEZIONATO RESTA selected --}}
                                    {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{--                     <div class="mb-3">

                        <label for="tech" class="form-label"><strong>Technologies Used</strong></label>

                        <input type="text" class="form-control" name="tech" id="tech" aria-describedby="helpTech"
                            value="{{ old('tech') ? old('tech') : $project->tech }}">

                        @error('tech')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div> --}}

                    {{-- TECHNOLOGIES FORM --}}
                    <div class="mb-3">
                        <label for="technologies" class="form-label"><strong>Technologies Used</strong></label>
                        <select multiple class="form-select form-select" name="technologies[]" id="technologies">
                            <option disabled>Select Technologies used</option>
                            @foreach ($technologies as $technology)
                                @if ($errors->any())
                                    <option value="{{ $technology->id }}" {{-- SE VI SONO ERRORI CONTROLLA SE L'ID DELLA TECHNOLOGY CICLATA E' CONTENUTO DENTRO old('technologies')
                                        SE VI SONO CORRISPONDENZE LE PRESELEZIONA
                                        SE L'ARRAY OLD NON ESISTE CONFRONTA UN ARRAY VUOTO [] COME FALLBACK, AUTOMATICAMENTE NON TROVANDO CORRISPONDENZE E NON SELEZIONANDO NULLA --}}
                                        {{ in_array($technology->id, old('technologies', [])) ? 'selected' : '' }}>
                                        {{ $technology->name }}</option>
                                @else
                                    <option value="{{ $technology->id }}" {{-- SE $project->technologies CONTIENE LA TECHNOLOGY CICLATA LA SELEZIONA --}}
                                        {{ $project->technologies->contains($technology) ? 'selected' : '' }}>
                                        {{ $technology->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('technologies')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- GITHUB LINK FORM --}}
                    <div class="mb-3">

                        <label for="github" class="form-label"><strong>GitHub Link</strong></label>

                        <input type="text" class="form-control" name="github" id="github"
                            aria-describedby="helpGithub" value="{{ old('github') ? old('github') : $project->github }}">

                        @error('github')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- WENSITE LINK FORM --}}
                    <div class="mb-3">

                        <label for="link" class="form-label"><strong>Project Link</strong></label>

                        <input type="text" class="form-control" name="link" id="link" aria-describedby="helpLink"
                            value="{{ old('link') ? old('link') : $project->link }}">

                        @error('link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    {{-- THUMB FORM --}}
                    <div class="mb-3">

                        <div class="mb-3">

                            @if (str_contains($project->thumb, 'http'))
                                <td><img class=" img-fluid" style="height: 100px" src="{{ $project->thumb }}"
                                        alt="{{ $project->title }}"></td>
                            @else
                                <td><img class=" img-fluid" style="height: 100px"
                                        src="{{ asset('storage/' . $project->thumb) }}"></td>
                            @endif

                        </div>

                        <label for="thumb" class="form-label"><strong>Choose a Thumbnail image file</strong></label>

                        <input type="file" class="form-control" name="thumb" id="thumb" placeholder="Cerca..."
                            aria-describedby="fileHelpThumb">

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

        {{-- <h1>ADMIN/PROJECTS/EDIT.BLADE</h1> --}}
    </div>
@endsection
