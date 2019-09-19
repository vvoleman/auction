@extends("mains/main")
@section('title',"Test")
@section('content')
    <div class="col-md-4 col-10 mx-auto white_box m-top login">
        <h3>Přihlášení</h3>
        <hr>
        <form id="login_form" method="POST" action="{{route('login.postLogin',"cs")}}">
            @csrf
            <div class="form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Heslo</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <input class="btn-block" type="submit" value="Přihlásit se">
            </div>
        </form>
    </div>
@stop
@section("scripts")
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $("#login_form").validate({
            rules:{
                email:{
                    required:true,
                    email:true
                },
                password:{
                    required:true
                }
            },
            messages:{
                email:"Prosím, zadejte svojí emailovou adresu",
                password:"Prosím, zadejte své heslo"
            },
            errorPlacement: function(error, element) {
                var el = $(element).parent().children("input");
                console.log(el);
                $(el).addClass('input-error');
            },
            success(label,element){
                var el = $(element).parent().children("input");
                $(el).removeClass('input-error');
            }
        });
    </script>
@stop
