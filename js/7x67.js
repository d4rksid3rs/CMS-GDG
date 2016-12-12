/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    $(".grid tr:odd").css("background-color","#FFFFFF");
    $(".grid tr:even").css("background-color","#CCC");
                
    $(".grid tr").mouseover(function(){
        $(this).css("background-color","#00B0B0"); 
    }).mouseout(function(){
        $(".grid tr:odd").css("background-color","#FFFFFF");
        $(".grid tr:even").css("background-color","#CCC");
    });
                
    $(".grid .box_header a").click(function(){
        $(this).parents(".box").children(".box_body").slideToggle(500);
        if ($(this).parents(".box_header").css("background-image").indexOf("expand") > 0) {
            $(this).parents(".box_header").css("background-image", "url(images/collapse_blue.gif)");
        } else {
            $(this).parents(".box_header").css("background-image", "url(images/expand_blue.gif)");
        }
    });

});
