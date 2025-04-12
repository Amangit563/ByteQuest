
<nav class="navbar">
        <div class="logo">ByteQuetes</div>
        <ul class="nav-links">
            <li><a href="{{ url('/home')}}">Home</a></li>
            <li><a href="{{ url('/about')}}">About</a></li>
            <li><a href="{{ url('/show_products') }}">Products</a></li>
            <li><a href="#">Contact</a></li>
        </ul>


        <div class="d-flex">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Logout
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a href="{{ route('logout') }}"  class="dropdown-item" onclick="return confirm('Are you sure you want to logout?')">🔒 Logout</a>
                    </li>
                </ul>
            </div>
        </div>


        <div class="toggle-button">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
</nav>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

        const toggleButton = document.querySelector('.toggle-button');
        const navLinks = document.querySelector('.nav-links');

        toggleButton.addEventListener('click', () => {
            navLinks.classList.toggle('active');


        });
    function logoutUser() {
        $.ajax({
            url: "/api/logout",
            type: "POST",
            headers: {
                'Authorization': 'Bearer {{ auth()->user()->current_access_token ?? '' }}'
            },
            data: {
                _token: '{{ csrf_token() }}'  // CSRF token
            },
            success: function(response) {
                console.log(response.message);
                window.location.href = "/login";  // Redirect to Login page
            },
            error: function(xhr) {
                console.log(xhr.responseJSON.message);
            }
        });
    }
</script>