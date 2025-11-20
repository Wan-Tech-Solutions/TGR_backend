@extends('admin.layouts.admin_master')
@section('title')
    Seminars
@endsection
@section('admin')
    <style>
        .input-group {
            margin-bottom: 10px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".add-more").click(function() {
                var html = '<div class="col-lg-6 input-group">' +
                    '<label for="inputDefault">aim to achieve:</label>' +
                    '<input type="text" class="form-control" name="aim_by[]" id="inputDefault">' +
                    '<button type="button" class="btn btn-danger remove">Remove</button>' +
                    '</div>';
                $(".input-group:last").after(html);
            });

            $(document).on("click", ".remove", function() {
                if ($('.input-group').length > 1) {
                    $(this).parent().remove();
                }
            });
        });
    </script>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('site-update-tgrseminar') }}" method="POST" id="myForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="uuid" value="{{ $tgrseminars->uuid }}">
                <section class="card">
                    <header class="card-header">
                        <h2 class="card-title">Analystics</h2>
                    </header>
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="title">Title</label>
                                <input class="form-control" name="title" value="{{ $tgrseminars->title }}"
                                    placeholder="Title">
                                @error('title')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="first_para_seminar">Body</label>
                                <textarea class="form-control" name="first_para_seminar" rows="8" placeholder="Type your message">{{ $tgrseminars->first_para_seminar }}</textarea>
                                @error('first_para_seminar')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-lg-6">
                                <label for="second_para_seminar">Second Paragraph</label>
                                <textarea class="form-control" name="second_para_seminar" rows="8" placeholder="Type your message">{{ $tgrseminars->second_para_seminar }}</textarea>
                                @error('second_para_seminar')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            <hr>
                            <div class="col-lg-6 input-group">
                                <label for="inputDefault">Aim to Achieve:</label>
                                @foreach (json_decode($tgrseminars->aim_by, true) as $aim)
                                    <div class="col-lg-6 input-group">
                                        <input type="text" class="form-control" name="aim_by[]"
                                            value="{{ $aim }}" id="inputDefault">
                                        <button type="button" class="btn btn-danger remove">Remove</button>
                                    </div>
                                @endforeach
                                <button type="button" class="btn btn-success add-more">Add More</button>
                            </div>
                            <div class="col-lg-12">
                                <label for="tgrseminar_process">tgrseminar Process</label>
                                <textarea class="form-control" name="seminar_process" rows="8" placeholder="Type your message">{{ $tgrseminars->seminar_process }}</textarea>
                                @error('tgrseminar_process')
                                    <span class="btn btn-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <footer class="card-footer text-end" style="display: block;">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </footer>
                </section>
            </form>
        </div>
    </div>
@endsection
