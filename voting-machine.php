<?php
/* 
Plugin Name: Aaaaaaaa voting machine original
Plugin URI: http://sohag07hasan.0fees.net/?p=4
Version: 1.1
Author: sohag hasan
Description: In WordPress, simple support / oppose vote plugin
Author URI: http://http://sohag07hasan.0fees.net
*/

/***********************************************************************************************************************************************
 * *********************************************************************************************************************************************
					databse manipulation class
************************************************************************************************************************************************
**/

if(!class_exists('database_table_creation')):

	class database_table_manipulation{
		//function for creating tables 
		function table_creation(){
						
			global $wpdb;
						
			$sql_voter = "CREATE TABLE IF NOT EXISTS wp_voter(
				voter_id int(254) unsigned NOT NULL AUTO_INCREMENT,
				nome_id int(10) unsigned NOT NULL,
				user_id int(10) unsigned NOT NULL,
				name varchar(100) NOT NULL,
				email varchar(100) NOT NULL,
				comment varchar(254) NOT NULL,
				PRIMARY KEY(voter_id)
			)";
			
			$sql_nominee = "CREATE TABLE IF NOT EXISTS wp_nominee(
				ballot_id int(100) unsigned NOT NULL,
				nome_id int(1000) unsigned NOT NULL AUTO_INCREMENT,
				user_id int(1000) unsigned DEFAULT 0,
				name varchar(100) NOT NULL,
				email varchar(100) NOT NULL,
				comment TEXT NOT NULL,
				vote_no int(1000) unsigned DEFAULT 0,
				UNIQUE(nome)
				PRIMARY KEY(nome_id)
			)";
						
				$wpdb->query($sql_voter);
		}
		
		//function for deleting tables
		function table_deletion(){
			global $wpdb;
						
			$wpdb->query("DROP TABLE wp_voter");
			$wpdb->query("DELETE FROM $wpdb->options WHERE option_name = 'nom_all' ");		
		}
		
	}
	//registering hook
	register_activation_hook( __FILE__, array('database_table_manipulation','table_creation'));
	register_deactivation_hook( __FILE__, array('database_table_manipulation','table_deletion'));

endif;//end of database manipulation class

?>

<?php

/*******************************************************************************************************************************************
 * *****************************************************************************************************************************************
					VOTE  SETUP CLASS
*******************************************************************************************************************************************
******************************************************************************************************************************************/



	

