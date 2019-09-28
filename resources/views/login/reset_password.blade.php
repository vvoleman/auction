@extends('mains/main')
@section('title',"Resetování hesla | ")
@section('content')
    <div class="white_box col-md-4 col-10 mx-auto m-top">
        <h3>Resetování hesla</h3>
        <hr>
        <form id="form" action="{{route('forgot.update',["token"=>$token])}}" method="POST">
            @csrf
            @method('patch')
            <div class="form">
                <div class="form-group">
                    <label>Nové heslo</label>
                    <input type="password" name="password1" class="form-control" id="p">
                </div>
                <div class="form-group">
                    <label>Nové heslo znovu</label>
                    <input type="password" name="password2" class="form-control">
                </div>
                <input type="submit" class="btn btn-block btn-blue" value="Resetovat heslo">
            </div>
        </form>
    </div>
@stop
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script>
        $("#form").validate({
            rules:{
                password1:{
                    required:true,
                    minlength:8,
                    maxlength:64
                },
                password2:{
                    equalTo:"#p"
                }
            },
            messages:{
                password1:{
                    required:"Prosím, zadejte heslo",
                    minlength:"Prosím, zadejte heslo o délce alespoň 8 znaků",
                    maxlength:"Prosím, zadejte heslo kratší 64 znaků"
                },
                password2:{
                    equalTo:"Hesla se musí shodovat!"
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
