@extends("mains/main")
@section('title',"Registrace | ")
@section('content')
    <div class="col-md-4 col-10 mx-auto white_box m-top login">
        <h3>Registrovat</h3>
        <hr>
        <form id="register_form" method="POST" action="{{route('register.postRegister')}}">
            @csrf
            <div class="form">
                <div class="form-group">
                    <label>Jméno</label>
                    <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}">
                </div>
                <div class="form-group">
                    <label>Přijmení</label>
                    <input type="text" class="form-control" name="surname" value="{{old('surname')}}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{old('email')}}">
                </div>
                <div class="form-group">
                    <label>Stát</label>
                    <select class="form-control" id="countryselect">
                        @foreach($countries as $c)
                            <option value="{{$c->short}}">{{$c->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Kraj</label>
                    <select class="form-control" id="regionselect" name="region_id">

                    </select>
                </div>
                <div class="form-group">
                    <label>PSČ</label>
                    <input type="number" name="zipcode" class="form-control">
                </div>
                <div class="form-group">
                    <label>Ulice + č.p</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="form-group">
                    <label>Heslo</label>
                    <input type="password" class="form-control" id="password" name="password">
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
    <script src="{{URL::asset('/assets/js/custom/settings/regionsLoader.js')}}"></script>
    <script>
        new RegionsLoader();
    </script>
    <script type="text/javascript">
        //firstname <2;32>
        //surname <2;64>
        //password <8;64>
            //letters, at least one uppercase
        $("#register_form").validate({
            rules:{
                firstname:{
                    required:true,
                    minlength:2,
                    maxlength:32
                },
                surname:{
                    required:true,
                    minlength:2,
                    maxlength:64
                },
                password:{
                    minlength:8,
                    maxlength:64,
                    required:true
                },
                email:{
                    required:true,
                    email:true
                },
                zipcode:{
                    required:true,
                    minlength:5,
                    maxlength:5
                },
                address:{
                    required:true
                },
                password2:{
                    equalTo:"#password"
                },
                remember:{
                    required:true
                }
            },
            messages:{
                firstname:{
                    required:"Prosím, zadejete své jméno",
                    minlength:"Prosím, zadejte jméno o délce alespoň 2 znaky",
                    maxlength:"Prosím, zadejte jméno kratší 32 znaků"
                },
                surname:{
                    required:"Prosím, zadejete své příjmení",
                    minlength:"Prosím, zadejte příjmení o délce alespoň 2 znaky",
                    maxlength:"Prosím, zadejte příjmení kratší 64 znaků"
                },
                zipcode:{
                    required:"Prosím, zadejte své PSČ",
                    minlength:"Délka PSČ je 5 čísel",
                    maxlength:"Délka PSČ je 5 čísel"
                },
                address:{
                    required:"Prosím, zadejte svou ulici a č.p"
                },
                email:{
                    required:"Prosím, zadejte emailovou adresu",
                    email:"Prosím, zadejte platnou emailovou adresu"
                },
                password:{
                    required:"Prosím, zadejte své heslo",
                    minlength:"Prosím, zadejte heslo o délce alespoň 8 znaků",
                    maxlength:"Prosím, zadejte heslo kratší 64 znaků"
                },
                password2:{
                    equalTo:"Hesla se musí shodovat!"
                },
                remember:{
                    required:"Musíte souhlasit s podmínkami!"
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