if(!class_exists('voting_class')):	
	class voting_class{
		function voting_content($content=''){
			if(is_single()){
				global $post;
				global $wpdb;
				// ge_options from options tables				
				$data = get_option('nom_all');
				//var_dump($data);
				//exit;
				//getting image link of the nominees
				$img_1 = $data['nom_1']['image']; 
				$img_2 = $data['nom_2']['image']; 
				$img_3 = $data['nom_3']['image']; 
				
				//getting  name of the nomiees
				$name_1 = $data['nom_1']['name'];
				$name_2 = $data['nom_2']['name'];
				$name_3 = $data['nom_3']['name'];
				
				//getting initial vote no
				
				$vote_1 = $data['nom_1']['voteno'];
				$vote_2 = $data['nom_2']['voteno'];
				$vote_3 = $data['nom_3']['voteno'];
				
				//getting description of the nominees
				$about_1 = $data['nom_1']['about'];
				$about_2 = $data['nom_2']['about'];
				$about_3 = $data['nom_3']['about'];
				
				//getting starting date and ending date and details
				$details = $data['nom_com']['details'];
				$sdate = $data['nom_com']['sday'];
				$edate = $data['nom_com']['eday'];
				
				//checking if user is admin
				if(current_user_can('edit_posts')){						
						//voter informations from wp_voter table
						
						$n_1 = $wpdb->get_col($wpdb->prepare("SELECT name FROM wp_voter WHERE nome_id=1"));
						$n_2 = $wpdb->get_col($wpdb->prepare("SELECT name FROM wp_voter WHERE nome_id=2"));
						$n_3 = $wpdb->get_col($wpdb->prepare("SELECT name FROM wp_voter WHERE nome_id=3"));
						/*
						$e_1 = $wpdb->get_col($wpdb->prepare("SELECT email FROM wp_voter WHERE nome_id=1"));
						$e_2 = $wpdb->get_col($wpdb->prepare("SELECT email FROM wp_voter WHERE nome_id=2"));
						$e_3 = $wpdb->get_col($wpdb->prepare("SELECT email FROM wp_voter WHERE nome_id=3"));
						 
						
						
						function array_adding($n,$e){
							$temp = '';
							for($i=0;$i<count($n);$i++){
								$temp .= ($i+1).'.'.$n[$i].'('.$e[$i].')<br/>';
							}
							return $temp;
						}
						
						$s_1 = 'Vote No '.$vote_1.'<br/>'.array_adding($n_1,$e_1);
						$s_2 = 'Vote No '.$vote_2.'<br/>'.array_adding($n_2,$e_2);
						$s_3 = 'Vote No '.$vote_3.'<br/>'.array_adding($n_3,$e_3);
						*/
						function array_name($y){
							$temp = '';
							for ($i=0;$i<count($y);$i++){
								$temp .= ($i+1).'.'.$y[$i].'<br/>';
							}
							return $temp;
						}
						$s_1 = 'Vote No '.$vote_1.'<br/>'.array_name($n_1); 
						$s_2 = 'Vote No '.$vote_2.'<br/>'.array_name($n_2); 
						$s_3 = 'Vote No '.$vote_3.'<br/>'.array_name($n_3); 
											
					
				}
				
				else{
					$s_1 = '<p id="abt_1" class="about">About Me</p><p class="abt_des">'.$about_1.'</p>';
					$s_2 = '<p id="abt_2" class="about">About Me</p><p class="abt_des">'.$about_2.'</p>';
					$s_3 = '<p id="abt_3" class="about">About Me</p><p class="abt_des">'.$about_3.'</p>';
															
					
				}
				
				//showing vote numbers
					//$data .= $post->post_content.'<br/></br>';
					$content_1='<div id="useraction">
								<h3 id="headr_text"> In order to vote pls click on a image <h3>
								<div id="fnom">
								
									<p id="name_1" class="name">'.$name_1.'</p>
									<a id="fnom_vote" href=""><img  src='.$img_1.' alt="imge for nominee1"'.'/></a>
									<br/>
									<div id="some_data_1" class="some_data">'.$s_1.'</div>								
								</div>';
								
					$content_2='<div id="snom">
									
									<p id="name_2" class="name">'.$name_2.'</p>
									<a id="snom_vote" href=""><img src='.$img_2.' alt="imge for nominee2"'.'/></a>
									<br/>
									<div id="some_data_2" class="some_data">'.$s_2.'</div>
								</div>';
								
					$content_3='<div id="tnom">
								
									<p id="name_3" class="name">'.$name_3.'</p>
									<a id="tnom_vote" href=""><img src='.$img_3.' alt="imge for nominee3"'.'/></a>
									<br/>
									<div id="some_data_3" class="some_data">'.$s_3.'</div>
																
								</div>';
								
					$content_4='<div id="details">
									<a href= '.'"'.$details.'"'.' target="_blanks" >Details</a>
								</div>
								<!-- <div id="ajax_start" class="formhidden">
									<form id="ajax_form" action="#">
									
									name*(required)<br/><input type="text" name="name"/><br/>
									email*(required)<br/><input type="text" name="email"><br/>
									comment<br/><textarea id="text_form" rows="3" cols="20"></textarea><br/>
									&nbsp&nbsp<input id="vote" type="button" value="vote"/>
									&nbsp&nbsp<input id="cancel" type="button" value="cancel"/><br/>
									</form>
								</div> -->
							</div>';
								
				$content = $content_1.$content_2.$content_3.$content_4;
				return $content;	
			}	
			
		}
		
		/*******************************************************************************
		 *      ALL JAVASCRIP CODE GOES HERE
		 * *********************************************************************/
		
		function voting_js(){
			if(is_single()){
				
				wp_enqueue_script('jquery');
				//wp_enqueue_script('myjquery_sohag',plugins_url('/voting-machine/js/voting.js'));
				// embed the javascript file that makes the AJAX request
				
				wp_enqueue_script( 'myjquery_sohag',plugins_url('/voting-machine/js/voting.js'),array('jquery'));
				$nonce=wp_create_nonce('wp-voting');
				 
				// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
				wp_localize_script( 'myjquery_sohag', 'VotingAjax', array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'votingnonace' => $nonce,
					'pluginsurl' => plugins_url('/voting-machine'),
				));

				//wp_register_style('voting_syle',plugins_url('/voting-machine/css/voting.css'));
				//wp_enqueue_style('voting_syle',plugins_url('/voting-machine/css/voting.css'));
			
			}
		}
		
		/*******************************************************************************
		 *  ADDING CSS
		 * *********************************************************************/
		
		function voting_css(){
			if(is_single()){
				wp_register_style('voting_syle',plugins_url('/voting-machine/css/voting.css'));
				wp_enqueue_style('voting_syle');
			}
		}
		
		
		/*******************************************************************************
		 *  FETCHING  AJAX DATA
		 * *********************************************************************/
		function myajax_data(){
						
			// we'll generate XML output
			//header('Content-Type: text/xml');
			// generate XML header
			echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
			// create the <response> element
			echo '<response>';
			
			global $wpdb;
			$allemails = null; 
			$message = 'voting machine is not set yet';
			// getting start date and end date and vote no 
			$day = get_option('nom_all');
			
			//getting diffferent images
			
			$img_1 = $day['nom_1']['image']; 
			$img_2 = $day['nom_2']['image']; 
			$img_3 = $day['nom_3']['image']; 
			
			//getting  name of the nomiees
			$name_1 = $day['nom_1']['name'];
			$name_2 = $day['nom_2']['name'];
			$name_3 = $day['nom_3']['name'];
			
			//getting vote numbers				
			$vote_1 = $day['nom_1']['voteno'];
			$vote_2 = $day['nom_2']['voteno'];
			$vote_3 = $day['nom_3']['voteno'];
			
			
			//getting description of the nominees
			$about_1 = $day['nom_1']['about'];
			$about_2 = $day['nom_2']['about'];
			$about_3 = $day['nom_3']['about'];
			
			
			//string to timestamp comparison
			$sday = strtotime($day['nom_com']['sday']);
			$eday = strtotime($day['nom_com']['eday']);
			$today = time();
			//filtering name 
			//$name = strip_tags($_REQUEST['name']);
			//wp functio is_email to verify wheather it is email
			$email = is_email($_REQUEST['email']) ? $_REQUEST['email'] : false;
			//comment veryfing
			//$comment = strip_tags($_REQUEST['comment']);
			//nomiee id selection
			$nom_id = $_REQUEST['nome_id'];
			
			// verifying which nomiee the voter has voted
			$nom_no = 'nom_'.$nom_id;			
			$vote_no = $day[$nom_no]['voteno'];
			//echo $nom_no.'<br/>'.$countvote;
			
			
			if($today <= $eday){
				if($today>= $sday){
					if($email){
						$allemails_voter = $wpdb->get_col($wpdb->prepare("SELECT email FROM wp_voter"));
						$allemails_user = $wpdb->get_col($wpdb->prepare("SELECT user_email FROM $wpdb->users"));
												
						
						if(in_array($email,$allemails_user)){
							if(in_array($email,$allemails_voter)){
								$message = 'sorry! You have already voted';
							}
													
							else{
								$name = $wpdb->get_var($wpdb->prepare("SELECT user_login FROM $wpdb->users WHERE user_email = '$email'"));
								$id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_email = '$email'"));
								//inserting voter informations
								$wp_voter = "INSERT INTO wp_voter(nome_id,user_id,name,email,comment)
										VALUES('$nom_id','$id','$name','$email','$comment')";
								if($wpdb->query($wpdb->prepare($wp_voter))){
																	
									//updating options table;
									
									if($nom_id==1){
										$vote_no = $vote_1 + 1;
										$update = array(
											'nom_1' => array('voteno' => $vote_no,
																	'name' => $name_1,
																	'image' => $image_1,
																	'about' => $about_1
															),
											'nom_2' => array('voteno' => $vote_1,
																	'name' => $name_2,
																	'image' => $image_2,
																	'about' => $about_2
															),
											'nom_3' => array('voteno' => $vote_3,
																	'name' => $name_3,
																	'image' => $image_3,
																	'about' => $about_3
															),								
										
													);
									}
									
									if($nom_id==2){
										$vote_no = $vote_2 + 1;
										$update = array(
											'nom_1' => array('voteno' => $vote_1,
																	'name' => $name_1,
																	'image' => $image_1,
																	'about' => $about_1
															),
											'nom_2' => array('voteno' => $vote_no,
																	'name' => $name_2,
																	'image' => $image_2,
																	'about' => $about_2
															),
											'nom_3' => array('voteno' => $vote_3,
																	'name' => $name_3,
																	'image' => $image_3,
																	'about' => $about_3
															),								
										
														);
									}
									
									if($nom_id==3){
										$vote_no = $vote_3 + 1;
										$update = array(
											'nom_1' => array('voteno' => $vote_1,
																	'name' => $name_1,
																	'image' => $image_1,
																	'about' => $about_1
															),
											'nom_2' => array('voteno' => $vote_2,
																	'name' => $name_2,
																	'image' => $image_2,
																	'about' => $about_2
															),
											'nom_3' => array('voteno' => $vote_no,
																	'name' => $name_3,
																	'image' => $image_3,
																	'about' => $about_3
															),								
									
														);
									}
																	
									if(update_option('nom_all',$update)){
																
										$message = 'Thank you '.$name.' for your vote';
									}
									else{
										$message = 'error in updating options table';
									}
								}
								else {
									$message = 'error inserting data into wp_voter.pls contact with the sevice provider';			
								}
							}
						}
						else{
							$message = 'Pls log in to vote';
						}
					}
					else{
						$message = 'pls check your email';
					}
				}
				else{
					$message = 'Sorry! voting date has not been fixed yet';
				}			
			}
			else{
				$message = 'Sorry! Date expired for vote';
			}
			
			echo '<message>' . $message . '</message>';
			echo '<nominee>' . $nom_id .'</nominee>';
			echo '<voteno>' . $vote_no .'</voteno>';
			echo '</response>';
			
			exit;
			
		}//end of the ajax data function
					
							
	}
		
			//instanciating the class and making hooks
			$vote = new voting_class();
			add_action('wp_print_scripts',array($vote,'voting_js'));
			add_action('wp_print_styles',array($vote,'voting_css'));
			add_filter('the_content',array($vote,'voting_content'),50);
			//response from ajax
			add_action( 'wp_ajax_nopriv_myajax_data',array($vote,'myajax_data'));
			add_action( 'wp_ajax_myajax_data',array($vote,'myajax_data'));
		
	
	
endif;
		

?>

<?php 
	//adding setting options
	include_once("vote_setting.php");

?>
