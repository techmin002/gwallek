{{-- resources/views/product/products/create.blade.php --}}
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center"
                style="background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%); color:#fff;">
                <h3 class="modal-title fw-bold">Create Product</h3>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row gy-3">

                        <!-- Product Name -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter product name"
                                required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div class="col-md-3 mt-3">
                            <label class="fw-semibold">Brand</label>
                            <select name="brand_id" class="form-control" required>
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="col-md-3 mt-3">
                            <label class="fw-semibold">Price</label>
                            <input type="number" step="0.01" name="price" class="form-control"
                                placeholder="Enter price">
                        </div>

                        <!-- Units -->
                        <div class="col-md-3 mt-3">
                            <label class="fw-semibold">Units</label>
                            <select name="unit_id" class="form-control">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Stock (optional) -->
                        <div class="col-md-3 mt-3">
                            <label class="fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control" placeholder="Enter stock">
                        </div>

                        <!-- Branch -->
                        @if (auth()->user()->name === 'Super Admin')
                            <!-- Show branch select only for Super Admin -->
                            <div class="col-md-6 mt-3">
                                <label class="fw-semibold">Branch</label>
                                <select name="branch_id" class="form-control" required>
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <!-- Hidden input for other users -->
                            <input type="hidden" name="branch_id" value="{{ auth()->user()->branch_id }}">
                        @endif


                        <!-- Main Image -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <label class="fw-semibold">Description</label>
                            <textarea name="description" class="form-control" id="summernote" placeholder="Enter description"></textarea>
                        </div>


                        <!-- Publish Status -->
                        <div class="col-md-12 mt-3">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Publish</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="status" value="off">
                                    <input type="checkbox" name="status" value="on" checked data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success px-5">Save Product</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
