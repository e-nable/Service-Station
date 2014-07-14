var submitVal = 0;
var flaggedError = true;
var isSimple = true;
var descriptions =[
	"Length of Elbow Joint",
	"Distance between lateral and medial side of the forearm proximal to the elbow joint",
	"Distance between lateral and medial side of the middle forearm",
	"Distance between lateral and medial side of the forearm proximal to the wrist",
	"Wrist Joint distance from lateral to medial side",
	"Distance from wrist to distal end of finger on thumb side (Lateral)",
	"Distance from wrist to distal middle end of effected hand",
	"Distance from Lateral and Medial sides of the distal part of the hand",
	"Distance from wrist to proximal end of 1st phalange on pinky side (Medial)",
	"Length of Elbow to wrist joint"
    ];

function goModal(v){
	submitVal =v;

	var hand_selected = $("#prostheticHand").val();
	var side = ((hand_selected == 0)?'l':'r');
	var oSide = ((hand_selected == 0)?'r':'l');
	var count = 0;
	var flagged = false;

	if (!isSimple){
		while(count++ < 10){
			var obj = $('#v_'+side+count);
			var val = obj.val();

			if (val == undefined || val == ""){
				obj.parent().addClass("incomplete");
				flagged = true;
			} else {
				obj.parent().removeClass("incomplete");
			}
			$('#v_'+oSide+count).parent().removeClass("incomplete");
		}

		if (side == 'l')
			$('#left-tab').tab('show');
		else
			$('#right-tab').tab('show');
	} else {
		$('#prosthetic input').each(function(x,y){
				if (y.type == 'number'){
					var obj = $(y);
			       		if (obj.parent().get(0).className.indexOf('hidden')> -1){
						y.value = 0;
					} else {
						if (y.value == undefined || y.value == ""){
							obj.parent().addClass("incomplete");
							flagged = true;
						} else {
							obj.parent().removeClass("incomplete");
						}
					}
				} 

				//console.log(y.type, $(y).parent().get(0).className.indexOf('hidden')> -1);
			}
		);
	}

	if (flagged){
		$('#valueWarningModal').modal({backdrop:'static', keyboard: false, show:true});
		return;
	}

	flaggedError = flagged;
}

function handSelect(isLoad){
	isLoad = isLoad || false;
	var hand_selected = $("#prostheticHand").val();
	if (!isSimple){
		if (!hand_selected){
			console.log('selection returned empty');
		} else if (hand_selected == 0){
			$('#left-tab span').removeClass('hidden');
			$('#right-tab span').addClass('hidden');
		} else if (hand_selected == 1){ ;
			$('#left-tab span').addClass('hidden');
			$('#right-tab span').removeClass('hidden');
		}
	} else {
		$('#prosthetic input').each(function(x,y){
			//if(!isLoad) y.value = "";
			var obj = $(y);
			obj.parent().removeClass('incomplete');
		});
		if (!hand_selected){
			console.log('selection returned empty');
		} else if (hand_selected == 0){
			$('#prosthetic-tab span.title').html(' Left Prosthetic');
			$('#v_l9').parent().addClass('hidden');
			$('#v_r5').parent().addClass('hidden');
			$('#v_r9').parent().removeClass('hidden');
			$('#v_l5').parent().removeClass('hidden');
			$('#image img').get(0).src= './imgs/referece_lP.png';
		} else if (hand_selected == 1){
			$('#prosthetic-tab span.title').html(' Right Prosthetic');
			$('#v_l9').parent().removeClass('hidden');
			$('#v_r5').parent().removeClass('hidden');
			$('#v_r9').parent().addClass('hidden');
			$('#v_l5').parent().addClass('hidden');
			$('#image img').get(0).src= './imgs/referece_rP.png';
		}

	}
	$("#top_hover").hide();
}

function setType(){
	if (isSimple){
		$('#left-tab').parent().remove();
		$('#right-tab').parent().remove();
		$('#left').remove();
		$('#right').remove();
		$('#v_l9').parent().addClass('hidden');
		$('#v_r5').parent().addClass('hidden');
	} else {
		$('#prosthetic-tab').parent().remove();
		$('#prosthetic').remove();
		$('#left-tab').tab('show');
	}
}

function resetVisibility(){
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					parent.removeClass("focus");
					$("#"+y.code+(a+1)).hide();
				}
			);
		}
	);					
}


$(function(){
	setType();
	handSelect(true);
	$('#prostheticHand').change(function(){handSelect();});
	var counter= 1;
	$("#top_hover").hide();
	$("#top_hover").click(function(){$("#top_hover").hide()});
	$('#generatorForm').submit(function (e) {
		if (flaggedError == true)
			return false;
		else {
			$("#loadingModal").modal({backdrop:'static', keyboard: false, show:true});
			if (submitVal == 'preview'){
				$('#stl-btn').addClass('disabled');
			} else if (submitVal == 'stl'){
				$('#preview-btn').addClass('disabled');
			}
			return true;
		}
	});
	$('#generateSelect').change(function(val){
		if (this && this.value && this.value == 0){
			$('#stl-btn').addClass('disabled');
		} else {
			$('#stl-btn').removeClass('disabled');
		}
	});
	$.each([{side:'left',code:'l'},{side:'right',code:'r'},{side:'prosthetic',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					var mssg = $("#top_hover");
					var code = b.id.replace(/v_/g,'');
					element.mCount=code.substring(1);
					$("#"+code).hide();

					if (y.side != 'prosthetic')
					element.mouseenter( function(){
						var c = $("#"+code);
						c.show();
					}).focus(function(){
						var c = $("#"+code);
						resetVisibility();
						c.show();
						parent.addClass("focus");
						mssg.html(element.mCount+". "+ descriptions[element.mCount-1]);
						$("#top_hover").show();
						if (element.mCount > 5 && element.mCount != 10){
							mssg.addClass('bottom');
						} else {
							mssg.removeClass('bottom');
						}
					}).mouseleave( function(){
						var c = $("#"+code);
						if (!element.is(":focus")){
							c.hide();
						}
					}).focusout( function(){
						var c = $("#"+code);
						c.hide();
						parent.removeClass("focus");
					});
				}
			);
		}
	);
});
