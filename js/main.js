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
	
	{ id: 8,  label: "Width of full hand across knuckles. See picture at right." },
	{ id: 9,  label: "Length of palm, measured from center of wrist to center of knuckles. See picture at right." },

	{ id: 10, label: "Length of Elbow to wrist joint"}
    ];

var submitVal = 0;
var flaggedError = true;


// DOM Ready method
// Request configured options before we configure the UI
$(function(){
	var self = this;
	
	// TODO: what is this?	
	if (submitType) {
		$("#render_tab a:last").tab("show");
	}
	
	// Instance the ViewModel
	var vm = new viewModel(descriptions);
	window.tmpViewModelReferenceForDebug = vm;
	
	sessionService(function(session) { 
		vm.loadSession(session); 
		optionValuesService(function(options) { 
			vm.loadOptions(options); 
			ko.applyBindings(vm);
			vm.sammy.run();
		});
	});
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

function isInt(value) {
  return !isNaN(value) && 
         parseInt(Number(value)) == value && 
         !isNaN(parseInt(value, 10));
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
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

var sessionService = function(callback) {
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
		email: email,
	});
};



var fieldsViewModelBuilder = function(descriptionReferenceData) {
	var self = this;	
	self.descriptions = descriptionReferenceData;
	
	self.extractSequenceNumFromSession = function(handSession) {
		return parseInt(handSession.id.replace(/[LR]/g, ''));	
	};
	
	self.extractDescriptionFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		var record = ko.utils.arrayFirst(descriptions, function(item) { return item.id == id; });
		return record;
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
		return handSession.id.toUpperCase().indexOf('R') > -1;
	};
	
	self.extractHiddenFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		return !(id == 8);
	};
	
	self.extractVisibleFromSession = function(handSession) {
		var id = self.extractSequenceNumFromSession(handSession);
		return (id == 8);
	};
	
	self.buildViewModel = function(handSession) {
		return {
			id: handSession.id,
			sequenceNo: self.extractSequenceNumFromSession(handSession),
			name: self.extractNameFromSession(handSession),
			description:  self.extractDescriptionFromSession(handSession).label,
			left: self.extractLeftFromSession(handSession),
			right: self.extractRightFromSession(handSession),
			
			isVisible: ko.computed(function() {
				return self.extractVisibleFromSession(handSession);
			}),

			dataEntry: ko.observable(handSession.value),
			
			// TODO: delete "legacy" properties
			hidden: self.extractHiddenFromSession(handSession), 
			value: handSession.value, 

			showValidation: ko.observable(false),
		};
	};
};

// View Model content
var viewModel = function (descriptionData) {
	var self = this;	

	self.submitType = submitType;
	self.isUnderProcessLimit = isUnderProcessLimit;
	self.processCount = processCount;
	self.email = ko.observable();
	self.paddingValue = ko.observable(5);
	self.render = ko.observable();	
	
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
		self.email(session.email == "undefined" ? "" : session.email);
		
		var builder = new fieldsViewModelBuilder(self.descriptions);			
		$.each(session.handSessionValues, function(index, item){
			self.fields.push(builder.buildViewModel(item));
		});
	};

	self.loadOptions = function(optionValuesData) {
		optionValuesData.prostheticHand.unshift({ 
			id: null, name: "Select the Hand..." 
		});
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

	self.noHandSelected = ko.computed(function() { 
		return self.selectedProstheticHand() == null;
	});
	
	self.prostheticSelectedTitle = ko.computed(function() {
		return self.leftHandSelected() ? "Left Prosthetic" : "Right Prosthetic";
	});

	self.selectedFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return ((self.leftHandSelected() && item.right) ||
				(self.rightHandSelected() && item.left)) &&
				item.isVisible();
		});
	});

	self.leftFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return item.left;
		});
	});
	
	self.rightFields = ko.computed(function() {
		return ko.utils.arrayFilter(self.fields(), function(item) {
			return item.right;
		});
	});


	// OpenSCAD Ajax functions - running with JQuery for now
	self.waitingForResponse = ko.observable(false);

	self.preview = function() {
		self.waitingForResponse(true);
		$.get('preview.php?advanced=false&submit=preview&' + $('#generatorForm').serialize(), self.renderPreview);
	};
	
	self.renderPreview = function(response) {
		$("#ajaxCaddy").html(response);
		var image = $("#ajaxCaddy img").attr("src");
		$("#previewImage").attr("src", image);	// TODO: tie this to Knockout observable
		self.waitingForResponse(false);
	};
	
	self.sendEmail = function() {
		var url = 'service.php?type=make&' + $('#generatorForm').serialize();
		$.get(url, function(resp) { });
	}

	// Validation functions
	self.measurementPageValid = ko.observable(true);
	self.modelPageValid = ko.observable(true);
	self.paddingValueValid = ko.observable(true);
	self.emailValid = ko.observable(true);

	self.validateMeasurementsPage = function() {
		self.measurementPageValid(true);
		
		if (self.noHandSelected()) {
			self.measurementPageValid(false);
		}
		ko.utils.arrayForEach(this.selectedFields(), function(field) {
			field.showValidation(false);
			
			if (field.isVisible()) {
				if (!isNumber(field.dataEntry())) {
					self.measurementPageValid(false);
					field.showValidation(true);
				}
			}
		});
		return self.measurementPageValid();
	};
		
	self.validateModelPage = function() {
		self.paddingValueValid(isNumber(self.paddingValue()));
		self.emailValid(self.email() && true);
		
		self.modelPageValid(self.paddingValueValid() && self.emailValid());
		return self.modelPageValid();
	}
	

	// Navigation functions
	self.processSteps = {
		welcomePage: 1,
		measurementsPage: 2,
		modelPage: 3,
		thankyouPage: 4,
	};
	
	self.currentStep = ko.observable(self.processSteps.welcomePage);
	
	// This bit of code allows us to use bookmarking, back button, etc. and do pure SPA-style navigation with hash tags
	self.sammy = Sammy(function() {
		this.get("#welcome", function(context) {
			window.ga_sendPath();
			self.currentStep(self.processSteps.welcomePage);
		});
		this.get("#measure", function(context) {
			window.ga_sendPath();
			self.currentStep(self.processSteps.measurementsPage);			
		});
		this.get("#model", function(context) {
			if (self.validateMeasurementsPage()) {				
				window.ga_sendPath();
				
				self.currentStep(self.processSteps.modelPage);
				self.preview();
			} else {
				 context.redirect("#measure");
			}
		});
		this.get("#sendemail", function(context) {
			window.ga_sendPath();
			self.sendEmail();
			
			context.redirect("#thankyou");
		});
		this.get("#thankyou", function(context) {
			if (self.validateModelPage()) {
				// Add AJAX invocation
				window.ga_sendPath();
				self.currentStep(self.processSteps.thankyouPage);
			} else {
				 context.redirect("#model");
			}
		});
	});
};


