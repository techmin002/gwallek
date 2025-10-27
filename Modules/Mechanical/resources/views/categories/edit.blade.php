<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 24px; border: none;">
            <div class="modal-header"
                style="background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%); color:#fff;">
                <h3 class="modal-title fw-bold">Edit Mechanical Category</h3>
            </div>
            <form action="{{ route('mechanicals.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 text-start"><!-- 👈 text-start added -->
                    <div class="row gy-3">
                        <!-- Category Name -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                placeholder="Enter category name" required>
                        </div>

                        <!-- Category Image -->
                        <div class="col-md-6">
                            <label class="fw-semibold">Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if ($category->image)
                                <img src="{{ asset('upload/images/mechanicalscategories/' . $category->image) }}" alt="Category Image"
                                    class="img-thumbnail mt-2" width="100">
                            @endif
                        </div>

                        <!-- Short Description -->
                        <div class="col-md-12 mt-3">
                            <label class="fw-semibold">Short Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter short description">{{ $category->description }}</textarea>
                        </div>

                        <!-- Publish Status -->
                        <div class="col-md-12 mt-3">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Publish</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="status" value="off">
                                    <input type="checkbox" name="status" value="on"
                                        {{ $category->status == 'on' ? 'checked' : '' }} data-bootstrap-switch
                                        data-off-color="danger" data-on-color="success">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-success px-5">Update Category</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
