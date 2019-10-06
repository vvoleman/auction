@extends('mains/main')
@section('title','Zapomenuté heslo |')
@section('content')
    <div class="white_box col-md-4 col-10 mx-auto m-top">
        <h3>Zapomněli jste heslo?</h3>
        <hr>
        <form id="form" action="{{route('forgot.postForgot')}}" method="POST">
            @csrf
            <div class="form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <input type="submit" class="btn btn-block btn-blue" value="Odeslat">
            </div>
        </form>
    </div>
@stop
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script>
        $("#form").validate({
            rules:{
                email:{
                    required:true,
                    email:true
                }
            },
            messages:{
                email:{
                    required:"Email musí být vyplněn!",
                    email:"Neplatný formát emailu!"
                }
            },
            errorPlacement: function(error, element) {
                var el = $(element).parent().children("input");
                console.log(el[0]);
                $(el).addClass('input-error');
                $(error).addClass("error_text");
                el.parent().append(error);

            },
            success(label,element){
                var el = $(element).parent().children("input");
                $(el).removeClass('input-error');
            }
        });
    </script>
@stop
