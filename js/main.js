/*  Web interface for back-end e-NABLE Assembler

    Copyright (C) 2014, e-NABLE / Rogelio Ortiz, Mike Creuzer

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as
    published by the Free Software Foundation, either version 3 of the
    License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/.
    */

var submitVal = 0;
var flaggedError = true;
var isNovice = true;
var descriptions =[
	{ id: 1,  label: "Length of Elbow Joint"},
	{ id: 2,  label: "Distance between lateral and medial side of the forearm proximal to the elbow joint"},
	{ id: 3,  label: "Distance between lateral and medial side of the middle forearm"},
	{ id: 4,  label: "Distance between lateral and medial side of the forearm proximal to the wrist"},
	{ id: 5,  label: "Wrist Joint distance from lateral to medial side"},
	{ id: 6,  label: "Distance from wrist to distal end of finger on thumb side (Lateral)"},
	{ id: 7,  label: "Distance from wrist to distal middle end of effected hand"},
	{ id: 8,  label: "Distance from Lateral and Medial sides of the distal part of the hand"},
	{ id: 9,  label: "Distance from wrist to proximal end of 1st phalange on pinky side (Medial)"},
	{ id: 10, label: "Length of Elbow to wrist joint"}
    ];
var optionValues;
var viewModel = function () {
   var self = this;

   self.prostheticHandItems = ko.observableArray(optionValues.prostheticHand);
   self.selectedProstheticHand = ko.observable(prostheticHandSession);

   self.partItems = ko.observableArray(optionValues.part);
   self.selectedPart = ko.observable(partSession);

   self.gauntletSelectItems = ko.observableArray(optionValues.gauntlet);
   self.selectedGauntletSelect = ko.observable(gauntletSelectSession);

   self.fingerSelectItems = ko.observableArray(optionValues.finger);
   self.selectedFingerSelect = ko.observable(fingerSelectSession);

   self.palmItems = ko.observableArray(optionValues.palm);
   self.selectedPalm = ko.observable(palmSelectSession);
};

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    } else {
       return results[1] || 0;
    }
}

function submitForm(v){
	submitVal =v;

	var hand_selected = $("#prostheticHand").val();
	var side = ((hand_selected == 0)?'l':'r');
	var oSide = ((hand_selected == 0)?'r':'l');
	var count = 0;
	var flagged = false;

	if (!isNovice){
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
						;//y.value = 0;
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
	var hand_selected = (!isLoad? $("#prostheticHand").val(): prostheticHandSession);//$("#prostheticHand").val();
	if (!isNovice){
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
			$('#v_l8').parent().addClass('hidden');
			$('#v_r9').parent().removeClass('hidden');
			$('#v_r8').parent().removeClass('hidden');
			$('#image img').get(0).src= './imgs/referece_lP.png';
		} else if (hand_selected == 1){
			$('#prosthetic-tab span.title').html(' Right Prosthetic');
			$('#v_l9').parent().removeClass('hidden');
			$('#v_l8').parent().removeClass('hidden');
			$('#v_r9').parent().addClass('hidden');
			$('#v_r8').parent().addClass('hidden');
			$('#image img').get(0).src= './imgs/referece_rP.png';
		}

	}
	$("#top_hover").hide();
}

