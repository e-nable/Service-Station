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



// NOTE: this will eventually come from a service
var descriptions = [
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

var submitVal = 0;
var flaggedError = true;
var isNovice = true;
var optionValues;


// DOM Ready method
// Request configured options before we configure the UI
$(function(){
	var self = this;

	// TODO: what is this?	
	if (submitType) {
		$("#render_tab a:last").tab("show");
	}
	
	isNovice = ($.urlParam('advanced') == 'true') ? false : true;

	// Instance the ViewModel
	var vm = new viewModel(descriptions);
	window.tmpViewModelReferenceForDebug = vm;

	ko.applyBindings(vm);
	
	vm.isNovice(isNovice);
	sessionService(function(session) { vm.loadSession(session) });
	optionValuesService(function(options) { vm.loadOptions(options); });
	
 	firstRender();
});

// URL parser addition to jQuery
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null){
       return null;
    } else {
       return results[1] || 0;
    }
}

// TODO: make this a method of an object
var optionValuesService = function(callback) {
	$.ajax({url:"e-NABLE/options.json",
		success: function(jqXHR) {
			if (jqXHR){
				optionValues = jqXHR;
				callback(optionValues);
			}
		},error: function(jqXHR){

		}
	});	
};

// TODO: make this a method of an object
// We'll use this adapter to disintermediate the global session variables until we integrate with Ro's new session service
var sessionService = function(callback) {
	// Simulate async
	setTimeout(
		function() {
			callback({
				submitType: submitType,
				prostheticHandSession: prostheticHandSession,
				partSession: partSession,
				palmSelectSession: palmSelectSession,
				gauntletSelectSession: gauntletSelectSession,
				fingerSelectSession: fingerSelectSession,
				isUnderProcessLimit: isUnderProcessLimit,
				processCount: processCount,
				handSessionValues: handSessionValues,
			})
		}, 1);
}

var fieldsViewModelBuilder = function(descriptionReferenceData) {
	var self = this;	
	self.descriptions = descriptionReferenceData;
	
	self.extractSequenceNumFromSession = function(handSession) {
		return parseInt(handSession.id.replace(/[LR]/g, ''));	
	};
	
	self.extractDescriptionFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		var record = ko.utils.arrayFirst(descriptions, function(item) { return item.id == id; });
		return record ? record.label : "";
	};
	
	self.extractNameFromSession = function(handSession) {
		return handSession.id
				.replace(/L/g, 'Left')
				.replace(/R/g, 'Right');
	};
	
	self.extractLeftFromSession = function(handSession) {
		return handSession.id.toUpperCase().indexOf('L') > -1;
	};

	self.extractRightFromSession = function(handSession) {
		return !handSession.id.toUpperCase().indexOf('R') > -1;
	};

	// Legacy stuff - soon to be deprecated
	self.extractHiddenFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		return (id == 8 || id == 9) ? false : true;
	};	
	
	self.extractVisibleForNoviceFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		return (id == 8 || id == 9);
	};
	
	self.buildViewModel = function(handSession, isNoviceObservable) {
		return {
			id: handSession.id,
			sequenceNo: self.extractSequenceNumFromSession(handSession),
			name: self.extractNameFromSession(handSession),
			description:  self.extractDescriptionFromSession(handSession),
			left: self.extractLeftFromSession(handSession),
			right: self.extractRightFromSession(handSession),
			
			isVisible: ko.computed(function() {
				if (isNoviceObservable()) {
					return self.extractVisibleForNoviceFromSession(handSession);
				} else {
					return true;
				}
			}),

			dataEntry: ko.observable(handSession.value),

			// TODO: delete "legacy" properties
			hidden: self.extractHiddenFromSession(handSession), 
			value: handSession.value, 
		};
	};
};

// View Model content
var viewModel = function (descriptionData) {
	var self = this;

	// TODO - expose initialization of this as a method
	self.isNovice = ko.observable(isNovice);
	
	// TODO - convert these into observables and isolate the loading of their state
	self.submitType = submitType;
	self.isUnderProcessLimit = isUnderProcessLimit;
	self.processCount = processCount;
	
	self.descriptions = descriptionData;
	self.fields = ko.observableArray();
	
	self.prostheticHandItems = ko.observableArray();
	self.gauntletSelectItems = ko.observableArray();
	self.fingerSelectItems = ko.observableArray();
	self.partItems = ko.observableArray();
	self.palmItems = ko.observableArray();

	self.selectedProstheticHand = ko.observable();
	self.selectedGauntletSelect = ko.observable();
	self.selectedFingerSelect = ko.observable();
	self.selectedPart = ko.observable();
	self.selectedPalm = ko.observable();
	
	self.loadSession = function(session) {
		self.selectedProstheticHand(session.prostheticHandSession);
		self.selectedGauntletSelect(session.gauntletSelectSession);
		self.selectedFingerSelect(session.fingerSelectSession);
		self.selectedPart(session.partSession);
		self.selectedPalm(session.palmSelectSession);
		
		var builder = new fieldsViewModelBuilder(self.descriptions);			
		$.each(session.handSessionValues, function(index, item){
			self.fields.push(builder.buildViewModel(item, self.isNovice));
		});
	};

	self.loadOptions = function(optionValuesData) {
		self.prostheticHandItems(optionValuesData.prostheticHand);
		self.gauntletSelectItems(optionValuesData.gauntlet);
		self.fingerSelectItems(optionValuesData.finger);
		self.partItems(optionValuesData.part);
		self.palmItems(optionValuesData.palm);
	};
	
	self.leftHandSelected = ko.computed(function() {
		return self.selectedProstheticHand() == "0";
	});

	self.rightHandSelected = ko.computed(function() {
		return self.selectedProstheticHand() == "1";
	});

	self.selectedFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return (self.leftHandSelected() && item.left) ||
				(self.rightHandSelected() && item.right);
		});
	});

	self.leftFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return self.leftHandSelected();
		});
	});
	
	self.rightFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return self.rightHandSelected();
		});
	});
};


