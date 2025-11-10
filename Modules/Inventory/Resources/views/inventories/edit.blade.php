@extends('setting::layouts.master')

@section('title', 'Edit Inventory')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <h1>Edit Inventory</h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Inventory</h3>
                    </div>
                    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label for="product_id">Product</label>
                                <select name="product_id" id="product_id" class="form-control" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach ($products as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $inventory->product_id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="branch_id">Branch</label>
                                <select name="branch_id" id="branch_id" class="form-control" required>
                                    <option value="">-- Select Branch --</option>
                                    @foreach ($branches as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $inventory->branch_id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" name="quantity" class="form-control"
                                    value="{{ old('quantity', $inventory->quantity) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="1" {{ $inventory->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $inventory->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('inventories.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
