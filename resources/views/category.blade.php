@extends('layout.backend_master')

@section('master_content')


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">add book</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

     <form action="{{route('food.store')}}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Image Upload -->
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="food_image" name="image" accept=".jpg,.png,.jpeg">
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
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>

{{-- table --}}

<div class="d-flex justify-content-center " style="height: 200vh;">
    <div style="width: 90;"> 
        <!-- width control -->
        <div class="mb-4 ">
 <button type="button" class="btn btn-success"
        data-toggle="modal"
        data-target="#exampleModal">
    Add order
</button>
</div>
        <table class="table table-striped" id="food">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Food Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                             
            </tbody>
        </table>
    </div>
</div>

{{-- datatable --}}





<!-- DataTables JS (after jQuery!) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



<script>

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});



$(document).ready(function() {

    $('#food').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{route('food.index')}}",
      columns: [
    { data: 'id', name: 'id' },
    { data: 'img', name: 'image' },
    { data: 'name', name: 'name' },
    { data: 'description', name: 'description' },
    { data: 'price', name: 'price' },
    { data: 'action', name: 'action', orderable: false, searchable: false }
]

    });

   $('body').on('click', '.deleteButton', function() {
        var id = $(this).data('id');

        if(confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: '/foods/' + id, 
                type: 'DELETE',
                success: function(response) {
                    alert(response.success);
                    $('#row-' + id).remove();
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Something went wrong!');
                }
            });
        }
    });

































});



</script>












@endsection
