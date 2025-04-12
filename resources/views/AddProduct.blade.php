@extends('Layouts.Layout')
@section('content')

<div class="container">
    <div class="form-container" style="padding: 2%; box-shadow: 0 0 5px #5de9e9, 0 0 10px #976835; background:rgb(252, 251, 251); border-radius: 10px; ">
        <p style="font-size: 20px; font-weight:600" class="mt-3" >Add Products :</p>
        <form id="ProductCategoryPage" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-sm-6 mb-3">
                    <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                    <span id="errname" class="text-danger"></span>
                </div>

                <div class="col-sm-6 mb-3">
                    <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Enter price">
                    <span id="errprice" class="text-danger"></span>
                </div>

                <div class="col-sm-6 mb-3">
                    <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter description">
                    <span id="errdescription" class="text-danger"></span>
                </div>

                <div class="col-sm-6 mb-3">
                    <label for="image" class="form-label">Image<span class="text-danger">*</span></label>
                    <input type="file" class="form-control" id="image" name="image" placeholder="Enter Name">
                    <span id="errimage" class="text-danger"></span>
                </div>

                <div class="col-sm-6">

                    <div class="d-grid">
                        <button type="submit" id="addProduct" class="btn btn-primary form-control">Submit</button>
                    </div>
                </div>

                <div class="col-sm-6">
                <div class="d-grid">
                        <div id="success_message_box_visitorCategory" class="alert alert-success" style="display: none;">
                            <span id="success_message_visitorCategory"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


{{-- ************************  Visitor Categories Data Show in the Table formate  **************************--}}
<div class="container-flaut">
    <div class="table-container">
        <p style="font-size: 20px; font-weight:600" class="mt-3" >Category Report :</p>
        <div class="row mt-4 table-responsive">
            <table id="exampleTable" class="table table-hover table-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product_Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr id="row-{{ $product->id }}">
                            <td>{{ $product->id}}</td>
                            <td>{{ $product->name}}</td>
                            <td>{{ $product->price}}</td>
                            <td>{{ $product->description}}</td>
                            <td>
                                <img src="{{ asset('storage/products/' . $product->image) }}" alt="Product Image" width="60" height="60" style="border-radius: 50%">
                            </td>
                            <td>

                                <button class="btn btn-sm btn-secondary editProductBtn" data-id="{{$product->id}}" data-bs-toggle="modal">Edit</button>

                                <button class="btn btn-sm btn-danger deleteCategory" onclick="deleteProduct({{ $product->id }})"  >Delete</button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>


{{-- ******************************  Edit Product Category  ************************************* --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Product</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="product_id">

                <div class="modal-body">
                    <label>Name:</label>
                    <input type="text" name="name" id="edit_name" class="form-control">

                    <label>Price:</label>
                    <input type="text" name="price" id="edit_price" class="form-control">
                    <label>Description:</label>
                    <input type="text" name="description" id="edit_description" class="form-control">
                    <label>Image:</label>
                    <input type="file" name="image" id="edit_image" class="form-control" value="">
                    <img id="previewImage" src="" width="100" height="100" class="mt-3">
                    
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary updateProdductData">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
//*****************************************************  Create New Category  ******************************************************
    
    $('#addProduct').click(function(e){
        e.preventDefault();
        var formData = new FormData($('#ProductCategoryPage')[0]);

        $.ajax({
            type: "POST",
            url: "{{ url('/create_products') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {

                if (response.status === 200) 
                    {
                        $('#success_message_visitorCategory').text(response.message || "Event created successfully!");
                        $('#success_message_box_visitorCategory').fadeIn();
                        $('#ProductCategoryPage')[0].reset();

                        // Table Row Add
                        $('#exampleTable tbody').append(`
                            <tr id="row-${response.data.id}">
                                <td>${response.data.id}</td>
                                <td>${response.data.name}</td>
                                <td>${response.data.price}</td>
                                <td>${response.data.description}</td>
                                <td>
                                    <img src="/storage/products/${response.data.image}" alt="Product Image" width="60" height="60" style="border-radius: 50%">
                                </td>
                                <td>

                                    <button class="btn btn-sm btn-secondary editCategoryBtn" data-id="${response.data.id}" data-bs-toggle="modal">Edit</button>

                                    <button class="btn btn-sm btn-danger deleteCategory" onclick="deleteProduct(${response.data.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                        setTimeout(() => {
                            $('#success_message_box_visitorCategory').fadeOut();
                            $('#row-')
                        }, 5000);
                    } 
                    else {
                        handleValidationErrors(response.errors);
                    }
            },
            

        });
    });

//*****************************************************  Create New Category  ******************************************************
 
 
 

// ******************************************  Udate Category Details  **************************************************************

 // Get Category Details for Edit
    $('.editProductBtn').click(function(){
        var id = $(this).data('id');

        $.ajax({
            url: '/product-edit/' + id,
            type: 'GET',
            success: function(response){
                $('#product_id').val(response.data.id);
                $('#edit_name').val(response.data.name);
                $('#edit_price').val(response.data.price);
                $('#edit_description').val(response.data.description);
                // $('#edit_image').val(response.data.image);
                // $('#oldImageName').text(response.data.image);

                $('#previewImage').attr('src', '/storage/products/' + response.data.image);

                $('#editProductModal').modal('show');
            },
        });
    });

    // Update Category
    $('.updateProdductData').click(function(e){
        e.preventDefault();

    var id = $('#product_id').val();

    // var formData = new FormData('#editProductForm'); // FormData object banaya
    var formData = new FormData($('#editProductForm')[0]);  // Correct way

    formData.append('id', id);
        $.ajax({
            url: '/product-update/' + id,
            type: 'POST',
            data: formData,
            contentType: false,     
            processData: false,
            success: function(response) {
                if(response.status == 200) {
                    
                    // Row Update
                    $('#row-' + id).find('td:eq(1)').text(response.data.name);
                    $('#row-' + id).find('td:eq(2)').text(response.data.price);
                    $('#row-' + id).find('td:eq(3)').text(response.data.description);
                    $('#row-' + id).find('td:eq(4) img').attr('src', response.data.image_url);

                    alert(response.message);
                    $('#editProductModal').modal('hide');
                }
            },
            error: function(xhr) {
            // Yeh code tab chalega jab backend error bhejega
            if(xhr.responseJSON && xhr.responseJSON.message){
                alert(xhr.responseJSON.message);  
            } else {
                alert('Something went wrong!');
            }
        }
        });
    });

// ******************************************  Udate Category Details  **************************************************************







// ***************************************************  Delete Category  *****************************************************

    function deleteProduct(id) {

        if(!confirm('Are you sure want to delete?')) {
            return false;
        }

        $.ajax({
            url: '/product-delete/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status == 200) {
                    $('#row-' + id).remove();
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                alert('Something went wrong!');
            }
        });

    }

// ***************************************************  Delete Category  *****************************************************


</script>
@endsection