$(document).foundation();
$( document ).ready(function() {
    
    // TRY TO PREVENT INVALID CHARACTERS ENTERED INTO TXT FIELDS
    
    /*
    function preventChars(selectors, low, high) {
    	$(selectors).keypress(function(e) {
    		if (e.which < low || e.which > high)
    		{
    		    e.preventDefault();
    		}
    	})
    }
    preventChars(".qty, .unitCost", 48, 57);
    */
    
    $("input.qty, input.sum").keypress( function(e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890.".indexOf(chr) < 0)
            return false;
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
    
    // CALCULATE THE ITEM ROWS
    $(document).on('change', ".sum", function(){
      var $this = $(this);
      var unitCost = $this.parent().parent().find('.unitCost').val();
    	var qty = $this.parent().parent().find('.qty').val();
    	var sumtotal = parseFloat((unitCost * qty).toFixed(2));
    	$this.parent().parent().find('.totalSum').text( '$'+(sumtotal).formatMoney(2, '.', ',') ).attr('data-totalsum', sumtotal);
    	
    	calculateSumTotal();
    });
    
    
    $('#addItems').click(function() {
    	$('#invoiceCreate tbody').append(' <tr><td><input type="hidden" name="item_id[]"><input type="text" name="qty[]" class="qty sum"></td><td><textarea name="description[]" cols="30" rows="3"></textarea></td><td><input type="text" name="unit_cost[]" class="unitCost sum"></td><td class="totalSum">$0.00</td><td><a class="delete-row">Remove</a></td></tr>');
    });
    
    // AJAX FORMS
    
  	var baseurl = window.location.protocol + "//" + window.location.host + "/" + "getpaid/";
    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#createForm").submit(function(event){
        // abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);
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
            url: baseurl+"index.php/invoices/create",
            type: "POST",
            data: serializedData,
            dataType: 'json',
            cache:false,
            success: function(respond) {
                if (respond.result == 'false') {
                	$('#form-errors').html(respond.errors);
                } else {
                 $('#form-errors').html(respond.errors);
                 window.location.href = respond.redirect;
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
    });
});