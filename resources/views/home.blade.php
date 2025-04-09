@extends('Layouts.Layout')

@section('content')
<?php  
    $totalUsers= count($latestUsers);
    $totalProducts = count($latestProducts);
?>
    <div class="container">
        <h1>Dashboard</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">{{ $totalUsers }}</p>

                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text">{{ $totalProducts }}</p>
                        <a href="{{ url('/show_products')}}" class="btn btn-light btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                       <span> 🎁 </span> Recent Product
                    </div>
                    <div class="card-body">
                        @if ($latestProducts->isEmpty())
                            <p class="card-text">No users registered recently.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($latestProducts as $product)
                                    <li class="list-group-item">
                                        <span><b>Name : </b></span>{{ $product->name }} - <span><b>Price : </b></span>({{ $product->price }}) - <b>Registered At : </b> {{ $product->created_at->format('Y-m-d') }}
                                        
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow">
                    <div class="card-header">
                    👤 Latest Registered Users
                    </div>
                    <div class="card-body">
                        @if ($latestUsers->isEmpty())
                            <p class="card-text">No users registered recently.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($latestUsers as $user)
                                    <li class="list-group-item">
                                        {{ $user->name }} ({{ $user->email }}) - Registered At: {{ $user->created_at->format('Y-m-d') }}
                                        
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        </div>
@endsection