<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
<div class="container mt-5">
<div class="form-container">
        <h3 class="text-center mb-4">User Registration</h3>
        <form id="registerForm" >
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your full name" >
                <span id="errname" class="validate"></span>
            </div>

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email_Id</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" >
                <span id="erremail" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Phone_Number</label>
                <input type="text" class="form-control" id="phone" placeholder="Enter your Phone number" >
                <span id="errphone" class="validate"></span>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="Enter your Address" >
                <span id="erraddress" class="validate"></span>
            </div>



            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" >
                <span id="errpassword" class="validate"></span>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>

    <div id="success_message_box" class="success-message-box" style="display: none;">
        <span id="success_message"></span>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // Bind submit event to the form
    $(document).ready(function () {
        $('#registerForm').on('submit', function (e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var address = $('#address').val();
            var password = $('#password').val();

            // AJAX request
            $.ajax({
                url: "/api/auth/user/register",
                type: "POST",
                headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                data: {
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    password: password
                },
                success: function (response) {
                    if (response.status == 200) {
                        $('#success_message').text("✅ User Created Successfully!");
                        $('#success_message_box').fadeIn();

                        $('#registerForm')[0].reset();

                        setTimeout(() => {
                            $('#success_message_box').fadeOut();
                        }, 5000);
                    } else {
                        alert(response.error);
                    }
                },
                error: function (xhr, status, error) {
                    const parsedResponse = JSON.parse(xhr.responseText);
                    let keys = ['name', 'email', 'phone', 'address', 'password'];

                    keys.forEach((key) => {
                        if (parsedResponse.error.hasOwnProperty(key)) {
                            $(`#err${key}`).text(parsedResponse.error[key][0]);
                            setTimeout(() => {
                                $(`#err${key}`).text(''); // Reset error message after 5 seconds
                            }, 5000);
                        }
                    });

                }
            });
        });
    });
</script>
</body>
</html>