function setType(){
	if (isNovice){
		$('#left-tab').parent().remove();
		$('#right-tab').parent().remove();
		$('#left').remove();
		$('#right').remove();
		$('#v_l9').parent().addClass('hidden');
		$('#v_l8').parent().addClass('hidden');
		var mTabHTML = "<br/>" + $('#mid-pane').html();
		$('#side-select-body').html($('#side-select-body').html() + mTabHTML);
		var selectHTML = $('#side-select');
		 $('#side-select').remove();
		 $('#mid-pane ul#measure-tab').remove();
 		 $('#mid-pane div.tab-content').remove();
		 $('#mid-pane').html(selectHTML);
		 $('#prosthetic').addClass('no-height');
		 $('#side-select-body').addClass('hando-panel-height');
		 $('#option-select-body').addClass('hando-panel-height');
		 $('label').each(function(a,b){
			$(b).addClass('spaced-label');
		 });
		 $('#measure-tab').addClass('no-border');
		 $('#product-title').html('Handomatic<a href=".\/?advanced=true" class="pro_novice btn">Go Pro &gt;&gt;</a>');
		//console.log();
		//$('#mid-pane').html($('#render_tab').html()+$('#mid-pane').html());
	} else {
		$('#prosthetic-tab').parent().remove();
		$('#prosthetic').remove();
		$('#left-tab').tab('show');
		$('#product-title').html('Handomatic Pro<a href=".\/?advanced=false" class="pro_novice btn">Go Novice &gt;&gt;</a>');
	}
	$('advanced').value=(!isNovice);
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
function conditionalButtonRender(){
	var sampleDataURL = "./?Left1=66.47&Left2=64.04&Left3=46.95&Left4=35.14&Left5=35.97"
		+ "&Left6=27.27&Left7=31.80&Left8=40.97&Left9=31.06&Left10=147.5&Right1=62.67"
		+ "&Right2=65.62&Right3=59.14&Right4=48.78&Right5=51.85&Right6=16.4&Right7=0"
		+ "&Right8=72.52&Right9=72.23&Right10=230.6&part=0&gauntletSelect=1"
		+ "&fingerSelect=2&palmSelect=2&prostheticHand=0&Padding=5&WristBolt=5.5"
		+ "&KnuckleBolt=3.3&JointBolt=3.3&ThumbBolt=3.3&submit=Preview";

	if (isUnderProcessLimit == 1){
		$('#action_buttons').append(
			$('<button></button>').attr({
				id:'stl-btn',
				'data-loading-text':'Loading STL...',
				class:'download btn btn-danger',
				type: 'submit',
				name: 'submit',
				value: 'stl'})
			.click(function(){submitForm('stl');})
			.html('<span class="glyphicon glyphicon-download"></span> Generate STL')
		);
		$('#action_buttons').append(
			$('<button></button>').attr({
				'data-loading-text':'Loading Preview...',
				id:	'preview-btn',
				class:	'preview btn btn-success',
				type:	'submit',
				name:	'submit',
				value:	'Preview'})
			.click(function(){submitForm('preview');})
			.html('<span class="glyphicon glyphicon-picture"></span> Preview')
		);
		$('#e_footer').append(
			$('<a></a>').attr({
				class:	"disclaimer btn btn-help",
				href:	sampleDataURL	
			}).click(function(){
				submitForm('preview');
				$('#loadingModal').modal({backdrop:'static', keyboard: false, show:true});
			}).html('Load Sample Data')
		);
	} else {
		$('#action_buttons').append(
			$('<h5></h5>').attr({
				style:'color:white; font-weight:bold;',
				'data-loading-text':'Loading Preview...',
				value: 'Preview'}).html('Processing limit reached. Please try again in a few minutes')
		);
	}
}

function firstRender(){
	conditionalButtonRender();
	isNovice =($.urlParam('advanced') == 'true')?false:true;
	setType();
	$('#prostheticHand').change(function(){handSelect();});
	var counter= 1;
	$("#top_hover").hide();
	$("#top_hover").click(function(){$("#top_hover").hide()});

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
						mssg.html(element.mCount+". "+ descriptions[element.mCount-1].label);
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

	var vm = new viewModel();
	ko.applyBindings(vm);

	handSelect(prostheticHandSession);
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
}

$(function(){
   var self = this;
   $.ajax({url:"e-NABLE/options.json",
	success: function(jqXHR) {
		if (jqXHR){
			optionValues = jqXHR;
			firstRender();
		}
	},error: function(jqXHR){

	}
   });
});


