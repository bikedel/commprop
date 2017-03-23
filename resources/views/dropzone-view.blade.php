@extends('layouts.app')



    <title>Media uploads</title>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.2.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>

    <style>
        .dropzone {

            border: dashed 1px red;

        }
    </style>
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Property Drop</h1>
            <h3>Please enter the <red>Erf # </red>before dropping documents.<br>Word documents and images accepted.<br></h3>
            {!! Form::open([ 'route' => [ 'dropzone.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'image-upload' ]) !!}
                         Erf # <input type="text" name="fname"><br>
            <div>

              <!--  <h3>Upload images and word docs</h3> -->
            </div>
            {!! Form::close() !!}
        </div>

    </div>
</div>

<script type="text/javascript">
        Dropzone.options.imageUpload = {

            maxFilesize         :       1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.doc,.docx"
        };


</script>

@endsection
