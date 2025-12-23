@extends('layout.backend_master')

@section('master_content')
<div class="d-flex justify-content-center " style="height: 300vh;">
    <div style="width: 1200px;">

        <!-- width control -->
        <div class="mb-4 ">

</div>
        <table class="table table-striped" id="order">
            <thead>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>phone Number</th>
                    <th>Email</th>
                    <th>Person</th>
                    <th>Date</th>
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

// datatable

$('#order').DataTable({
        processing:true,
        serverSide:true,
         ajax: "{{ route('food.OrderIndex') }}",//default vabe get method kaj kore
        columns:[
            {data:'id'},
            {data:'name'},
            {data:'pNumber'},
            {data:'email'},
            {data:'person'},
            {data:'date'},

        ]

});




    });

</script>














@endsection