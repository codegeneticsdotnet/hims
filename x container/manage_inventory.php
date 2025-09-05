<ol class="breadcrumb">
	<li><a onclick="return loadPage('control panel')"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Inventory</li>
</ol>
<a class="navbar-brand" href="#">Item Tagging</a><br /><hr />
<div class="form-group col-md-6">
	<label>Itemname / Barcode</label>
	<input type="text" name="tboxbarcodesearch" id="tboxbarcodesearch" class="form-control ignorekey">
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  

<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<style>
  .card-body label {
	font-size:0.8em;  
  }
  #maincontainer{
	padding:5px 15px;min-height:800px;
  }
  .form-group{
	  margin-top:0px;
	  margin-bottom:0px;
  }
  input.boxunder{
	  border:0px;
	  border-bottom:1px #333 solid;
	  background:transparent;
	  text-align:right;
	  font-weight:bold;
	  font-size:1.1em;
  }
  input#tboxfinaltotalamount{
	  text-align:center;
	  font-weight:bold;
  }
</style>
<script>
	$('input:text:not(input.ignorekey)').bind("keydown", function(e) {
	   var n = $("input:text").length;
	   if (e.which == 13) { //Enter key
		 e.preventDefault(); //to skip default behavior of the enter key
		 var nextIndex = $('input:text').index(this) + 1;
		 if(nextIndex < n){
		   $('input:text')[nextIndex].focus();
		   $('input:text')[nextIndex].select();
		 }
	   }
	   if (e.which == 27){
		 e.preventDefault(); //to skip default behavior of the enter key
		 var nextIndex = $('input:text').index(this);
		 if(nextIndex < n){
			$('input:text')[nextIndex-1].focus();
			$('input:text')[nextIndex-1].select();
		 }
	   }
	});
	$(function(){
        $(document).on('click','input[type=text]',function(){ this.select(); });
	});
    function displayCart(){
		$.ajax({
			url: "x <?php echo $url;?>",
			type: 'post',
			data: {
				action: "DISPLAYCART"
			},
			success: function( data ) {
				$("#dataTables").html(data);
				var tot = $("#sumtotal").val();
				$("#tboxfinaltotalamount").val(tot);
				$("#cartcontainer").hide();
			} 
		});
	}
	function FormatCurrency(val){
		if(!isNumber(val)){
			return "";
		}else{
			return parseFloat(val).toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");
		}
	}
	var numEx = "(?<!\S)(?=.)(0|([1-9](\d*|\d{0,2}(,\d{3})*)))?(\.\d*[1-9])?(?!\S)";
	function isNumber(val){
		var rex = new RegExp(numEx);
		if(rex.test(val)){
			return true;
		}else{
			return false;
		}
	}
	function formatDigit(currency){
		return Number(currency.replace(/[^0-9.-]+/g,""));
	}
	function formatCurrency(number, decPlaces, decSep, thouSep) {
		decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
		decSep = typeof decSep === "undefined" ? "." : decSep;
		thouSep = typeof thouSep === "undefined" ? "," : thouSep;
		var sign = number < 0 ? "-" : "";
		var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
		var j = (j = i.length) > 3 ? j % 3 : 0;

		return sign +
			(j ? i.substr(0, j) + thouSep : "") +
			i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
			(decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
	}
	$('#cartcontainer').hide();
	$('#cartdetails').hide();
	$('#tboxbarcodesearch').focus();	
	function computetotal(){
		var s = $("#tboxamount").val().replaceAll(",","");
		var q = $("#tboxqty").val().replaceAll(",","");
		if(isNumber(s) && isNumber(q)){
			var r = (s * 1) * (q * 1);
			$("#tboxtotalamount").val(FormatCurrency(r));
			$("#tboxlocation").focus();
		}
	}
	$("#tboxamount").blur(function(){
		var s = $("#tboxamount").val();
		if(isNumber(s)){
			$("#tboxamount").val(FormatCurrency(s));
			computetotal();
		}
	});
	$("#tboxqty").blur(function(){
		var s = $("#tboxqty").val();
		if(isNumber(s)){
			computetotal();
		}
	});
	$("#tboxtotalamount").keypress(function(e){
		if(e.which == 13){
			$("#buttadditem").focus();
		}
	});
	$("#buttbacktocart").click(function() {
		$("#formitems").show();
		$("#formdelivery").hide();
	});
	$("#buttproceedtopayment").click(function() {
		$("#formdelivery").show();
		$("#formitems").hide();
	});
	$("#buttadditem").click(function() {
		var itemtagid 	= $('#hboxitemtagid').val();
		var qty      	= $("#tboxqty").val();
		var unitcost   	= $("#tboxamount").val();
		var locationid  = $("#tboxlocation").val();
		amountcost = Number(unitcost.replace(/[^0-9.-]+/g,""))
		//TODO: ajax validation		
		$.ajax({
			url: "x <?php echo $url;?>",
			type: 'post',
			data: {
				action: "ADD",
				tboxitemtagid	: itemtagid, 
				tboxqty 	 	: qty, 
				tboxunitcost 	: amountcost, 
				tboxlocationid 	: 1
			},
			success: function( data ) {
				displayCart();
			} 
		});
	});
	
	$("#buttprocesstransaction").click(function() {
		var total = $('#tboxtotal').html();
		var c = confirm("Are you sure that you want to PROCESS this Transaction?");
		if(c){
			var form = document.frmAddDR;
			if(validateAddDR(form, total)){
				document.frmAddDR.submit();
			}
		}
	});	
function retrieveCart(cartitemtagid){
	$('#cartcontainer').hide();
	$('#cartdetails').hide();
	$.ajax({
		url: "x <?php echo $url;?>",
		type: 'post',
		data: {
			action: "CARTITEM",
			cartitemtagid	: cartitemtagid
		},
		success: function( data ) {
			$("#cartcontainer").show();
			$("#cartTables").html(data);
		}
	});
}	
function retrieveItems(){
	var bcode = $("#tboxbarcode").val();
	if(bcode == "" && searchtype == "bcode"){
		bcode = $("#tboxbarcodesearch").val();
	}
	$.ajax({
		url: "x <?php echo $url;?>",
		type: 'post',
		data: { barcoder: bcode},
		success: function( data ) {
			var s = data.split("$$");
			if(s.length > 0){
				retrieveCart(s[5]);
				$('#hboxitemcode').val(s[0]);
				$('#tboxitemname').val(s[1]);
				$('#tboxbarcode').val(s[2]);
				$('#hboxbarcode').val(s[2]);
				$('#tboxcategory').val(s[3]);
				$('#tboxunit').val(s[4]);
				$('#hboxitemtagid').val(s[5]);
				$('#tboxbarcodesearch').val('');
				$('#tboxbarcodesearch').focus();
			}
		}
	});
}
$("#tboxbarcode").on('keyup', function(e) {
	if(e.which == 13) {
		e.preventDefault;
		retrieveItems();
	}	
});
$("#tboxitemname").on('keyup', function(e) {
	if(e.which == 13) {
		e.preventDefault;
		retrieveItems();
	}	
});
$('[id^="a"]').click(function() {
	e.preventDefault;
	alert($(this).text());
});
$("#tboxbarcodesearch").on('keyup', function(e) {
	if(e.which == 13 && $("#tboxbarcodesearch").val() != "") {
		if(searchtype=="bcode"){
			$("#tboxbarcode").val('');
		}
		e.preventDefault;
		retrieveItems();
	}	
});
var searchtype = "item";
$(document).on('input', '#tboxbarcodesearch', function () {
	var searchtext = $(this).val();
	searchtype = "item";
	var strFirstThree = searchtext.substring(0,2);
	if(isNumeric(strFirstThree)){
		searchtype = "bcode";
	}
	console.log(searchtype + " " + searchtext);
	 $("#tboxbarcodesearch").autocomplete({
		minLength:1,
		source: function( request, response ) {
	   // Fetch data
	   $.ajax({
		url: "x inventory search.php",
		type: 'post',
		dataType: "json",
		data: {
			 searchtext: searchtext,
			 searchtype: searchtype,
			 searchitem: "search"
		},
		success: function( data ) {
		 response( data );
		}
	   });
	  },
	  select: function (event, ui) {
			// Set selection
			var data = ui.item.value; 
			var s = data.split("$$");
			if(s.length > 0){
				var data = ui.item.value; 
				var s = data.split("$$");
				console.log(data);
				$('#hboxitemcode').val(s[0]);
				$('#tboxitemname').val(s[1]);
				$('#tboxbarcode').val(s[2]);
				$('#hboxbarcode').val(s[2]);
				$('#tboxcategory').val(s[3]);
				$('#tboxunit').val(s[4]);
				$('#hboxitemtagid').val(s[5]);
				$('#tboxserialno').focus();		
				retrieveItems();
			}
			return false;
	  },
	  focus: function(event, ui){
		 $( "#tboxbarcodesearch" ).val( ui.item.label );
		 //$( "#selectuser_id" ).val( ui.item.value );
		 return false;
	   },
	 });
	 /*
	 function viewDetails(itemtagid, refid, serialno){
	$.ajax({
		url: "x <?php echo $url;?>",
		type: 'post',
		data: {
			action: "VIEWDETAILS",
			itemtagid: itemtagid,
			serialno: serialno,
			refid: refid
		},
		success: function( data ) {
			$("#cartDetails").html(data);
			$("#cartdetails").show();
			//$("#cartcontainer").hide();
		} 
	});
}
function isNumeric(val) {
    var _val = +val;
    return (val !== val + 1) //infinity check
        && (_val === +val) //Cute coercion check
        && (typeof val !== 'object') //Array/object check
		&& (val.replace(/\s/g,'') !== '') //Empty 
		&& (val.slice(-1) !== '.') //Decimal
}
*/
});	
</script>