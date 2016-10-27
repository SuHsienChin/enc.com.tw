$(window).scroll( function(){ //當螢幕滾動的時候
if ( $(this).scrollTop() > 100){  //如果螢幕滾動的高度大於.sTop class的物件的高度
 $('.menu_ber').addClass('fxd');// header class 加上 class fxd
} else {
 $('.menu_ber').removeClass('fxd');
}

}).scroll();

$(window).scroll( function(){ //當螢幕滾動的時候
if ( $(this).scrollTop() > 100){  //如果螢幕滾動的高度大於.sTop class的物件的高度
 $('.lift_menu').addClass('fxd2');// header class 加上 class fxd
} else {
 $('.lift_menu').removeClass('fxd2');
}

}).scroll();

/*返回按鈕*/
$(function(){
    $("#gotop").click(function(){
        jQuery("html,body").animate({
            scrollTop:0
        },1000);
    });
    $(window).scroll(function() {
        if ( $(this).scrollTop() > 300){
            $('#gotop').fadeIn("fast");
        } else {
            $('#gotop').stop().fadeOut("fast");
        }
    });
});

//上方選單
	$(function(){
	$("#TOP_MENU").on("touchstart click",OPEN);
	$("#SUBMENU_in").on("touchstart click",CLOSE);

	function OPEN(){
		
		$("#SUBMENU").slideToggle(300);
		
		$("article").on('touchstart click',CLOSE);
		
		event.preventDefault();
				
	}
		
	function CLOSE(){
		
		$("#SUBMENU").hide(100);
			
		$("article").off('touchstart click');
		
		event.preventDefault();
	};
	});
	

//QA
$(function(){
		
		$('#qaContent ul').addClass('accordionPart').find('li div:nth-child(1)').addClass('qa_title').hover(function(){
			$(this).addClass('qa_title_on');
		}, function(){
			$(this).removeClass('qa_title_on');
		}).click(function(){
			// 當點到標題時，若答案是隱藏時則顯示它，同時隱藏其它已經展開的項目
			// 反之則隱藏
			var $qa_content = $(this).next('div.qa_content');
			if(!$qa_content.is(':visible')){
				$('#qaContent ul li div.qa_content:visible').slideUp();
			}
			$qa_content.slideToggle();
		}).siblings().addClass('qa_content').hide();
		$('#qaContent ul.accordionPart li div.qa_content:first').show();
	});