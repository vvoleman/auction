@extends("mains/main")
@section('title',"Test")
@section('content')
    <div class="col-md-4 col-10 mx-auto white_box m-top login">
        <h3>Registrovat</h3>
        <hr>
        <form id="register_form" method="POST" action="{{route('login.postLogin')}}">
            @csrf
            <div class="form">
                <div class="form-group">
                    <label>Jméno</label>
                    <input type="text" class="form-control" name="firstname">
                </div>
                <div class="form-group">
                    <label>Přijmení</label>
                    <input type="text" class="form-control" name="surname">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Heslo</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group">
                    <label>Heslo znovu</label>
                    <input type="password" class="form-control" name="password2">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input">
                    <label for="remember" class="form-check-label">Souhlasím s podmínkami</label>
                </div>
                <input class="btn-block m-top" type="submit" value="Registrovat se">
            </div>
        </form>
    </div>
@stop
@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        //firstname <2;32>
        //surname <2;64>
        //password <8;64>
            //letters, at least one uppercase
        $("#register_form").validate({
            rules:{
                firstname:{
                    required:true,
                    min:2,
                    max:32
                },
                surname:{
                    required:true,
                    min:2,
                    max:64
                },
                password:{
                    min:8,
                    max:64,
                    required:true
                },
                email:{
                    required:true,
                    email:true
                },
                password2:{
                    required:true,
                    equalTo:"password"
                }
            },
            messages:{
                email:"Prosím, zadejte svojí emailovou adresu",
                password:"Prosím, zadejte své heslo"
            },
            errorPlacement: function(error, element) {
                var el = $(element).parent().children("input");
                $(el).addClass('input-error');
                console.log(error);
                el.parent().append(error);

            },
            success(label,element){
                var el = $(element).parent().children("input");
                $(el).removeClass('input-error');
            }
        });
    </script>
@stop
