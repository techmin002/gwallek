@extends('setting::layouts.master')

@section('title', 'Inventories')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inventories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Inventories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Product Inventories</h3>
                                {{-- @can('create_inventory')
                                    <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i> Add New
                                    </a>
                                @endcan --}}
                            </div>

                            <div class="card-body">
                                @if ($inventories->isEmpty())
                                    <div class="alert alert-info">
                                        <i class="icon fas fa-info-circle"></i> No product inventory found
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table id="example1"
                                            class="table table-hover table-bordered table-striped text-center">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Product</th>
                                                    <th>Branch</th>
                                                    <th>Updated By</th>
                                                    <th>Quantity</th>
                                                    <th>Opening Qty</th>
                                                    <th>Status</th>
                                                    @canany(['edit_inventory', 'delete_inventory'])
                                                        <th>Actions</th>
                                                    @endcanany
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($inventories as $inventory)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $inventory->product->name ?? 'N/A' }}</td>
                                                        <td>{{ $inventory->branch->name ?? 'N/A' }}</td>
                                                        <td>{{ $inventory->user->name ?? 'N/A' }}</td>
                                                        <td>{{ number_format($inventory->quantity) }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($inventory->opening_quantity) }}</td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $inventory->status == 1 ? 'success' : 'danger' }}">
                                                                {{ $inventory->status == 1 ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        @canany(['edit_inventory', 'delete_inventory'])
                                                            <td>
                                                                @can('edit_inventory')
                                                                    <a href="{{ route('inventories.edit', $inventory->id) }}"
                                                                        class="btn btn-sm btn-primary" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('delete_inventory')
                                                                    <form
                                                                        action="{{ route('inventories.destroy', $inventory->id) }}"
                                                                        method="POST" style="display: inline-block;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                            title="Delete"
                                                                            onclick="return confirm('Do you really want to delete this inventory record?')">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            </td>
                                                        @endcanany
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#inventories-table').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 25,
                dom: '<"top"<"float-left"l><"float-right"f>><"clear">rt<"bottom"<"float-left"i><"float-right"p>><"clear">',
                columnDefs: [{
                    targets: -1,
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush
