/*
 * jQuery jLogin version 1.0
 *
 * jLogin creates ajax login form instantly in a single line of code and few settings. 
 * It was built using the jQuery library.
 *
 * http://devstring.com/jlogin
 * Copyright (c) 2011 Toper
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($){
	$.fn.jlogin = function(options){
	var self = this;
	  
   	var defaults = {
		title          : "Login",
		description    : "Your company has more to offer when you sign in to your account.",
		usernameLabel  : "Email",
		passwordLabel  : "Password",
		rememberLabel  : "Remember Me",
		password       : "password",
		username       : "email",
		remember       : "remember",
		checked        : false,  
		post           : "login.php",
		onSuccess      : "success.htm",
		invalidMessage : "Invalid email or password, please try again.",
		formId         : "formLogin",
		target         : ".jtarget",  // target element(s) to be updated with server response 
   	};
   	var options = $.extend(defaults, options);
   	var creates = {
		html:function() {
			var content = 	this.title() + this.description() + this.labelUsername() + this.textboxUsername();
			content = content + this.labelPassword() + this.textboxPassword();
			content = content + this.labelRememberMe() + this.submitButton() + this.message()+ this.target();
			contentHtml = this.wrapper(content);
			return this.form(contentHtml);		 
		},
		wrapper:function(content) {
			var div = "<div class='jwrapper'>"+content+"</div>";
			return div;
		},
		form:function(content) {
			var form = "<form action='"+options.post+"' method='post' name='jform' class='jform' id='"+options.formId+"'>"+content+"</form>";
			return form;
		},
		title:function() {
			var h2 = "<h2>"+options.title+"</h2>";
			return h2;
		},
		description:function() {
			var p = "<p>"+options.description+"</p>";
			return p;
		},
		labelUsername:function() {
			var label =  "<label>"+options.usernameLabel+"</label>";
			return label;
		},
		textboxUsername:function() {
			var input = "<input name='"+options.username+"' class='jusername jtext' />";
			return input; 
		},
		labelPassword:function() {
			var label = "<label>"+options.passwordLabel+"</label>";
			return label;
		},
		textboxPassword:function() {
			var input = "<input name='"+options.password+"' class='jpassword jtext' type='password' />";
			return input;
		},
		checkboxRememberMe:function(content) {
			var isChecked = "";
			if(options.checked) {
				isChecked = "checked='checked'";
			}
			return "<input type='checkbox' name='"+options.remember+"' " +isChecked+ " value='1'>";
		},
		labelRememberMe:function() {
			return "<label class='jrem'>"+ creates.checkboxRememberMe() + options.rememberLabel+"</label>";
		},
		message:function() {
			return "<div class='jmessage'>"+ options.invalidMessage + "</div>";
		},
		loader:function() {
			var jloader = "<div class='jloader'><div class='jloader-progress'></div></div>";
			return jloader;
		},
		submitButton:function() {
			return "<div class='jdivsubmit'><button class='jsubmit'></button></div>";
		},
		target:function() {
			var target = options.target;
			target = target.replace(".","");
			return creates.loader() + "<span class='"+target+"'></span>";
		},		 
	}
	var animate = {
		invalid:function(i, counter) {
			counter++;
			var left = 0;
			if(i) {
				left = '+=50';
				i = 0;
			} else {
				left = '-=50';
				i = 1;
			}
			$('.jwrapper').animate({
					left:left + "px" ,
			}, 80 - (counter+5), function() {
					if(counter<=5) {
						animate.invalid(i, counter);
					}	
			});	
		},
		invalidLeft:0,
		progressbarLeft:0,
		isStop:false,
		progressCounter:0,
		progressbar:function(counter) {
			var left = '+=50';
			var width = $('.jloader').width();
			var widthProgress = $('.jloader-progress').width();
			var pos = $('.jloader-progress').position().left;
			var currentPos = parseInt(pos) + parseInt(widthProgress);
			counter++;
			
			if(currentPos >=width) {
				$('.jloader-progress').css("left", animate.progressbarLeft);	
			}
			$('.jloader-progress').animate({
				left:left ,
				}, 100, function() {
					
					if (!animate.isStop || counter <= 13) {
						animate.progressbar(counter);
					}else {
						$('.jloader-progress').css("left", animate.progressbarLeft);	
					}	
				});
				animate.progressCounter = counter;		
			}
	 }
	  
	  var forms = {
	   		init:function() {
				this.onSubmit();	
			},
			onSubmit:function() {
				$(document).ready(function() { 
				    var config = { 
				        target:        options.target,   
				        beforeSubmit:  showRequest, 
				        success:       showResponse 
				    }; 
    				$("#" + options.formId).ajaxForm(config); 
				}); 
 				function showRequest(formData, jqForm, config) { 
					var validated = forms.validated();
					if(validated) {
						if($(".jloader").is(":visible")) {
							return false;
						}else {
							$(".jloader").show();
							animate.progressbarLeft = $('.jloader-progress').position().left;
						    animate.progressbar(0);
							
						}	
					}else {
						animate.invalid(0, 0);
						return false;
					}
				} 
 				function showResponse(responseText, statusText, xhr, $form)  { 
					  animate.isStop = true;	
					  timeOut();
					  function timeOut() {
						 setTimeout(function() {
						    if (animate.progressCounter <13) {
						      timeOut();
						    }else {
								$(".jloader").fadeOut(function(){
									if (responseText == "invalid") {
										animate.invalid(0, 0);
										$(".jmessage").fadeIn().delay(2500).fadeOut();
									}
									if (responseText == "valid") {
										$('.jlogin').fadeOut("slow", function(){
											window.location.href = options.onSuccess;
										});
									}		
								});
							}
						}, 1000);
					 }
				} 
			},
			validated:function() {
				var isValid = 0;
				$(".jform").find("input").each(function(){
					if(parseInt($(this).val().length) == 0) {
						isValid++;
					}
				});	
				try {
					if(isValid) {
						return false;
					} else {
						return true;
					}
				} catch(err) {
					
				} 	
			}
	   }
	   
	return this.each(function(){
		var contentHtml = creates.html();
		$(self).addClass("jlogin");
		$(self).append(contentHtml );
			forms.init();
		});
		
	}
		                
})(jQuery);          