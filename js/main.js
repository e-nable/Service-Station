var submitVal = 0;
var flaggedError = true;

function goModal(v){
	submitVal =v;

	var hand_selected = $("#prostheticHand").val();
	var side = ((hand_selected == 0)?'l':'r');
	var oSide = ((hand_selected == 0)?'r':'l');
	var count = 0;
	var flagged = false;

	while(count++ < 10){
		var obj = $('#v_'+side+count);
		var val = obj.val();

		if (val == undefined || val == ""){
			obj.parent().addClass("broke");
			flagged = true;
		} else {
			obj.parent().removeClass("broke");
		}
		$('#v_'+oSide+count).parent().removeClass("broke");
	}

	if (side == 'l')
		$('#left-tab').tab('show');
	else
		$('#right-tab').tab('show');
	
	if (flagged){
		$('#valueWarningModal').modal({backdrop:'static', keyboard: false, show:true});
		return;
	}

	flaggedError = flagged;
}


function handSelect(){
	var hand_selected = $("#prostheticHand").val();
	if (!hand_selected){
		console.log('selection returned empty');
	} else if (hand_selected == 0){
		$('#left-tab span').removeClass('hidden');
		$('#right-tab span').addClass('hidden');
	} else if (hand_selected == 1){ ;
		$('#left-tab span').addClass('hidden');
		$('#right-tab span').removeClass('hidden');
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

$(function(){
	handSelect();
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
		//e.preventDefault();
	});
	$('#generateSelect').change(function(val){
		if (this && this.value && this.value == 0){
			$('#stl-btn').addClass('disabled');
		} else {
			$('#stl-btn').removeClass('disabled');
		}
	});
	$.each([{side:'left',code:'l'},{side:'right',code:'r'}],
		function(x,y){
			counter= 1;
			$("#"+y.side+" input").each(
				function(a,b){
					var element = $(b);
					var parent = element.parent();
					var mssg = $("#top_hover");
					element.mCount=counter++;
					$("#"+y.code+element.mCount).hide();
					element.mouseenter( function(){
						var c = $("#"+y.code+element.mCount);
						c.show();
					}).focus(function(){
						var c = $("#"+y.code+element.mCount);
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
						var c = $("#"+y.code+element.mCount);
						if (!element.is(":focus")){
							c.hide();
						}
					}).focusout( function(){
						var c = $("#"+y.code+element.mCount);
						c.hide();
						parent.removeClass("focus");
					});
				}
			);
		}
	);
});
