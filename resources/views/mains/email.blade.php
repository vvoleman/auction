<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    body{
        background: #f0f0f0;
    }
    .box{
        background: white;
        box-shadow: 0px 0px 6px 3px rgba(224,224,224,1);
        padding:15px;
        border-radius:5px;
        font-family:"Century Gothic";
    }
    .m-top{
        margin-top: 15px;
    }
    .additonal{
        font-size:11px;
        margin-top:25px;
    }
    .text{
        font-size:20px;
    }
</style>
<div class="box col-md-8 mx-auto m-top">
   <h1 class="text-center">Bidder</h1>
</div>
<div class="m-top box col-md-8 mx-auto">
    @yield("content")

    <div class="additonal text-center">Nepřejete si dostávat emaily? Můžete to vypnout v nastavení už. profilu!</div>
</div>
