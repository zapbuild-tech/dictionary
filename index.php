<?php include 'configure.php'; ?>
<script type="text/javascript" src="js/jquery.1.7.1.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
 jQuery.validator.addMethod("nospace", function(value, element) {
		return value.indexOf(" ") < 0;		
  });
$(document).ready(function() {
	$('#wordFinderForm').validate({
		// validate signup form on submit
		rules: {	
			'lookupfor' : {	required	: 	true,  minlength : 3 , maxlength : '<?php echo MAXIMUM_INPUT_CHARACTER_LENGTH;?>' }
		},
		messages: {		
			'lookupfor' : {	required : "Please enter some word" , minlength : "Please enter minimum 3 alphabets" , maxlength : "Only <?php echo MAXIMUM_INPUT_CHARACTER_LENGTH;?> maximum characters allowed" ,nospace : "Please enter the word without spaces" }		
			},
	});

	$('#wordFinderForm').ajaxForm({  
		beforeSend:function(){ $('#ResponseWords').html('Please wait..'); },
		dataType: 'json',
		async:false,
		success : function(response) { 
			//-- remove the loader message
			$('#ResponseWords').html('');
			var arr			=	response;
			var countElement	=	arr.length;
			//-- if the result has no element put the no result message
			if(countElement == 0 ){
				$('#ResponseWords').append('<div>No results found</div>');	
			}
			//-- to show total results in numbers found
			var rCount	=	0;
			$.each(arr, function(key,val) {
				$('#ResponseWords').append('<div>'+val+'</div>');	
				rCount++;
			});
			//-- getting the size if no result is pasted as result was less than configuration settings length
			if(countElement > 0 ){
				$('#ResponseWords').prepend('<div><b>Total '+rCount+' results found!</b></div>');	
			}
		}
	});
});
</script>

<h1>Word Finder</h1>
<form id="wordFinderForm" action="wordfinder.php" method="post">
	<label for="wfind">Please put you word and press enter</label>
		<div><input type="text" name="lookupfor" id="lookupfor"></div>
		<div><input type="submit" value="search"></div>
</form>
<h1>Results</h1>
<div id="ResponseWords">Please submit your query</div>