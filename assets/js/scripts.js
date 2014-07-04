$(document).foundation();
$( document ).ready(function() {
    
    // PREVENT INVALID CHARACTERS ENTERED INTO TXT FIELDS
    $( "#invoiceCreate tbody, #paymentModal" ).on( "keypress", "input.qty, input.sum, input.amt", function(e) {
      var chr = String.fromCharCode(e.which);
      if ("1234567890.".indexOf(chr) < 0) {
      	return false;
      }
    });
    
    function randomizer() {
    
    	var txtString = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    	var strLength = 8;
    	var randomText = "-";
    	for (var i = 0; i < strLength; i++) {
    	
    		rand = Math.round( Math.random() * ( txtString.length - 0 ) );
    		randomText += txtString.substr(rand, 1);
    	}
    	return randomText;
    }
    
    Number.prototype.formatMoney = function(c, d, t){
    var n = this, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	   };
    
    function calculateSumTotal() {
        var sum = 0;
        //iterate through each textboxes and add the values
        
        $(".totalSum").each(function() {	
            //add only if the value is number
            if(!isNaN($(this).attr('data-totalsum')) && $(this).attr('data-totalsum').length!=0) {
                sum += parseFloat($(this).attr('data-totalsum'));
            }
        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#invoiceTotal").html('$'+(sum).formatMoney(2, '.', ','));
    }
        
    $(document).on("click", ".delete-row",function() {
      $(this).parent().parent().remove();
    });
    
    // CALCULATE THE ITEM ROWS ON EDIT INVOICE PAGE
    $(document).on('keyup', ".sum", function(){
      var $this = $(this);
      var unitCost = $this.parent().parent().find('.unitCost').val();
    	var qty = $this.parent().parent().find('input.qty').val();
    	var sumtotal = parseFloat((unitCost * qty).toFixed(2));
    	$this.parent().parent().find('.totalSum').text( '$'+(sumtotal).formatMoney(2, '.', ',') ).attr('data-totalsum', sumtotal);
    	
    	calculateSumTotal();
    });
    
    
    
    $('#addItems').click(function() {
    	$('.edit-list-container').append(' <ul class="invoice-list clearfix"><li class="qty"><input type="hidden" name="item_id[]"><input type="text" name="qty[]" class="qty sum"></li><li class="description"><input type="text" name="description[]" /></li><li class="price"><input type="text" name="unit_cost[]" class="unitCost sum"></li><li class="totalSum">$0.00</li><li class="delete"><a class="delete-row">Remove</a></li></ul>');
    });
    
    
    var baseurl = window.location.protocol + "//" + window.location.host + "/" + "getpaid/";
    // variable to hold request
    var request;
    
    function mycallback($records) {
    	var id = window.location.pathname.split('/').pop();
    	
    	$( "#form-wrap" ).load( baseurl+"index.php/invoices/view_payments/"+id, function() {
    	  var sum = 0;
    	  
    	  
    	 	$('#invoicePayments input.amt').each(function() {
    	  	var $this = $(this);
    	  	// UPDATE THE PAYMENT TOTALS
    	  	//alert($this.val());
    	  	sum += parseFloat($this.val());
    	  	
    	  });
    	  $("#amtPaid").html((sum).formatMoney(2, '.', ','));
    	  var diff = $('#pamount').val();
    	  $("#amtLeft").text(diff);
    	});
    }
    
    // AJAX FORMS
    function ajaxRequest($this, url, callback) {
    	// abort any pending request
      if (request) request.abort();
      // setup some local variables
      var $form = $this;
      // let's select and cache all the fields
      var $inputs = $form.find("input, select, button, textarea");
      // serialize the data in the form
      var serializedData = $form.serialize();
      
      // let's disable the inputs for the duration of the ajax request
      // Note: we disable elements AFTER the form data has been serialized.
      // Disabled form elements will not be serialized.
      $inputs.prop("disabled", true);
      
      // fire off the request
      request = $.ajax({
          url: baseurl+url,
          type: "POST",
          data: serializedData,
          dataType: 'json',
          cache:false,
          success: function(respond) {
          
            if (respond.result == 'false') {
            	
            	var keys = Object.keys(respond);
            	
            	$('#form-errors').html(respond.errors).addClass("alert").show();
            	
            } else {
            
             $('#form-errors').html(respond.errors).addClass("success").show();
             
             if(typeof respond.redirect != "undefined") window.location.href = respond.redirect;
             
             if(typeof respond.records != "undefined") callback(respond.records);
             
            }
          }
      });
      // callback handler that will be called regardless
      // if the request failed or succeeded
      request.always(function () {
          // reenable the inputs
          $inputs.prop("disabled", false);
      });
      // prevent default posting of form
      event.preventDefault();
    }
  	
    
    $("#createForm").on("submit", function(event) {
    	$this = $(this);
    	ajaxRequest($this, "index.php/invoices/create", myothercallback);
    });
    
    $( "#form-wrap" ).on( "submit", "#addPayment", function() {
      var id = window.location.pathname.split('/').pop();
      $this = $(this);
      ajaxRequest($this, 'index.php/invoices/add_payment/'+id, mycallback);
    });
    
    $("#addPaymentBtn").on("click", function() {
    	var id = window.location.pathname.split('/').pop();
    	$.get( baseurl+"index.php/invoices/view_payments/"+id, function( data ) {
    	  $("#form-wrap").html( data );
    	  $("#form-errors").hide();
    	});
    });
    
       
});