// Call this when we submit
function submitForm(v){
	submitVal =v;

	var hand_selected = $("prostheticHand").val();
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

// Toggle called when left / right is selected on both types of UI instances
function handSelect(isLoad){
	isLoad = isLoad || false;	
	var hand_selected = (!isLoad ? $("#prostheticHand").val() : prostheticHandSession);
	
	if (!isNovice){
		
	} else {
		$('#prosthetic input').each(function(x,y){
			var obj = $(y);
			obj.parent().removeClass('incomplete');
		});
		
		if (!hand_selected){
			console.log('selection returned empty');

		} else if (hand_selected == 0){
			$('#prosthetic-tab span.title').html(' Left Prosthetic');	
			$('#image img').get(0).src= './imgs/referece_lP.png';

		} else if (hand_selected == 1){
			$('#prosthetic-tab span.title').html(' Right Prosthetic');
			$('#image img').get(0).src= './imgs/referece_rP.png';
		}

	}
	
	$("#top_hover").hide();
}

// Helps configure UI while we get full knockout logic in place
function setType(){
	if (isNovice){
		//var mTabHTML = "<br/>" + $('#mid-pane').html();
		//$('#side-select-body').html($('#side-select-body').html() + mTabHTML);
		
		/*	Need to mirror these in Knockout
		 $('#prosthetic').addClass('no-height');
		 $('#side-select-body').addClass('hando-panel-height');
		 $('#option-select-body').addClass('hando-panel-height');
		 $('label').each(function(a,b){
			$(b).addClass('spaced-label');
		 });
		 $('#measure-tab').addClass('no-border'); */
		 
		 $('#product-title').html('Handomatic<a href=".\/?advanced=true" class="pro_novice btn">Go Pro &gt;&gt;</a>');
		//console.log();
		//$('#mid-pane').html($('#render_tab').html()+$('#mid-pane').html());
	} else {
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

// Render buttons when needed - leave out when process count
// has gone over limit
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
				class:'download btn btn-danger' +((partSession == 0)?' disabled':''),
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
			}).html('Sample Data')
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

function showJumbotron() { 
	if (!submitType){
		$("#preview_tab").hide();
		$('.jumbotron').animate({opacity: 1},500);
	} else {
		$('.jumbotron').remove();
	}
}

// configures UI on first render while we get knockout completed
function firstRender() {
	conditionalButtonRender();
	
	showJumbotron();

	setType();
	

	$("#top_hover").hide();
	$("#top_hover").click(function(){$("#top_hover").hide()});
	
	// Refactored Loop
	$.each(
		[ { side: 'left' }, { side: 'right' }, { side: 'prosthetic' }],

		function(index, item){

			$("#" + item.side +" input").each(
				function(inner_index, inner_item){
				
					var element = $(inner_item);
					var parent = element.parent();
					var mssg = $("#top_hover");
					var code = inner_item.id.replace(/v_/g,'');

					// console.log(code);

					element.mCount = code.substring(1);					
					var targetElement = $("#" + code);
					targetElement.hide();
					
					if (item.side != 'prosthetic')
						element.mouseenter( function(){
							targetElement.show();
						}).focus(function(){
							resetVisibility();
							targetElement.show();
							parent.addClass("focus");
							mssg.html(element.mCount + ". " + descriptions[element.mCount - 1].label);
							$("#top_hover").show();
							if (element.mCount > 5 && element.mCount != 10){
								mssg.addClass('bottom');
							} else {
								mssg.removeClass('bottom');
							}
						}).mouseleave( function(){
							if (!element.is(":focus")){
								targetElement.hide();
							}
						}).focusout( function(){
							targetElement.hide();
							parent.removeClass("focus");
						});
				}
			);
		}
	);

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
			$('#email').removeClass('hide');
		} else {
			$('#stl-btn').removeClass('disabled');
			$('#email').addClass('hide');
		}
	});
	
	$('#first-pane').animate({opacity: 1},750);
	$('#mid-pane').animate({opacity: 1},2000);
	$('#third-pane').animate({opacity: 1},2800);
	$('#close-jumbo').click(function(){closeJumbo()});
}

function closeJumbo(){
	$('.jumbotron').animate({
		opacity: 0,
		height: '0px',
		padding: '0px'
		},1500, function() {/*$('.jumbotron').remove();*/})
}
