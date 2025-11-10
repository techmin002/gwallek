<div class="modal fade" id="createUnitModal" tabindex="-1" role="dialog" aria-labelledby="createUnitModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg" style="border-radius: 24px; border: none;">
            <div class="modal-header justify-content-center"
                style="background: linear-gradient(90deg, #08A4A4 60%, #0E8388 100%); color:#fff;">
                <h3 class="modal-title fw-bold">Create Unit</h3>
            </div>

            <form action="{{ route('units.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row gy-3">

                        <!-- Unit Name -->
                        <div class="col-md-12">
                            <label class="fw-semibold">Unit Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter unit name"
                                required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mt-3">
                            <label class="fw-semibold">Description</label>
                            <textarea name="description" class="form-control" id="summernote" rows="4"></textarea>
                        </div>

                        <!-- Publish Status -->
                        <div class="col-lg-12 mt-3">
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
                    <button type="submit" class="btn btn-success px-5">Save</button>
                    <button type="button" class="btn btn-danger px-5" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
