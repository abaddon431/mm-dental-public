$(document).ready(function(){
    $("a").on("click",function(){
        page=$(this).data('value');
        $.post("./patient-page-fetch.php",{page:page},function(data)
        {

        });
    });
});