<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wellcome to ByteQuest login page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
    



    </style>
</head>
<body>
    <!-- Section: Design Block -->
<section class="text-center">

    <div class="card mx-md-5 shadow-5-strong bg-body-tertiary mt-5" style="backdrop-filter: blur(50px);">
      <div class="card-body py-2 px-md-5">
        <div class="mb-3 mt-3">
            <img
              src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
              alt="Avatar"
              width="80"
            />
        </div>
        
        <div class="row d-flex justify-content-center">
          <div class="col-lg-5" style="font-family: cursive;">
            <div class="company" style="">
               
                <span class="fw-bold" style="font-size: 35px; color: #13919B;" >ByteQuest Software Pvt. Ltd</span>
            </div>
            <h4 class="fw-bold mb-3">Existing users, this way please!</h4>
            <div class="login-hint mb-4">
                <p>Login Your Account</p>
            </div>
            <form>
                @csrf
              <!-- Email input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label">User Name<span>*</span></label></br>
                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Username" />
                <span id="erremail" class="validate"></span>

              </div>

              <!-- Password input -->
              <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label">Password<span>*</span></label></br>
                <input  type="password" name="password" id="password" class="form-control" placeholder="Enter Your Password" />
                <span id="errpassword" class="validate"></span>
              </div>
              <!-- ********************  Login Resgister Btn  *********************** -->
            <div>
            <input type="button" id="submit" onclick="invalid()" class="loginbtn mb-4" value="Login >" />

            <input type="button" id="submit" class="signup mb-4" value="Sign Up >" onclick="window.location='/register'" />

            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Section: Design Block -->


    <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

  <script>
    function invalid(){
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            url: "{{ url('/login') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {"email": email, "password": password, "_token": "{{csrf_token()}}"},
            success: function (res) {
                console.log(res);
                if (res.status == 200) {
                    window.location.href = "{{ url('/home')}}";
                }
            },
            error: function(xhr, status, error) {
                const parsedResponse = JSON.parse(xhr.responseText);
                console.log(parsedResponse.error);
                let keys = ['email', 'password'];
                keys.forEach((key) => {
                    if (parsedResponse.error.hasOwnProperty(key)) {
                        $(`#err${key}`).text(parsedResponse.error[key][0]); // Corrected selector syntax
                        setTimeout(() => {
                            $(`#err${key}`).text(''); // Reset error message after 3 seconds
                            $('#errmessage').text('');
                        }, 3000);
                    }
                });
            }
        });
    }
</script>




</body>
</html>