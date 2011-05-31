<?php
/***********************************************************************************
 ***********************************************************************************
				*class for adding custom settings
				* and control the voting machines
 ********************************************************************************/ 
	
	if(!class_exists(adding_custom_options_for_voting_machine)) :
	
		class adding_custom_options_for_voting_machine{
			// Init plugin options to white list our options
			function ozh_sampleoptions_init(){
				//register_setting( 'ozh_sampleoptions_options', 'ozh_sample', 'ozh_sampleoptions_validate' );
				register_setting( 'nom_options', 'nom_all',array($this,'nom_validate'));
				
				
			}
			// Add menu page
			function ozh_sampleoptions_add_page() {
				add_options_page('Voting Machine\'s Sample Options', 'Voting Machine settings', 'manage_options', 'ozh_sampleoptions', array($this,'ozh_sampleoptions_do_page'));
			}
			
			// Draw the menu page itself
			function ozh_sampleoptions_do_page(){
				?>
				<div class="wrap">
					<h2>Nominees' Sample Options</h2>
					<form method="post" action="options.php">
						<?php 
							settings_fields('nom_options'); 
							
							$nom_all = get_option('nom_all'); 
							
						 ?>
						<table class="form-table">
							<tr valign="top"><th scope="row">Nominee 1 </th>
							
								<td>Name (plain text)<input name="nom_all[nom_1][name]" type="text" value= "<?php echo $nom_all['nom_1']['name']; ?>" /></td>
								<td> Initial Vote (only integer)<input name="nom_all[nom_1][voteno]" type= "text" value= "<?php echo $nom_all['nom_1']['voteno']; ?>" /></td>
								<td>Image (valid link)<input name="nom_all[nom_1][image]" type="text" value= "<?php echo $nom_all['nom_1']['image']; ?>" /></td>
								
							</tr>
							
							<tr valign="top"><th scope="row">Nominee 2 </th>
							
								<td> Name (plain text)<input name="nom_all[nom_2][name]" type="text" value= "<?php echo $nom_all['nom_2']['name']; ?>" /></td>
								<td> Initial Vote (only integer)<input name="nom_all[nom_2][voteno]" type= "text" value= "<?php echo $nom_all['nom_2']['voteno']; ?>" /></td>
								<td>Image (valid link)<input name="nom_all[nom_2][image]" type="text" value= "<?php echo $nom_all['nom_2']['image']; ?>" /></td>
								
							</tr>
							
							<tr valign="top"><th scope="row">Nominee 3 </th>
							
								<td>Name (plain text)<input name="nom_all[nom_3][name]" type="text" value= "<?php echo $nom_all['nom_3']['name']; ?>" /></td>
								<td>Initial Vote (only integer)<input name="nom_all[nom_3][voteno]" type= "text" value="<?php echo $nom_all['nom_3']['voteno']; ?>" /></td>
								<td>Image (valid link)<input name="nom_all[nom_3][image]" type="text" value="<?php echo $nom_all['nom_3']['image']; ?>" /></td>
								
							</tr>
							
							<tr valign="top"><th scope="row">Descriptions </th>
							
								<td>Nominee1(plain text)<textarea name="nom_all[nom_1][about]" rows="10" cols="16" > <?php echo $nom_all['nom_1']['about']; ?> </textarea></td>
								<td>Nominee2(plain text)<textarea name="nom_all[nom_2][about]" rows="10" cols="16" > <?php echo $nom_all['nom_2']['about']; ?> </textarea></td>
								<td>Nominee3(plain text)<textarea name="nom_all[nom_3][about]" rows="10" cols="16" > <?php echo $nom_all['nom_3']['about']; ?> </textarea></td>
								
							</tr>
							
							<tr valign="top"><th scope="row"> uploaded file link (doc or pdf) (valid link)</th>
								<td><input type="text" name="nom_all[nom_com][details]" value="<?php echo $nom_all['nom_com']['details']; ?>" /></td>
							</tr>
							<tr valign="top"><th scope="row"> Starting Date (yyyy-mm-dd)</th>
								<td><input type="text" name="nom_all[nom_com][sday]" value="<?php echo $nom_all['nom_com']['sday']; ?>" /></td>
							</tr>
							<tr valign="top"><th scope="row"> Ending Date (yyyy-mm-dd)</th>
								<td><input type="text" name="nom_all[nom_com][eday]" value="<?php echo $nom_all['nom_com']['eday']; ?>" /></td>
							</tr>
						</table>
						<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
						</p>
					</form>
				</div>
			<?php	
			}
			
			
			function nom_validate($input){
				$nom_1 = $input['nom_1'];
				$nom_2= $input['nom_2'];
				$nom_3 = $input['nom_3'];
				$nom_com = $input['nom_com'];
				
				//name verification
				$input['nom_1']['name'] = (strip_tags($nom_1['name']))? strip_tags($nom_1['name']) : 'nominee 1';
				$input['nom_2']['name'] = (strip_tags($nom_2['name']))? strip_tags($nom_2['name']) : 'nominee 2';
				$input['nom_3']['name'] = (strip_tags($nom_3['name']))? strip_tags($nom_3['name']) : 'nominee 3';
				
				//image link verification
				$input['nom_1']['image'] = ($nom_1['image'])? $nom_1['image'] : plugins_url('/voting-machine/images/img1.png');
				$input['nom_2']['image'] = ($nom_2['image'])? $nom_2['image'] : plugins_url('/voting-machine/images/img1.png');
				$input['nom_3']['image'] = ($nom_3['image'])? $nom_3['image'] : plugins_url('/voting-machine/images/img1.png');
				
				//verification of vote no
				
				$input['nom_1']['voteno'] = ($nom_1['voteno'])? $nom_1['voteno'] : 0 ;
				$input['nom_2']['voteno'] = ($nom_2['voteno'])? $nom_2['voteno'] : 0 ;
				$input['nom_3']['voteno'] = ($nom_3['voteno'])? $nom_3['voteno'] : 0 ;
				
				//comments verifications
				$default = "no description is found";
				$input['nom_1']['about'] = ($nom_1['about'])? $nom_1['about'] : $default ;
				$input['nom_2']['about'] = ($nom_2['about'])? $nom_2['about'] : $default ;
				$input['nom_3']['about'] = ($nom_3['about'])? $nom_3['about'] : $default ;
				
				
				//file verification and time verification
				$input['nom_com']['details'] = ($nom_com['details'])? $nom_com['details'] : plugins_url('/voting-machine/files/as.pdf');
				$input['nom_com']['sday'] = ($nom_com['sday'])? $nom_com['sday'] : date('o-m-d',time());
				$ed = time()+3*24*60*60;
				$input['nom_com']['eday'] = ($nom_com['eday'])? $nom_com['eday'] : date('o-m-d',$ed);
				
				return $input;
			}
			
			
	}
	
	//instanciating the class to hook with different actions
	$add_option = new adding_custom_options_for_voting_machine();
	add_action('admin_init',array($add_option,'ozh_sampleoptions_init'));
	add_action('admin_menu',array($add_option,'ozh_sampleoptions_add_page'));
	
endif;
	
	
?>
