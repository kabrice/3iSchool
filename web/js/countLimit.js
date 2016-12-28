$(document).ready(function()
{


    $('.expandDiv').find('br').remove();
    $(".expandDiv > p").each(function () {
        $(this).replaceWith($(this).text() + ". ");
    });

    function limitCharacter(number){
        $('div.expandDiv').expander({
            slicePoint: number, //It is the number of characters at which the contents will be sliced into two parts.
            expandSpeed: 0, // It is the time in second to show and hide the content.
            userCollapseText: 'Lire moins' // Specify your desired word default is Less.
        });

        $('div.expandDiv').expander();


    }

    jqUpdateSize();
    function jqUpdateSize(){
        // Get the dimensions of the viewport
        var width = $(window).width();
        var height = $(window).height();
       // console.log(width);

        if(width<576)
         {
             limitCharacter(80);
         }else {
            limitCharacter(80);
         }


    };

    $(window).resize(jqUpdateSize);     // When the browser changes size


});
