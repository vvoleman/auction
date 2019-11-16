tinymce.init({
    selector: '.description textarea',
    branding: false,
    plugins: ["lists advlist hr table link"],
    statusbar: false,
    menubar: false,
    toolbar: "undo redo | styleselect | bold italic | table | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | table | fontsizeselect | forecolor | hr link",
    setup: function (ed) {
        // gets executed when the editor is fully loaded
        ed.on('init', function (args) {
            $(".loader").fadeOut(400,()=>{
                $(".description").fadeIn();
            });

        });
    },
});
