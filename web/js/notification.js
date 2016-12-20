/**
 * Created by Edgar on 07/09/2016.
 */

$(document).ready(function()
{


    function jqUpdateSize(){
        // Get the dimensions of the viewport
        var width = $(window).width();
        var height = $(window).height();
        console.log(width);

        /*if(width<1200)
        {
            $('.question-title').hide();
        }else {
            $('.question-title').show();
        }*/

    };

    $(window).resize(jqUpdateSize);     // When the browser changes size
});