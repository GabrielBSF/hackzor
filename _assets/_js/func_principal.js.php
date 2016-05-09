/**
 * Created by Fayzor1999 on 27/03/2016.
 * zzrnedkv@imgof.com/abcdE
 */

$(document).ready(function(){
	
    //default.
    $("#hd").show();
    $("#ranking, #register, #forget").hide();


    //functions button forget/login.
    $(".forget, .rlogin").click(function(){
        $("#login").toggle();
        $("#forget").toggle();
    });
    $(".clogin").click(function(){
    	$("#login").toggle();
    	$("#register").toggle();
    });


    $("a").click(function(){
        var href = this.href.split("#");

        if(href[1] == "index"){
            if(jQuery("#not").hide()){
                $("#not").toggle();
                $("#ranking").hide();
            }
        }else if(href[1] == "ranking"){
            if(jQuery("#ranking").hide()){
                $("#not").hide();
                $("#ranking").toggle();
            }
        }else if(href[1] == "register"){
            if(jQuery("#register").hide()){
                $("#login").hide();
                $("#forget").hide();
                $("#register").toggle();
            }
        }
    });

});