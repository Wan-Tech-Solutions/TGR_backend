@extends('admin.layouts.admin_master')
@section('title')
    Prospectus
@endsection
@section('admin')
    <div class="row">
        <div class="col">
            <section class="card card-modern card-big-info">
                <div class="card-body" style="background-color: burlywood;">
                    <form action="{{ route('store-prospectus') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-2-5 col-xl-1-3">
                                <i class="card-big-info-icon bx bx-box"></i>
                                <h2 class="card-big-info-title">PROSPECTUS</h2>
                            </div>
                            <div class="col-lg-3-5 col-xl-4-5">
                                <div class="form-group row pb-4">
                                    <label
                                        class="col-lg-2 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">PROSPECTUS</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <input type="file" class="form-control form-control-modern" id="prospectus-file"
                                            name="prospectus" accept=".pdf">
                                        <span id="file-name" class="pt-2"></span>
                                        @error('prospectus')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-info" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <script>
        document.getElementById('prospectus-file').addEventListener('change', function(event) {
            const fileName = event.target.files[0]?.name; // Optional chaining to prevent errors
            if (fileName) {
                document.getElementById('file-name').textContent = "Selected file: " + fileName;
            } else {
                document.getElementById('file-name').textContent = ""; // Clear if no file is selected
            }
        });
    </script>
@endsection
