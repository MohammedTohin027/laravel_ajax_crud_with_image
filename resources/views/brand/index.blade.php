<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App Laravel 8 & Ajax</title>
    <!-- bootstrap css -->
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
    <!-- bootstrap icon -->
    <link rel='stylesheet'
        href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
    <!-- datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
   <!-- toastr css -->
    <link rel="stylesheet" type="text/css" 
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    <!-- Add Brand Modal Start -->
    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="add_brand_form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 bg-light">
                        <div class="">
                            <label for="brand_name_en">Brand Name En</label>
                            <input type="text" name="brand_name_en" class="form-control"
                                placeholder="Enter Brand Name English" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_name_bn">Brand Name Bn</label>
                            <input type="text" name="brand_name_bn" class="form-control"
                                placeholder="Enter Brand Name Bangla" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_image">Brand Image</label>
                            <input type="file" name="brand_image" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="add_brand_btn" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Brand Modal End -->

    <!-- Edit Brand Modal Start -->
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" id="edit_brand_form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="brand_id" id="brand_id">
                    <input type="hidden" name="old_image" id="old_image">
                    <div class="modal-body p-4 bg-light">
                        <div class="">
                            <label for="brand_name_en">Brand Name En</label>
                            <input type="text" name="brand_name_en" id="brand_name_en" class="form-control"
                                placeholder="Enter Brand Name English" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_name_bn">Brand Name Bn</label>
                            <input type="text" name="brand_name_bn" id="brand_name_bn" class="form-control"
                                placeholder="Enter Brand Name Bangla" required>
                        </div>
                        <div class="my-2">
                            <label for="brand_image">Brand Image</label>
                            <input type="file" name="brand_image" class="form-control">
                        </div>
                        <div class="my-2" id="brand_image">
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="update_brand_btn" class="btn btn-primary">Update Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Brand Modal End -->

    <!-- Manage Brands Start-->
    <div class="container">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header bg-danger d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Manage Brand</h3>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addBrandModal"><i
                                class="bi-plus-circle me-2"></i>Add New Brand</button>
                    </div>
                    <div class="card-body mt-3" id="show_all_employees">
                        @if ($data->count() > 0)
                        <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                            <thead>                               
                                <tr>
                                    <th>#</th>
                                    <th>Brand Image</th>
                                    <th>Brand Name En</th>
                                    <th>Brand Name Bn</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                <tr>
                                    <td width="8%">{{ $key+1 }}</td>
                                    <td width="13%">
                                        @if (!empty($item->brand_image) && file_exists($item->brand_image))
                                            <img src="{{ asset($item->brand_image) }}" width="80" height="80" alt="">
                                        @else
                                        <img src="{{ asset('no_image.jpg') }}" width="80" height="80" alt="">
                                        @endif
                                    </td>
                                    <td>{{ $item->brand_name_en }}</td>
                                    <td>{{ $item->brand_name_bn }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                           <span class="text-success" style="font-size: 30px;"><i class="bi bi-toggle-on"></i></span> 
                                        @else
                                        <span class="text-danger" style="font-size: 30px;"><i class="bi bi-toggle-off"></i></span> 
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" module_id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#editBrandModal" class="btn btn-sm btn-success editIconBtn" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" title="Delete"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot>
                        </table>
                      
                        @else
                        <h1 class="text-center text-secondary my-5">No Records Inserted!...</h1>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Manage Brands End-->

    <!-- jquery js -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <!-- bootstrap js -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
    <!-- datatable js -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
    <!-- sweetalert2 js -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- toastr css -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(function() {
            $("table").DataTable();
            $('#add_brand_form').submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $.ajax({                    
                    url: "{{ route('brand.store') }}",
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        if (res.status == 200) {
                            $('#addBrandModal').modal('hide');
                            $('#add_brand_form')[0].reset();
                            $('.table').load(location.href+' .table');
                            toastr.success(res.message);
                            console.log(res);
                        }
                    },
                    error: function(err){
                        toastr.success('Something is wrong! Please try again.');
                        console.log(err);
                    }
                });
            });

            $(document).on('click', '.editIconBtn', function(e){
                e.preventDefault();
                const module_id = $(this).attr('module_id');
                $.ajax({
                    url: "{{ route('brand.edit') }}",
                    type: "GET",
                    data: {module_id:module_id},
                    success: function(res){
                        $('#brand_id').val(res.id);
                        $('#old_image').val(res.brand_image);
                        $('#brand_name_en').val(res.brand_name_en);
                        $('#brand_name_bn').val(res.brand_name_bn);
                        if (res.brand_image != null) {
                            $('#brand_image').html(`
                                <img src="${res.brand_image}" style="width:100px; height: 100px;" alt="Image">
                            `);  
                        }
                        else {
                            $('#brand_image').html(`
                                <img src="no_image.jpg" width="80" height="80" alt="Image">
                            `);                                                      
                        }
                    },
                    error: function(err){
                        console.log(err);
                    },
                });
            });

            $('#edit_brand_form').submit(function(e){
                e.preventDefault();
                const fd = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('brand.update') }}",
                    method: "POST",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(res){
                        if (res.status == 200) {
                            $('#editBrandModal').modal('hide');
                            $('#edit_brand_form')[0].reset();
                            $('.table').load(location.href+' .table');
                            toastr.success(res.message);
                            console.log(res);
                        }
                    },
                    error: function(err){
                        console.log(err);
                    },
                });
            });
        });
    </script>
</body>

</html>