class ProfileImage{
    hidden;
    constructor(hidden){
        this.hidden = hidden;
    }
    oldClicked(e){
        $(this.hidden).val($(e.target).attr("data"));
        $(".active").removeClass("active");
        $(e.target).addClass("active");
        $("#oldsubmit").attr('disabled',false);
    }
    imageUploaded(e){
        let temp = e.target.files;
        if(temp.length == 1){
            const accepted = ['image/gif', 'image/jpeg', 'image/png'];
            if(accepted.includes(temp[0].type)){
                var reader = new FileReader();
                reader.onload = (e)=>{
                    $("#imgpreview").children("img").attr("src",e.target.result);
                }
                reader.readAsDataURL(temp[0]);
                $("#imgpreview").fadeIn();
                return;
            }else{
                const msg = "Nepodporovaný formát obrázku!";
            }
        }else{
            const msg = "Nelze načíst obrázek!";
        }
    }
    clearImg(){
        $("#imgpreview").fadeOut();
        $("#imgpreview").children("img").attr("src","");
    }

}
