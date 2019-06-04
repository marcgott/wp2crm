<?php
class options_page {

	public $options;

	function __construct() {
		global $options;
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'init_fields') );
	
		wp_enqueue_script('media-upload');
		wp_enqueue_script('jquery-ui-tabs',array('jquery'));
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_style('jquery-ui-tabs');
	
		$this->options=get_option('wp2crm_settings');
}

	function admin_menu() {
		add_menu_page(
			'BBCRM Settings',
			'BBCRM Settings',
			'manage_options',
			'wp2crm-options',
			array($this,'settings_page')
		);
	}

function settings_page() {
?>
<div style='margin:1em;float:right;max-width:30%'><img style="width:100%" src='<?php echo plugin_dir_url(__FILE__)."images/wp2crm.png"; ?>' /></div>
<h2><?php _e('BBCRM Front End Settings','wp2crm')?></h2>
<p>This is the frontend control panel for your BusinessBrokersCRM application. These settings are used to associate different fields with their corresponding fields from the CRM. Please use caution when modifying this information, as changes can potentially interrupt access to different pages and services on your site. If you have any questions, please contact support@verticacrm.com.</p>
<link rel="stylesheet" type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/overcast/jquery-ui.css"/>
<script type="text/javascript">
jQuery(document).ready(function() {

imguploadid=''

jQuery("#tabs").tabs();

jQuery('.upload_image_button').click(function() {
imguploadid = jQuery(this).data("opt")
//console.log(imguploadid)
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
 
window.send_to_editor = function(html) {
//console.log(html)
imgurl = jQuery(html).attr('src');
//console.log(imgurl)
jQuery('#upload-image-'+imguploadid).val(imgurl);
tb_remove();
}
 
});
</script>
	<form action='options.php' method='post'>		
	<div id="tabs" style="display:inline-block">
	<ul>
<?php
global $wp_settings_sections, $wp_settings_fields;

foreach((array)$wp_settings_sections['pluginPage'] as $section) :
        if(!isset($section['title']))
	            continue;

	printf('<li><a href="#%1$s">%2$s</a></li>', $section['id'], $section['title']);
endforeach;
?>
	</ul>
<?php
	settings_fields( 'pluginPage' );
//////
foreach((array)$wp_settings_sections['pluginPage'] as $section) :

         printf('<div id="%1$s">',$section['id']);

	if($section['callback'])
		call_user_func($section['callback'], $section);

	if(!isset($wp_settings_fields) || !isset($wp_settings_fields['pluginPage']) || !isset($wp_settings_fields['pluginPage'][$section['id']]))
		continue;

	echo '<table class="form-table">';
	do_settings_fields('pluginPage', $section['id']);
	echo '</table>';
	echo '</div>';
endforeach;
echo "</div><!-- end tab div -->";
////
submit_button();
?>
</form>
<?php
}

public function init_fields(){
	register_setting( 'pluginPage', 'wp2crm_settings' );

	add_settings_section(
		'wp2crm_loginbar_section', 
		__( 'Login Bar Fields', 'wp2crm' ), 
		array($this,'wp2crm_settings_section_callback'), 
		'pluginPage'
	);

	add_settings_field( 
		'wp2crm_loginbar_phone', 
		__( 'Phone Number', 'wp2crm' ), 
		array($this,'wp2crm_text_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_loginbar_phone')
	);

	add_settings_field( 
		'wp2crm_phone_showhide',
		__( 'Display Phone Number?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_phone_showhide')
	);

	add_settings_field( 
		'wp2crm_loginbar_fax', 
		__( 'Fax Number', 'wp2crm' ), 
		array($this,'wp2crm_text_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_loginbar_fax')
	);
	
	add_settings_field( 
		'wp2crm_fax_showhide',
		__( 'Display Fax Number?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_fax_showhide')
	);

	add_settings_field( 
		'wp2crm_loginbar_email', 
		__( 'Main Email Address', 'wp2crm' ), 
		array($this,'wp2crm_text_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_loginbar_email')
	);

	add_settings_field( 
		'wp2crm_email_showhide',
		__( 'Display Email Address?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_email_showhide')
	);

	add_settings_field( 
		'wp2crm_contactus_showhide',
		__( 'Display Contact Us Link?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_loginbar_section',
		array('option-name'=>'wp2crm_contactus_showhide')
	);

	add_settings_section(
		'wp2crm_pages_section',
		__('Default Pages','wp2crm'),
		array($this,'wp2crm_settings_section_callback'),
		'pluginPage'
	);
	add_settings_field( 
		'wp2crm_loginbar_contactus', 
		__( 'Contact Us Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_loginbar_contactus')
	);
	add_settings_field( 
		'wp2crm_pageselect_brokerteam', 
		__( 'Broker Team Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_pageselect_brokerteam')
	)
	;
	add_settings_field( 
		'wp2crm_pageselect_broker', 
		__( 'Broker Detail Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_pageselect_broker')
	);


	add_settings_field( 
		'wp2crm_loginbar_dataroom', 
		__( 'Data Room Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_loginbar_dataroom')
	);

	add_settings_field( 
		'wp2crm_loginbar_searchresults', 
		__( 'Search Results Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_loginbar_searchresults')
	);
	
	add_settings_field( 
		'wp2crm_pages_registration', 
		__( 'Registration Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_pages_registration')
	);
	
	add_settings_field( 
		'wp2crm_pages_buyerprofile', 
		__( 'Buyer Profile Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_pages_buyerprofile')
	);
	
	add_settings_field( 
		'wp2crm_pages_welcome', 
		__( 'Buyer Registration Welcome Page', 'wp2crm' ), 
		array($this,'wp2crm_selectpage_render'), 
		'pluginPage', 
		'wp2crm_pages_section',
		array('option-name'=>'wp2crm_pages_welcome')
	);
	
	add_settings_section(
		'wp2crm_design_section', 
		__( 'Design Elements', 'wp2crm' ), 
		array($this,'wp2crm_settings_section_callback'), 
		'pluginPage'
	);
	
	add_settings_field( 
		'wp2crm_design_logo', 
		__( 'Logo', 'wp2crm' ), 
		array($this,'wp2crm_media_upload_render'), 
		'pluginPage', 
		'wp2crm_design_section',
		array('option-name'=>'wp2crm_design_logo')
	);
	add_settings_field( 
		'wp2crm_design_favicon', 
		__( 'Favicon', 'wp2crm' ), 
		array($this,'wp2crm_media_upload_render'), 
		'pluginPage', 
		'wp2crm_design_section',
		array('option-name'=>'wp2crm_design_favicon')
	);
	add_settings_field( 
		'wp2crm_design_noimage', 
		__( 'No Thumbnail Image', 'wp2crm' ), 
		array($this,'wp2crm_media_upload_render'), 
		'pluginPage', 
		'wp2crm_design_section',
		array('option-name'=>'wp2crm_design_noimage')
	);

	add_settings_section(
		'wp2crm_crm_section', 
		__( 'CRM Defaults', 'wp2crm' ), 
		array($this,'wp2crm_settings_section_callback'), 
		'pluginPage'
	);
	
	add_settings_field( 
		'wp2crm_crm_assignedTo', 
		__( 'Default Assigned To User', 'wp2crm' ), 
		array($this,'wp2crm_select_assignedTo_render'), 
		'pluginPage', 
		'wp2crm_crm_section',
		array('option-name'=>'wp2crm_crm_assignedTo')
	);

	add_settings_field( 
		'wp2crm_crm_states', 
		__( 'Default States/Territories/Regions', 'wp2crm' ), 
		array($this,'wp2crm_select_dropdowns_render'), 
		'pluginPage', 
		'wp2crm_crm_section',
		array('option-name'=>'wp2crm_crm_states')
	);

	add_settings_field( 
		'wp2crm_crm_buscats', 
		__( 'Business Categories', 'wp2crm' ), 
		array($this,'wp2crm_select_dropdowns_render'), 
		'pluginPage', 
		'wp2crm_crm_section',
		array('option-name'=>'wp2crm_crm_buscats')
	);

	add_settings_field( 
		'wp2crm_crm_buscats_parents',
		__( 'Business Category Parents', 'wp2crm' ), 
		array($this,'wp2crm_select_dropdowns_render'), 
		'pluginPage', 
		'wp2crm_crm_section',
		array('option-name'=>'wp2crm_crm_buscats_parents')
	);

	add_settings_field( 
		'wp2crm_crm_nda', 
		__( 'Registration NDA', 'wp2crm' ), 
		array($this,'wp2crm_select_docs_render'), 
		'pluginPage', 
		'wp2crm_crm_section',
		array('option-name'=>'wp2crm_crm_nda')
	);

	add_settings_section(
		'wp2crm_buyerreg_section', 
		__( 'Buyer Registration', 'wp2crm' ), 
		array($this,'wp2crm_settings_section_callback'), 
		'pluginPage'
	);
	
	add_settings_field( 
		'wp2crm_buyerreg_fields', 
		__( 'Buyer Registration', 'wp2crm' ), 
		array($this,'wp2crm_crm_fields_render'), 
		'pluginPage', 
		'wp2crm_buyerreg_section',
		array('option-name'=>'wp2crm_buyerreg_fields','model'=>"Contacts")
	);

	add_settings_field( 
		'wp2crm_broker_showhide',
		__( 'Display Broker?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_buyerreg_section',
		array('option-name'=>'wp2crm_broker_showhide')
	);

	add_settings_field( 
		'wp2crm_listing_showhide',
		__( 'Display Listing?', 'wp2crm' ), 
		array($this,'wp2crm_checkbox_render'), 
		'pluginPage', 
		'wp2crm_buyerreg_section',
		array('option-name'=>'wp2crm_listing_showhide')
	);

	add_settings_section(
		'wp2crm_listingdetails_section', 
		__( 'Listing Details', 'wp2crm' ), 
		array($this,'wp2crm_settings_section_callback'), 
		'pluginPage'
	);
	
	add_settings_field( 
		'wp2crm_listingdetails_fields', 
		__( 'Listing Details', 'wp2crm' ), 
		array($this,'wp2crm_crm_fields_render'), 
		'pluginPage', 
		'wp2crm_listingdetails_section',
		array('option-name'=>'wp2crm_listingdetails_fields','model'=>"Clistings")
	);

	}

function wp2crm_media_upload_render($args ) { 
	?>
<input id="upload-image-<?php echo $args['option-name'];?>"" data-opt="<?php echo $args['option-name'];?>" class="upload_image" type="text" size="36" name="wp2crm_settings[<?php echo $args['option-name'];?>]" value="<?php echo $this->options[$args['option-name']];?>" />
<input id="upload-image-button-<?php echo $args["option-name"];?>" data-opt="<?php echo $args["option-name"];?>" class="upload_image_button" type="button" value="Upload Image" />
<br />Enter an URL or upload an image.
	<?php

}
function wp2crm_text_render($args ) { 
	?>
	<input type='text' name='wp2crm_settings[<?php echo $args['option-name'];?>]' value='<?php echo $this->options[$args['option-name']];?>'>
	<?php
}

function wp2crm_checkbox_render($args ) { 
	?>
	<input type='checkbox' name='wp2crm_settings[<?php echo $args['option-name'];?>]' value='1' <?php if(!empty($this->options[$args['option-name']])){checked($this->options[$args['option-name']],1,1);}?> />
	<?php
}

function wp2crm_selectpage_render( $args ) {
?>
	<?php wp_dropdown_pages( array('selected'=>$this->options[$args['option-name']],'name'=>"wp2crm_settings[".$args['option-name']."]",'echo'=>1) );?>
<?php
}

function wp2crm_select_assignedTo_render($args) {
	$useroptions='';
	$json = x2apicall((array('_class'=>'users')));
	$userar = json_decode($json);
	foreach($userar as $wp2crmuser){
		$useroptions .="<option value='".$wp2crmuser->username."' ".selected($this->options[$args['option-name']],$wp2crmuser->username,0).">".$wp2crmuser->firstName." ".$wp2crmuser->lastName."</option>";
	}
	echo "<select name='wp2crm_settings[".$args['option-name']."]'>";
	echo $useroptions;
	echo "</select>";
}

function wp2crm_select_docs_render($args) {
	$dropdownoptions='';
	$json = x2apicall((array('_class'=>'Docs')));
	$dropdownar = json_decode($json);
	foreach($dropdownar as $dropdown){
		$dropdownoptions .="<option value='".$dropdown->id."' ".selected($this->options[$args['option-name']],$dropdown->id,0).">".$dropdown->name."</option>";
	}
	echo "<select name='wp2crm_settings[".$args['option-name']."]'>";
	echo $dropdownoptions;
	echo "</select>";
}

function wp2crm_select_dropdowns_render($args) {
	$dropdownoptions='';
	$json = x2apicall((array('_class'=>'dropdowns')));
	$dropdownar = json_decode($json);
	foreach($dropdownar as $dropdown){
		$dropdownoptions .="<option value='".$dropdown->id."' ".selected($this->options[$args['option-name']],$dropdown->id,0).">".$dropdown->name."</option>";
	}
	echo "<select name='wp2crm_settings[".$args['option-name']."]'>";
	echo $dropdownoptions;
	echo "</select>";
}

function wp2crm_crm_fields_render($args) {
	$dropdownoptions='';
	$json = x2apicall((array('_class'=>$args["model"].'/fields')));
	$dropdownar = json_decode($json);
	foreach($dropdownar as $dropdown){
		if($dropdown->type != "assignment" && $dropdown->keyType != "PRI" && $dropdown->type !="link")
			$dropdownoptions .="<div><input type=checkbox name='wp2crm_settings[".$args['option-name']."][]' value='".$dropdown->id."' ".(in_array($dropdown->id,$this->options[$args['option-name']])?"checked":'').">".$dropdown->attributeLabel."</div>";
	}
	echo "<div style='width:400px;height:250px;overflow:auto'>";
	echo $dropdownoptions;
	echo "</div>";
}

function wp2crm_settings_section_callback($args ) { 

$description = array(
	'wp2crm_loginbar_section'=>'These fields typically appear in the customer login bar.<br>Your template can be customized to display these fields in additional places.',
	'wp2crm_pages_section'=>'These fields identify the Wordpress pages for each of the BBCRM template pages when referenced in the templates.',
	'wp2crm_design_section'=>'You can upload your logo and browser favicon using these fields.',
	'wp2crm_crm_section'=>'These fields identify which default values and dropdowns should be used in the page templates.',
	'wp2crm_buyerreg_section'=>'This is the complete list of fields that your Buyer record contains.<br>You can determine which fields will appear in your initial registration form by selecting the corresponding checkbox.',
	);

	echo $description[$args["id"]];
}

}

new options_page;
