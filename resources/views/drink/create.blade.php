@extends('layouts.master')
@section('title', 'Add Drink')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('drink.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status">
                    <option value="ready">Ready</option>
                    <option value="not ready">Not Ready</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>
@endsection
