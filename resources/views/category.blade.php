@extends('layout.backend_master')

@section('master_content')

<div class="mb-3">
 <button type="button" class="btn btn-success"
        data-toggle="modal"
        data-target="#exampleModal">
    Add order
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">add book</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

     <form action="" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Image Upload -->
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="food_image" name="image">
        <label class="input-group-text" for="food_image">Upload</label>
    </div>

    <!-- Food Name -->
    <div class="mb-3">
        <label for="food_name" class="form-label">Food Name</label>
        <input type="text" class="form-control" id="food_name" name="name" placeholder="Enter food name">
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"
                  placeholder="Enter description"></textarea>
    </div>

    <!-- Price -->
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

@endsection
