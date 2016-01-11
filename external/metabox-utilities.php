<?php
//Add metabox with dynamically added key-value custom fields
//Usage: foreach ($calendar as $event) { echo '<li>'.$event[title].' - '.$event[date].'</li>';} 
//Based on http://wordpress.stackexchange.com/questions/19838/create-more-meta-boxes-as-needed/19852#19852

// Caution, there're 2 set of options below
//Variables used in the following functions should be mentioned in the 'global' statement of each of them appropriately
//=======Options 1=======
$dmb_post_type = 'language';
$dmb_metabox_label = 'Вопросы для тестирования';
$dmb_cf_name = 'test_questions';

// Add actions, initialise functions
add_action( 'add_meta_boxes', 'dynamic_add_custom_box' );
add_action( 'save_post', 'dynamic_save_postdata' );

$dmb_cf_nonce = $dmb_cf_name.'_nonce';

//Function to add a meta box 
function dynamic_add_custom_box() {
	global $dmb_post_type, $dmb_metabox_label, $dmb_cf_name;

	add_meta_box('dynamic_sectionid', $dmb_metabox_label, 'dynamic_inner_custom_box', $dmb_post_type);
}

//Function that defines metabox contents
function dynamic_inner_custom_box() {

	//=======Options 2=======
	$dmb_label_addnew = 'Добавить вопрос';
	$dmb_label_remove = '-';
	$dmb_question_name = 'question'; 
	$dmb_answer_a_name = 'answer_a';
	$dmb_answer_b_name = 'answer_b';
	$dmb_answer_c_name = 'answer_c';
	$dmb_answer_d_name = 'answer_d';
	$dmb_iscorrect_name = 'is_correct';
	$dmb_isadvanced_name = 'is_advanced';
	$dmb_isadvanced_label = 'Вопрос только для продвинутой версии';
	$dmb_question_label = 'Текст вопроса';
	$dmb_answer_a_label = 'Вариант A';
	$dmb_answer_b_label = 'Вариант B';
	$dmb_answer_c_label = 'Вариант C';
	$dmb_answer_d_label = 'Вариант D';

	global $post, $dmb_cf_name, $dmb_cf_nonce;

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $dmb_cf_nonce );

	?>
	<div id="dynamic_inner_custom_box">
	<?php
	$dmb_items = get_post_meta($post->ID,$dmb_cf_name,true);
	$c = 0;
	if ( count( $dmb_items ) > 0 ) {
		if (is_array($dmb_items)) {
			foreach( $dmb_items as $dmb_item ) {
				// if ( isset( $dmb_item[$dmb_question_name] )
				// 	|| isset( $dmb_item[$dmb_answer_a_name] ) 
				// 	|| isset( $dmb_item[$dmb_answer_b_name] ) 
				// 	|| isset( $dmb_item[$dmb_answer_c_name] ) 
				// 	|| isset( $dmb_item[$dmb_answer_d_name] ) 
				// 	|| isset( $dmb_item[$dmb_isadvanced_name] ) 
				// ) {
					echo "<div class='metagroup'>
						<a href='#' class='rwmb-button button remove' title='Удалить'>$dmb_label_remove</a>
						<h4>Вопрос</h4>
							<label class='floated'>$dmb_isadvanced_label
								<input name='".$dmb_cf_name."[".$c."][".$dmb_isadvanced_name."]' ".((isset($dmb_item[$dmb_isadvanced_name]) && $dmb_item[$dmb_isadvanced_name])?'checked':'')." type='checkbox' value='".$dmb_cf_name."[".$c."][".$dmb_question_name."]'>
							</label>
							<label>$dmb_question_label 
								<input type='text' name='".$dmb_cf_name."[".$c."][".$dmb_question_name."]' value='{$dmb_item["$dmb_question_name"]}' size='35'>
							</label> 
							<label class='inlined'>
								<input name='".$dmb_cf_name."[".$c."][".$dmb_iscorrect_name."]' ".(($dmb_item[$dmb_iscorrect_name] == $dmb_cf_name."[".$c."][".$dmb_answer_a_name."]")?'checked':'')." type='radio' value='".$dmb_cf_name."[".$c."][".$dmb_answer_a_name."]'>
								$dmb_answer_a_label 
								<input size='15' type='text' name='".$dmb_cf_name."[".$c."][".$dmb_answer_a_name."]' value='{$dmb_item["$dmb_answer_a_name"]}'>
							</label> 
							<label class='inlined'>
								<input name='".$dmb_cf_name."[".$c."][".$dmb_iscorrect_name."]' ".(($dmb_item[$dmb_iscorrect_name] == $dmb_cf_name."[".$c."][".$dmb_answer_b_name."]")?'checked':'')." type='radio' value='".$dmb_cf_name."[".$c."][".$dmb_answer_b_name."]'>
								$dmb_answer_b_label 
								<input size='15' type='text' name='".$dmb_cf_name."[".$c."][".$dmb_answer_b_name."]' value='{$dmb_item["$dmb_answer_b_name"]}'>
							</label> 
							<label class='inlined'>
								<input name='".$dmb_cf_name."[".$c."][".$dmb_iscorrect_name."]' ".(($dmb_item[$dmb_iscorrect_name] == $dmb_cf_name."[".$c."][".$dmb_answer_c_name."]")?'checked':'')." type='radio' value='".$dmb_cf_name."[".$c."][".$dmb_answer_c_name."]'>
								$dmb_answer_c_label 
								<input size='15' type='text' name='".$dmb_cf_name."[".$c."][".$dmb_answer_c_name."]' value='{$dmb_item["$dmb_answer_c_name"]}'>
							</label> 
							<label class='inlined'>
								<input name='".$dmb_cf_name."[".$c."][".$dmb_iscorrect_name."]' ".(($dmb_item[$dmb_iscorrect_name] == $dmb_cf_name."[".$c."][".$dmb_answer_d_name."]")?'checked':'')." type='radio' value='".$dmb_cf_name."[".$c."][".$dmb_answer_d_name."]'>
								$dmb_answer_d_label 
								<input size='15' type='text' name='".$dmb_cf_name."[".$c."][".$dmb_answer_d_name."]' value='{$dmb_item["$dmb_answer_d_name"]}'>
							</label> 
						</div>";
					$c = $c +1;
				// }
			}
		}
	}
	?>
	<div id="here"></div><hr>
	<a href="#" class="add button-secondary"><?php echo $dmb_label_addnew; ?></a>
	<script>
		var $ =jQuery.noConflict();
		$(document).ready(function() {
			
			var count = <?php echo $c; ?>;

			$(".add").on('click',function(e) {
				e.preventDefault();
				$('#here').append('<div class="metagroup"> \
					<a href="#" class="rwmb-button button remove" title="Удалить"><?php echo $dmb_label_remove; ?></a> \
					<h4>Вопрос</h4> \
					<label class="floated"><?php echo $dmb_isadvanced_label; ?> \
						<input name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_isadvanced_name; ?>]" type="checkbox" value="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_question_name; ?>]"> \
					</label> \
					<label><?php echo $dmb_question_label; ?> \
						<input size="35" type="text" name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_question_name; ?>]" value=""> \
					</label> \
					<label class="inlined"> \
						<input name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_iscorrect_name; ?>]" checked type="radio" value="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_a_name; ?>]"> \
						<?php echo $dmb_answer_a_label; ?> \
						<input size="15" type="text" name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_a_name; ?>]" value=""> \
					</label> \
					<label class="inlined"> \
						<input name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_iscorrect_name; ?>]" type="radio" value="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_b_name; ?>]"> \
						<?php echo $dmb_answer_b_label; ?>  \
						<input size="15" type="text" name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_b_name; ?>]" value=""> \
					</label> \
					<label class="inlined"> \
						<input name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_iscorrect_name; ?>]" type="radio" value="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_c_name; ?>]"> \
						<?php echo $dmb_answer_c_label; ?> \
						<input size="15" type="text" name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_c_name; ?>]" value=""> \
					</label> \
					<label class="inlined"> \
						<input name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_iscorrect_name; ?>]" type="radio" value="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_d_name; ?>]"> \
						<?php echo $dmb_answer_d_label; ?> \
						<input size="15" type="text" name="<?php echo $dmb_cf_name; ?>['+count+'][<?php echo $dmb_answer_d_name; ?>]" value=""> \
					</label> \
				</div>');
				count = count + 1;
				return false;
			});
			$("#dynamic_inner_custom_box").on('click', '.remove', function(e) {
				e.preventDefault();
				$(this).parents('.metagroup').remove();
			});
		});
		</script>
	</div><?php
}

/* When the post is saved, saves our custom data */
function dynamic_save_postdata( $post_id ) {
	global $dmb_cf_name;
	global $dmb_cf_nonce;

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	if ( empty($_POST[$dmb_cf_name]) )
		return;
	if ( !wp_verify_nonce( $_POST[$dmb_cf_nonce], plugin_basename( __FILE__ ) ) )
		return;

	function array_map_r( $func, $arr )
	{
		$newArr = array();

		foreach( $arr as $key => $value )
		{
			$newArr[ $key ] = ( is_array( $value ) ? array_map_r( $func, $value ) : ( is_array($func) ? call_user_func_array($func, $value) : $func( $value ) ) );
		}

		return $newArr;
	}

	$data2post = array_map_r("esc_attr",$_POST[$dmb_cf_name]);
	update_post_meta($post_id,$dmb_cf_name,$data2post);
}
