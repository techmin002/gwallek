@extends('setting::layouts.master')

@section('title', 'Products')
@section('breadcrumb')
<ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title float-right">
                                <a class="btn btn-info text-white" data-toggle="modal"
                                    data-target="#createProductModal">
                                    <i class="fa fa-plus"></i> Create
                                </a>
                            </h3>
                            @include('product::products.create')
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Brand</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Unit</th>
                                        @if (auth()->user()->hasRole('Super Admin'))
                                        <th class="text-center">Branch</th>
                                        @endif
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $product->name }}</td>
                                        <td class="text-center">
                                            {{ $product->category ? $product->brand->name : '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $product->category ? $product->category->name : '-' }}
                                        </td>
                                        <td class="text-center">{{ number_format($product->price, 2) }}</td>
                                        <td class="text-center">{{ $product->stock }}</td>
                                        <td class="text-center">
                                            {{ $product->category ? $product->unit->name : '-' }}
                                        </td>
                                        @if (auth()->user()->hasRole('Super Admin'))
                                        <td class="text-center">
                                            
                                            {{ $product->branch ? $product->branch->name : '-' }}
                                 
                                        </td>
                                        @endif
                                        <td class="text-center">{!!   $product->description ?? '-' !!}
                                        </td>
                                        <td class="text-center">
                                            @if ($product->image)
                                            <img src="{{ asset('upload/products/' . $product->image) }}"
                                                alt="{{ $product->name }}" width="50">
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($product->status == 'on')
                                            <a href="{{ route('products.status', $product->id) }}"
                                                class="btn btn-success btn-sm">On</a>
                                            @else
                                            <a href="{{ route('products.status', $product->id) }}"
                                                class="btn btn-danger btn-sm">Off</a>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}"
                                                method="POST" style="display:inline-block;"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            {{-- <a href="{{ route('product_details', $product->id) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip"
                                            data-placement="top" title="View Details">
                                            <i class="fa fa-eye"></i>
                                            </a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">S.N</th>
                                        <th class="text-center">Product Name</th>
                                        <th class="text-center">Brand</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Unit</th>
                                        @if (auth()->user()->hasRole('Super Admin'))
                                        <th class="text-center">Branch</th>
                                        @endif
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endsection