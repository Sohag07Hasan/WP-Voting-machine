jQuery('document').ready(function(){
	var nome_id = null;
	var id = null;
	//show a form to fill by voters
	jQuery('#fnom_vote').click(function(){
				
		nome_id = 1;		
		myfunctino(nome_id);
		return false;
	});
	
	
	jQuery('#snom_vote').click(function(){
		
		nome_id = 2;		
		myfunctino(nome_id);
		return false;
	});
	jQuery('#tnom_vote').click(function(){
				
		nome_id = 3;		
		myfunctino(nome_id);
		return false;
	});
	
	function myfunctino(id){
		
		var email = prompt('enter your email to vote');
		if(email == ''){
			alert('empty email');
			return false;
		}
		
		if(email == null){
			
			return false;
		}
		
		jQuery.ajax(
		{
			
				//async: true,
				type:'post',
				url:VotingAjax.ajaxurl,
				timeout:10000,
				data:{
					'action':'myajax_data',
					
					'email':email,
					
					'voteNonce':VotingAjax.votingnonace,
					'nome_id':id,
				},
				
				success:function(result){
									
					var message = jQuery(result).find('message')[0].childNodes[0].data;
					var nominee = jQuery(result).find('nominee')[0].childNodes[0].data;
					var voteno = jQuery(result).find('voteno')[0].childNodes[0].data;
					var clsEditd = '#some_data_'+nominee;
					alert(message);				
													
					var newfield = 'Vote No '+voteno;
					jQuery(clsEditd).html(newfield);
					//jQuery('#footer').html(result);
					return false;
				},
				
				error: function(jqXHR, textStatus, errorThrown){
					jQuery('#footer').html(textStatus);
					alert(textStatus);
					return false;
					}
				
			}
			);							
		
		return false;
				
	}	
	
	
});
