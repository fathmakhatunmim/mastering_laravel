@extends('layout.backend_master')

@section('master_content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Food</h1>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

     

     <form action="{{route('food.reviewStore')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden"name="review_id" id="review_id">
    <!-- Image Upload -->
    <div class="input-group mb-3">
        <input type="file" class="form-control" id="food_image" name="img" accept=".jpg,.png,.jpeg">
        <label class="input-group-text" for="food_image">Upload</label>
    </div>

<!-- Image preview -->
<img id="preview"
     src=""
     style="display:none; width:120px; height:120px; object-fit:cover; border:1px solid #ddd; margin-top:10px;">

    <!-- Name -->
    <div class="mb-3">
        <label for="food_name" class="form-label">name</label>
        <input type="text" class="form-control" id="food_name" name="name" placeholder="Enter your name">
    </div>
  <!-- city -->
    <div class="mb-3">
        <label for="food_name" class="form-label">city</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="city">
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"
                  placeholder="Give your suggestion"></textarea>
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

<div class="d-flex justify-content-center " style="height: 300vh;">
    <div style="width: 1200px;">

        <!-- width control -->
        <div class="mb-4 ">
 <button type="button" class="btn btn-success"
        data-toggle="modal"
        data-target="#exampleModal">
    Add order
</button>
</div>
        <table class="table table-striped" id="review">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>name</th>
                    <th>city</th>
                    <th>comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                             
            </tbody>
        </table>
    </div>
</div>



<!-- DataTables JS (after jQuery!) -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



<script>

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});



$(document).ready(function() {

// image check korar jonno


    $('#food_image').change(function () {

        let file = this.files[0];

        if (!file) {
            return;
        }

        // শুধু image কিনা check
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file');
            $(this).val('');
            return;
        }

        let reader = new FileReader();

        reader.onload = function (e) {
            $('#preview')
                .attr('src', e.target.result)
                .show();
        };

        reader.readAsDataURL(file);
    });


// datatable

$('#review').DataTable({
        processing:true,
        serverSide:true,
         ajax: "{{ route('food.reviewData') }}",//default vabe get method kaj kore
        columns:[
            {data:'id'},
            {data:'img'},
            {data:'name'},
            {data:'city'},
            {data:'comment'},
             { data: 'action', name: 'action', orderable: false, searchable: false }

        ]

});

$('body').on('click','.editButton',function(e){

e.preventDefault();
var id = $(this).data('id');

$.ajax({
  url:'/reviewEdit/' + id,
  method:'GET',

 success: function(response) {
    $('#review_id').val(response.id);
   $('#comment').val(response.comment);
   $('#food_name').val(response.name);
    $('#city').val(response.city);
    // image preview
    if(response.img){
                $('#preview').attr('src', '/uploads/' + response.img).show();
            } else {
                $('#preview').hide();
            }

            $('#exampleModal').modal('show'); // modal open
        },
        error: function(xhr){
            console.log(xhr.responseText);
            alert('Something went wrong');
        }
    });
});

$('body').on('click', '.deleteButton', function() {
    var id = $(this).data('id');

    if(confirm("Are you sure you want to delete this item?")) {
        $.ajax({
            url: '/reviewDelete/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.success);
                $('#review').DataTable().ajax.reload(); // Datatable refresh
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
