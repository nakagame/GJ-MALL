@extends('seller.layouts.app')

@section('title', 'Seller Evaluation')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/seller/evaluation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <div class="container main">
        <div class="row justify-content-center pt-3">
            <h1 class="h2 fw-bold">Evaluation Products List</h1>

            {{-- Search bar --}}
            <div class="col-6 my-2">
                <div class="navbar-nav">
                    <form action="#">
                        <input type="search" name="search" placeholder="Search..." style="width: 500px"  class="form-control form-control-sm">
                    </form>
                </div>
            </div>
            <div class="col-6 mb-2">
                <span class="fw-bold montserrat">Filtered By </span> 
                <button class="btn btn-sm custom-button1 rounded-pill">Status</button>
                <button class="btn btn-sm custom-button2 rounded-pill">Category</button>
            </div>

            {{-- Table - Evaluation Product List --}}
            <div class="table main">
                <table class="table table-hover align-middle bg-white border">
                    <thead class="small table-secondary text-light">
                        <tr>
                            {{-- Table Head --}}
                            <th>ID</th>
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Weight</th>
                            <th>is Fragile</th>
                            <th>Seller Name</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{-- No.1 --}}
                            <td>1</td>
                            <td>Cloth</td>
                            <td>Kimono</td>
                            <td>$100</td>
                            <td>160cm(S)</td>
                            <td>1kg</td>
                            <td>No</td>
                            <td>Kimono Shop</td>
                            <td>This is a tradistional cloth</td>
                            <td>1: Waiting for Evaluation</td>
                        </tr>
                        <tr>
                            {{-- No.2 --}}
                            <td>2</td>
                            <td>Dish</td>
                            <td>Arita-yaki</td>
                            <td>$50</td>
                            <td>160cm(S)</td>
                            <td>0.5kg</td>
                            <td>Yes</td>
                            <td>Dish Shop</td>
                            <td>This is a tradistional dish</td>
                            <td>2: Evaluating</td>
                        </tr>
                        <tr>
                            {{-- No.3 --}}
                            <td>3</td>
                            <td>xxx</td>
                            <td>xxx</td>
                            <td>$500</td>
                            <td>xxx</td>
                            <td>10kg</td>
                            <td>No</td>
                            <td>xxx Shop</td>
                            <td>xxxxxxxxxxx</td>
                            <td>3: Waiting for Display</td>
                        </tr>
                        <tr>
                            {{-- No.4 --}}
                            <td>4</td>
                            <td>xxx</td>
                            <td>xxx</td>
                            <td>$250</td>
                            <td>xxx</td>
                            <td>6kg</td>
                            <td>No</td>
                            <td>xxx Shop</td>
                            <td>xxxxxxxxxxx</td>
                            <td>4: Suspended</td>
                        </tr>
                        <tr>
                            {{-- No.5 --}}
                            <td>5</td>
                            <td>xxx</td>
                            <td>xxx</td>
                            <td>$50</td>
                            <td>xxx</td>
                            <td>1kg</td>
                            <td>No</td>
                            <td>xxx Shop</td>
                            <td>xxxxxxxxxxx</td>
                            <td>3: Waiting for Display</td>
                        </tr>                        
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Banner --}}
        <div class="row my-5 ">
            <div class="col banner mx-auto">
                <div class="row mt-3">
                    <div class="col-auto">
                        <img src="{{ asset('images/common/Logo.png') }}" alt="gj-mall-logo" class="logo">
                    </div>
                    <div class="col">
                        <h2 class="gj-mall">GJ-MALL</h2>
                        <h4 class="sub-title">Japanese HighQuality Products E-commerce Site</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection