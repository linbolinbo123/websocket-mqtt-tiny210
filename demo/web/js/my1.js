/**
 * Created by Administrator on 2018/4/20.
 */
$(function () {
    $(".center-right-shang a").each(function(){
        $(this).on("mouseenter", function () {
            $(this).children().stop().animate({
                "width":"150%",
                "height":"150%",
                "z-index":"5",
                "top":"-25%",
                "left":"-25%"
            },300);
        })
        $(this).on("mouseleave", function () {
            $(this).children().stop().animate({
                "width":"100%",
                "height":"100%",
                "z-index":"0",
                "top":"0",
                "left":"0"
            },300);
        })
    })


    function donghua(){
        $('#animate').removeClass('current');
        // 延时100毫秒执行
        setTimeout(function () {
            $('#animate').addClass('current');
        }, 300);
        $("#animate #btn").hide();
        setTimeout(function () {
            $("#animate #btn").fadeIn(3000);
        }, 5000);

    }
    donghua();
    setTimeout('aaa();',7000);
       
   

    $("#animate #btn").on("click", function () {
        $("#animate").fadeOut(1000);
        setTimeout(function () {
            $("#center-left").fadeIn(1000);
            $("#center-right").fadeIn(1000);
        },1100);

    })

    function left_click(){
        $("#product").on("click", function () {
            $("#center-right .product").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .product").fadeIn(1000);
            }, 1000);
        })
        $("#teacher").on("click", function () {
            $("#center-right .teacher").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .teacher").fadeIn(1000);
            }, 1000);
        })
        $("#group").on("click", function () {
            $("#center-right .group").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .group").fadeIn(1000);
            }, 1000);
        })
        $("#table").on("click", function () {
            $("#center-right .table").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .table").fadeIn(1000);
            }, 1000);
        })
        $("#curve").on("click", function () {
            $("#center-right .curve").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .curve").fadeIn(1000);
            }, 1000);
        })
        $("#home").on("click", function () {
            $("#center-right .Home").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .Home").fadeIn(1000);
            }, 1000);
        })
    }
    left_click();

    $("#s").keydown(function() {
        if (event.keyCode == "13") {//keyCode=13是回车键
            $('.search-submit').click();
        }
    });

    $(".search-submit").on("click", function () {
        str=$("#s").val();
       /* if(str==="product description"){
            $("#center-right .product").siblings().fadeOut(1000);
            setTimeout(function () {
                $("#center-right .product").fadeIn(1000);
            }, 1000);
        }*/
        switch (str){
            case "product description":
                $("#center-right .product").siblings().fadeOut(1000);
                setTimeout(function () {
                    $("#center-right .product").fadeIn(1000);
                }, 1000);
                break;
            case "instructor":
                $("#center-right .teacher").siblings().fadeOut(1000);
                setTimeout(function () {
                    $("#center-right .teacher").fadeIn(1000);
                }, 1000);
                break;
            case "Group members":
                $("#center-right .group").siblings().fadeOut(1000);
                setTimeout(function () {
                    $("#center-right .group").fadeIn(1000);
                }, 1000);
                break;
            case "Data table display":
                $("#center-right .table").siblings().fadeOut(1000);
                setTimeout(function () {
                    $("#center-right .table").fadeIn(1000);
                }, 1000);
                break;
            case "Curve drawing":
                $("#center-right .curve").siblings().fadeOut(1000);
                setTimeout(function () {
                    $("#center-right .curve").fadeIn(1000);
                }, 1000);
                break;
            default :
                alert("Sorry! This feature is still being maintained...");
        }
    })

    function popular_search(e){
        e.on("click", function () {
            /*alert($(this).text());*/
            $("#s").val($(this).text());
        })
    }
    popular_search($("#pro"));
    popular_search($("#gro"));
    popular_search($("#dat"));
    popular_search($("#cur"));



})




                function aaa(){
                    function $(id){return document.getElementById(id)}
                    var login=document.getElementById("login");
                    var strong=document.getElementById("strong");
                    $("mask").style.display="block";
                    $("show").style.display="block";
                    document.body.style.overflow="hidden"; //不显示滚动条
                    var event=event || window.event;
                    if(event && event.stopPropagation){
                        event.stopPropagation();
                    }else{
                        event.cancelBubble=true;
                    }
                }