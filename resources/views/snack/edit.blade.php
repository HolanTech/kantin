@extends('layouts.master')
@section('title', 'Edit Menu')

@section('content')
    <div class="container">
        <form action="{{ route('snack.update', $snack->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $snack->name }}" required>
            </div>

            <!-- Price -->
            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $snack->price }}"
                    required>
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ $snack->description }}</textarea>
            </div>

            <!-- Likes (assuming this is a display field or auto-calculated) -->
            <div class="form-group mb-3">
                <label for="image">Image</label>
                <input type="file" class="form-control" id="image" name="new_image">
                @if ($snack->image)
                    <img src="{{ Storage::url($snack->image) }}" alt="current-image"
                        style="max-width: 100px; max-height: 100px;">
                    <input type="hidden" name="old_image" value="{{ $snack->image }}">
                @endif
            </div>


            <!-- Status -->
            <div class="form-group mb-3">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="ready" {{ $snack->status == 'ready' ? 'selected' : '' }}>Ready</option>
                    <option value="not ready" {{ $snack->status == 'not ready' ? 'selected' : '' }}>Not Ready</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <div class="mt-5 mb-3"></div>
@endsection
