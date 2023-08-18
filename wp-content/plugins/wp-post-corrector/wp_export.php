<?php
/*
Plugin Name: WP Post Correct from Excell and CSV
Plugin URI: http://wpwebs.com/
Description: The plugin is useful to take backup of your database to excel sheet as well you can upload to new database or you can either correct or update the wrong post data and . It will give you complete post information with post title,desctioption and all custom fields and values. You can see the website and author link @ <a href="http://wpwebs.com/" target="_blank">http://wpwebs.com/</a>
Version: 1.0.2
Author: wpwebs Team - VA Jariwala
Author URI: http://wpwebs.com/
*/


set_time_limit(0);
$rootdir = dirname(__FILE__);
$plugin_foldername = substr($rootdir,strpos($rootdir,'\\plugins\\')+9,strlen($rootdir));

global $wpdb,$table_prefix;
if(!function_exists('ramwp_export_init')){
function ramwp_export_init() {
	global $wpdb,$url_db_table_name;
}
}
add_action('init', 'ramwp_export_init');

if(!function_exists('ramwp_export_interface_menu_page')){
function ramwp_export_interface_menu_page() {
	if ( function_exists('add_submenu_page') )
	{
		add_submenu_page('tools.php', __('WP Correct &raquo; Correct Post data easy &raquo; wpwebs.com','vaj'), __("WP Correct",'vaj'),'manage_options', 'export', 'ramwp_export_add_action');			
	}
}
}
add_action('admin_menu', 'ramwp_export_interface_menu_page');

if(!function_exists('ramwp_export_admin_init')){
function ramwp_export_admin_init() {
	if ( function_exists( 'get_plugin_page_hook' ) )
		$hook = get_plugin_page_hook( 'akismet-stats-display', 'index.php' );
	else
		$hook = 'dashboard_page_akismet-stats-display';
	add_action('admin_head-'.$hook, 'akismet_stats_script');
}
}
add_action('admin_init', 'ramwp_export_admin_init');

if(!function_exists('ram_wp_export_post_info')){
function ram_wp_export_post_info()
{
	if (!empty($_REQUEST['page']) && $_REQUEST['page']=='export' && !empty($_REQUEST['backup']) && $_REQUEST['backup']=='posts')
	{
		global $wpdb;
		if($_REQUEST['backup']=='posts')
		{
			$user_info = $wpdb->get_results("select ID,user_login from $wpdb->users");
			
			foreach($user_info as $user_info_obj)
			{
				$user_info_array[$user_info_obj->ID]=$user_info_obj->user_login;
			}
			$all_meta_keys = $wpdb->get_col("select distinct(meta_key) from $wpdb->postmeta where post_id in (select ID from $wpdb->posts where post_type='post' and post_status in ('draft','publish'))");
			
			$post_sql = "select * from $wpdb->posts where post_type='post' and post_status in ('draft','publish')";
			$post_res = $wpdb->get_results($post_sql);
			if($post_res){
			$content_arr = array();
			$title_key_arr = array();
			$post_info_arr_count = array();
			
			foreach($post_res as $post_res_obj)
			{
				$title_arr = array();
				$content_arr1=array();
				$title_arr[] = 'ID';
				$content_arr1[]=$pid=$post_res_obj->ID;
				$title_arr[] = 'post_title';
				$content_arr1[]=$post_res_obj->post_title;
				$title_arr[] = 'post_content';
				$content_arr1[]=htmlentities($post_res_obj->post_content);
				$title_arr[] = 'post_excerpt';
				$content_arr1['post_excerpt']= $post_res_obj->post_excerpt;
				
				$CATEGORY_ARR = wp_get_post_terms($pid,$taxonomy = 'category', array('fields' => 'names'));
				$CATEGORY = '';
				if($CATEGORY_ARR){
					$CATEGORY=implode(',',$CATEGORY_ARR);
				}
				$title_arr[] = 'category';
				$content_arr1[]=$CATEGORY;
				$tags_ids =wp_get_post_terms($pid,$taxonomy = 'post_tag', array('fields' => 'names'));
				$tags = '';
				if($tags_ids)
				{
					$tags=implode(',',$tags_ids);
				}
				$title_arr[] = 'post_tag';
				$content_arr1['post_tag']=$tags;
				$title_arr[] = 'post_author';
				if($user_info_array)
				{
					$content_arr1['post_author']=$user_info_array[$post_res_obj->post_author];
				}
				$title_arr[] = 'post_status';
				$content_arr1['post_status']= $post_res_obj->post_status;
				$title_arr[] = 'comment_status';
				$content_arr1['comment_status']= $post_res_obj->comment_status;
				
				for($k=0;$k<count($all_meta_keys);$k++)
				{
					$content_arr1[] = get_post_meta($pid,$all_meta_keys[$k],true);//post meta
				}
				
				$content_arr[] = '<tr><td>'.implode('</td><td>',$content_arr1).'</td></tr>';
			}
			if($content_arr)
			{
				$title_arr1 =array_merge($title_arr,$all_meta_keys);
				$title_contnet = '<tr><td>'.implode('</td><td>',$title_arr1).'</td></tr>';
				$content_arr = implode('',$content_arr);
				$content_final = '<table border="1">'.$title_contnet.$content_arr.'</table>';
				$upload_dir = wp_upload_dir();
				$basedir = $upload_dir['basedir'];
				$baseurl = $upload_dir['baseurl'];
				$filename = "products_".date('YmdHis').".xls";
				$fp = fopen($basedir.'/'.$filename,'wr');
				fwrite($fp,$content_final);
				$excell_file = $baseurl.'/'.$filename; 
				wp_redirect($excell_file);
			}
			exit;	
			}else
			{
				$form_url = site_url('/wp-admin/admin.php');
				echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
				echo '<input type="hidden" name="page" value="export" >Sorry, no data to export.';
				echo '<input type="hidden" name="uemsg" value="nodata" >';
				echo '</form>';
				echo '<script>document.error_form_redirect.submit();</script>';
				exit;
			}
		}
	exit;
	}
}
}
add_action('init', 'ram_wp_export_post_info'); //EXPORT DATA EXCEL

if(!function_exists('ramwp_export_add_action')){
function ramwp_export_add_action()
{
	global $wpdb;
	if($_POST)
	{
		if($_POST['act']=='upload')
		{
			$wp_upload_dir = wp_upload_dir();
	$wp_upload_dir_sub_dir = substr($wp_upload_dir['subdir'],1,strlen($wp_upload_dir['subdir']));
	if($_FILES['bulk_upload_csv']['name']!='' && $_FILES['bulk_upload_csv']['error']=='0')
	{
		$row_insert_counter = 0;
		$row_update_counter = 0;
		$filename = $_FILES['bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$upload_dir = wp_upload_dir();
			$basedir = $upload_dir['basedir'];
			$baseurl = $upload_dir['baseurl'];
			$destination_path = $basedir."/csv";
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);				
			}
			$target_path = $destination_path .'/'. $filename;
			$csv_target_path = $target_path;
			if(@move_uploaded_file($_FILES['bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen ($target_path, "rt");
				$customKeyarray = array();
				$post_custom_arr = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 4096);
					if($rowcount == 0)
					{
						$user_info = $wpdb->get_results("select ID,user_login from $wpdb->users");
						foreach($user_info as $user_info_obj)
						{
							$user_info_array[$user_info_obj->user_login]=$user_info_obj->ID;
						}
						$post_data_key = array();
						$post_image_arr = array();
						for($k=0;$k<count($buffer);$k++)
						{
							
							$customKeyarray[$k] = trim($buffer[$k]);
	if($customKeyarray[$k]=='ID'){
	$post_data_key[$k]='ID';
	$ID = $k;
	}else
	if($customKeyarray[$k]=='post_title'){
	$post_data_key[$k]='post_title';
	$post_title=$k;
	}else
	if($customKeyarray[$k]=='post_content'){
	$post_data_key[$k]='post_content';
	}else
	if($customKeyarray[$k]=='post_excerpt'){
	$post_data_key[$k]='post_excerpt';
	}else
	if($customKeyarray[$k]=='category'){
	$post_data_key[$k]='category';
	}else
	if($customKeyarray[$k]=='post_tag'){
	$post_data_key[$k]='post_tag';
	}else
	if($customKeyarray[$k]=='post_author'){
	$post_data_key[$k]='post_author';
	}else
	if($customKeyarray[$k]=='post_status'){
	$post_data_key[$k]='post_status';
	}else
	if($customKeyarray[$k]=='comment_status'){
	$post_data_key[$k]='comment_status';
	}else
	if($customKeyarray[$k]=='IMAGE'){
	$post_image_arr[]=$k;
	}else
	{
		$post_data_key[$k]=$customKeyarray[$k];
		$post_custom_arr[$customKeyarray[$k]] = $k; 
	}
	
	if(trim($buffer[$ID])!='' || trim($buffer[$post_title])!=''){ 
	}else
	{
	$form_url = site_url().'/wp-admin/admin.php';
	echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
	echo '<input type="hidden" name="page" value="export" >';
	echo '<input type="hidden" name="uemsg" value="id_title" >';
	echo '</form>';
	echo '<script>document.error_form_redirect.submit();</script>';
	exit;
	}
						}
					}else
					{
						$my_post = array();
						$id_val = array_keys($post_data_key,'ID');
						$post_title_val = array_keys($post_data_key,'post_title');
						$post_content_val = array_keys($post_data_key,'post_content');
						$post_excerpt_val = array_keys($post_data_key,'post_excerpt');
						$post_status_val = array_keys($post_data_key,'post_status');
						$category_val = array_keys($post_data_key,'category');
						$post_tag_val = array_keys($post_data_key,'post_tag');
						$comment_status_val = array_keys($post_data_key,'comment_status');
						$post_author_val = array_keys($post_data_key,'post_author');
						
						$ID = trim($buffer[$id_val[0]]);
						$post_title = trim($buffer[$post_title_val[0]]);
						$post_content = trim($buffer[$post_content_val[0]]);
						$post_excerpt = trim($buffer[$post_excerpt_val[0]]);
						$category = trim($buffer[$category_val[0]]);
						$post_tag = trim($buffer[$post_tag_val[0]]);
						if($user_info_array)
						{
							$post_author = $user_info_array[trim($buffer[$post_author_val[0]])];
						}
						$post_status = trim($buffer[$post_status_val[0]]);
						$comment_status = trim($buffer[$comment_status_val[0]]);
						if($ID!='' || $post_title!=''){
						if($post_content){
							$my_post['post_content'] = $post_content;
						}
						if($post_excerpt){
							$my_post['post_excerpt'] = $post_excerpt;
						}
						if($category){
							$category_id=array();
							$category_arr =  explode(',',$category);
							for($ic=0;$ic<count($category_arr);$ic++)
							{
								if(trim($category_arr[$ic]))
								{
									$catname=trim($category_arr[$ic]);
									global $wpdb;
									$catid = $wpdb->get_var("select t.term_id from $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where t.name like \"$catname\" and tt.taxonomy='category'");
									if($catid){			
									}else
									{
										@wp_insert_term( $category_arr[$ic], 'category');
									}
									$category_id[] = get_cat_ID($catname);
								}
							}
						$my_post['post_category'] = $category_id;
						}
						if($post_status){
						$my_post['post_status'] = $post_status;
						}
						if($post_title){$my_post['post_title'] = $post_title;}
						if($post_tag){
						$my_post['tags_input'] =  explode(',',$post_tag);
						}
						if($comment_status){
						$my_post['comment_status'] = $comment_status;
						}
						if($post_author){
						$my_post['post_author'] = $post_author;
						}
						
						if($ID){
							$my_post['ID'] = $ID;
						}elseif($post_title)
						{
							$ptitle = $post_title;
							$pid = $wpdb->get_var("select ID from $wpdb->posts where post_title like \"$ptitle\" and post_status in ('publish','draft')");
							$my_post['ID'] = $pid;
						}
						
						$custom_meta = array();
						foreach($post_custom_arr as $mkey=>$kval)
						{
							if($buffer[$kval])
							{
								$custom_meta[$mkey] = $buffer[$kval];	
							}
						}
						
						$post_image = array();
						if($post_image_arr)
						{
							for($pm=0;$pm<count($post_image_arr);$pm++)
							{
								if(trim($buffer[$post_image_arr[$pm]]))
								{
									$post_image[] = trim($buffer[$post_image_arr[$pm]]);
								}
							}
						}
							$row_update_counter++;
							$my_post['ID'] = '';
							$last_postid = @wp_insert_post($my_post);
						
						
						if(!$my_post)
						{
							$last_postid = $my_post['ID'];
						}
						if($custom_meta)
						{
							foreach($custom_meta as $ckey=>$cval)
							{
								@update_post_meta($last_postid, $ckey, $cval);
							}
						}
						if($post_image){
							for($im=0;$im<count($post_image);$im++)
							{
								$menu_order = $im+1;
								$image_name_arr = explode('/',$post_image[$im]);
								$img_name = $image_name_arr[count($image_name_arr)-1];
								$img_name_arr = explode('.',$img_name);
								$post_img = array();
								$post_img['post_title'] = $img_name_arr[0];
								$post_img['post_status'] = 'attachment';
								$post_img['post_parent'] = $last_postid;
								$post_img['post_type'] = 'attachment';
								$post_img['post_mime_type'] = 'image/jpeg';
								$post_img['menu_order'] = $menu_order;
								$last_postimage_id = @wp_insert_post( $post_img );
								@update_post_meta($last_postimage_id, '_wp_attached_file', $wp_upload_dir_sub_dir.'/'.$post_image[$im]);
											
								$post_attach_arr = array(
													"width"	=>	580,
													"height" =>	480,
													"hwstring_small"=> "height='150' width='150'",
													"file"	=> $post_image[$m],
													);
													
								@wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
							}
						}
						}
										}
									$rowcount++;
									}
									@unlink($csv_target_path);
									$form_url = site_url().'/wp-admin/admin.php';
									echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
									echo '<input type="hidden" name="page" value="export" >';
									echo '<input type="hidden" name="msg" value="success" >';
									echo '<input type="hidden" name="rowcount" value="'.$row_update_counter.'" >';
									echo '</form>';
									echo '<script>document.error_form_redirect.submit();</script>';
									exit;
								}
								else
								{
									$form_url = site_url().'/wp-admin/admin.php';
									echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
									echo '<input type="hidden" name="page" value="export" >';
									echo '<input type="hidden" name="uemsg" value="nomove" >';
									echo '</form>';
									echo '<script>document.error_form_redirect.submit();</script>';
									exit;
								}
							}else
							{
								$form_url = site_url().'/wp-admin/admin.php';
								echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
								echo '<input type="hidden" name="page" value="export" >';
								echo '<input type="hidden" name="uemsg" value="csvonly" >';
								echo '</form>';
								echo '<script>document.error_form_redirect.submit();</script>';
								exit;
							}
						}else
	{
		$form_url = site_url().'/wp-admin/admin.php';
		echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
		echo '<input type="hidden" name="page" value="export" >';
		echo '<input type="hidden" name="uemsg" value="wrongfile" >';
		echo '</form>';
		echo '<script>document.error_form_redirect.submit();</script>';
		exit;
	}
		}elseif($_POST['act']=='update')
		{
			if($_FILES['bulk_upload_csv']['name']!='' && $_FILES['bulk_upload_csv']['error']=='0')
			{
				$row_insert_counter = 0;
				$row_update_counter = 0;
				$filename = $_FILES['bulk_upload_csv']['name'];
				$filenamearr = explode('.',$filename);
				$extensionarr = array('csv','CSV');
				if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
				{
					$upload_dir = wp_upload_dir();
					$basedir = $upload_dir['basedir'];
					$baseurl = $upload_dir['baseurl'];
					$destination_path = $basedir.PLUGIN_SLASH."csv";
					if (!file_exists($destination_path))
					{
						mkdir($destination_path, 0777);				
					}
					$target_path = $destination_path .PLUGIN_SLASH. $filename;
					$csv_target_path = $target_path;
					if(@move_uploaded_file($_FILES['bulk_upload_csv']['tmp_name'], $target_path)) 
					{
						$fd = fopen ($target_path, "rt");
						$customKeyarray = array();
						$post_custom_arr = array();
						while (!feof ($fd))
						{
							$buffer = fgetcsv($fd, 4096);
							if($rowcount == 0)
							{
								$user_info = $wpdb->get_results("select ID,user_login from $wpdb->users");
								foreach($user_info as $user_info_obj)
								{
									$user_info_array[$user_info_obj->user_login]=$user_info_obj->ID;
								}
								$post_data_key = array();
								for($k=0;$k<count($buffer);$k++)
								{
									
									$customKeyarray[$k] = trim($buffer[$k]);
			
			if($customKeyarray[$k]=='ID'){
			$post_data_key[$k]='ID';
			$ID = $k;
			}else
			if($customKeyarray[$k]=='post_title'){
			$post_data_key[$k]='post_title';
			$post_title=$k;
			}else
			if($customKeyarray[$k]=='post_content'){
			$post_data_key[$k]='post_content';
			}else
			if($customKeyarray[$k]=='category'){
			$post_data_key[$k]='category';
			}else
			if($customKeyarray[$k]=='post_tag'){
			$post_data_key[$k]='post_tag';
			}else
			if($customKeyarray[$k]=='post_author'){
			$post_data_key[$k]='post_author';
			}else
			if($customKeyarray[$k]=='post_status'){
			$post_data_key[$k]='post_status';
			}else
			if($customKeyarray[$k]=='comment_status'){
			$post_data_key[$k]='comment_status';
			}else
			{
				$post_data_key[$k]=$customKeyarray[$k];
				$post_custom_arr[$customKeyarray[$k]] = $k; 
			}
			
			$post_image_arr = array();
			if(array_keys($customKeyarray,'IMAGE')){
			$post_info_arr = array_keys($customKeyarray,'IMAGE');
			$post_image_arr[]   = $post_info_arr[0];
			}
			
			if(trim($buffer[$ID])!='' || trim($buffer[$post_title])!=''){ 
			}else
			{

			$form_url = site_url('/wp-admin/admin.php');
			echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
			echo '<input type="hidden" name="page" value="export" >';
			echo '<input type="hidden" name="emsg" value="id_title" >';
			echo '</form>';
			echo '<script>document.error_form_redirect.submit();</script>';
			exit;
			}
								}
							}else
							{
			$my_post = array();
			$id_val = array_keys($post_data_key,'ID');
			$post_title_val = array_keys($post_data_key,'post_title');
			$post_content_val = array_keys($post_data_key,'post_content');
			$post_excerpt_val = array_keys($post_data_key,'post_excerpt');
			$post_status_val = array_keys($post_data_key,'post_status');
			$category_val = array_keys($post_data_key,'category');
			$post_tag_val = array_keys($post_data_key,'post_tag');
			$comment_status_val = array_keys($post_data_key,'comment_status');
			$post_author_val = array_keys($post_data_key,'post_author');
			
			$ID = trim($buffer[$id_val[0]]);
			$post_title = trim($buffer[$post_title_val[0]]);
			$post_content = trim($buffer[$post_content_val[0]]);
			$post_excerpt = trim($buffer[$post_excerpt_val[0]]);
			$category = trim($buffer[$category_val[0]]);
			$post_tag = trim($buffer[$post_tag_val[0]]);
			if($user_info_array)
			{
				$post_author = $user_info_array[trim($buffer[$post_author_val[0]])];
			}
			$post_status = trim($buffer[$post_status_val[0]]);
			$comment_status = trim($buffer[$comment_status_val[0]]);
			if($ID!='' || $post_title!=''){
			if($post_content){
				$my_post['post_content'] = $post_content;
			}
			if($post_excerpt){
				$my_post['post_excerpt'] = $post_excerpt;
			}
			if($category){
				$category_id=array();
				$category_arr =  explode(',',$category);
				for($ic=0;$ic<count($category_arr);$ic++)
				{
					if(trim($category_arr[$ic]))
					{
						$catname=trim($category_arr[$ic]);
						global $wpdb;
						$catid = $wpdb->get_var("select t.term_id from $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where t.name like \"$catname\" and tt.taxonomy='category'");
						if($catid){			
						}else
						{
							@wp_insert_term( $category_arr[$ic], 'category');
						}
						$category_id[] = get_cat_ID($catname);
					}
				}
			$my_post['post_category'] = $category_id;
			}
			if($post_status){
			$my_post['post_status'] = $post_status;
			}
			if($post_title){$my_post['post_title'] = $post_title;}
			if($post_tag){
			$my_post['tags_input'] =  explode(',',$post_tag);
			}
			if($comment_status){
			$my_post['comment_status'] = $comment_status;
			}
			if($post_author){
			$my_post['post_author'] = $post_author;
			}
			
			if($ID){
				$my_post['ID'] = $ID;
			}elseif($post_title)
			{
				$ptitle = $post_title;
				$pid = $wpdb->get_var("select ID from $wpdb->posts where post_title like \"$ptitle\" and post_status in ('publish','draft')");
				$my_post['ID'] = $pid;
			}
			
			$custom_meta = array();
			foreach($post_custom_arr as $mkey=>$kval)
			{
				if($buffer[$kval])
				{
					$custom_meta[$mkey] = $buffer[$kval];	
				}
			}
			
			$post_image = array();
			if($post_image_arr)
			{
				for($pm=0;$pm<count($post_image_arr);$pm++)
				{
					$post_image[] = trim($buffer[$post_image_arr[$pm]]);
				}
			}
			//if($wpdb->get_var("select ID from $wpdb->posts where ID=\"".$my_post['ID']."\" and post_status in ('publish','draft')"))
			//{
				$last_postid = @wp_update_post($my_post);
				$row_update_counter++;
			//}else
			//{
			//	$row_insert_counter++;
			//	$my_post['ID'] = '';
			//	$last_postid = @wp_insert_post($my_post);
			//}
			
			if(!$my_post)
			{
				$last_postid = $my_post['ID'];
			}
			if($custom_meta)
			{
				foreach($custom_meta as $ckey=>$cval)
				{
					@update_post_meta($last_postid, $ckey, $cval);
				}
			}
			if($post_image){
				for($im=0;$im<count($post_image);$im++)
				{
					$menu_order = $im+1;
					$image_name_arr = explode('/',$post_image[$im]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = @wp_insert_post( $post_img );
					@update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$im]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										);
					@wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
			}
							}
						$rowcount++;
						}
						echo "<br><p class=\"updated below-h2\"><br>".__('CSV uploaded successfully.','vaj');
						echo "<br><br>".sprintf(__('<b>%s records</b> updated successfully.','vaj'),$row_update_counter)."</b><br><br></p>";			
						@unlink($csv_target_path);
					}
					else
					{
						$form_url = site_url().'/wp-admin/admin.php';
						echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
						echo '<input type="hidden" name="page" value="export" >';
						echo '<input type="hidden" name="emsg" value="nomove" >';
						echo '</form>';
						echo '<script>document.error_form_redirect.submit();</script>';
						exit;
					}
				}else
				{
					$form_url = site_url().'/wp-admin/admin.php';
					echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
					echo '<input type="hidden" name="page" value="export" >';
					echo '<input type="hidden" name="emsg" value="csvonly" >';
					echo '</form>';
					echo '<script>document.error_form_redirect.submit();</script>';
					exit;
				}
			}else
			{
				$form_url = site_url().'/wp-admin/admin.php';
				echo '<form method="get" action="'.$form_url.'" name="error_form_redirect">';
				echo '<input type="hidden" name="page" value="export" >';
				echo '<input type="hidden" name="emsg" value="wrongfile" >';
				echo '</form>';
				echo '<script>document.error_form_redirect.submit();</script>';
				exit;
				
			}
		}	
	}
	?>
	<div id="wrapper">
	 
	 <div class="titlebg">
		<span class="head i_mange_coupon"><h1><?php _e('WP Correct','vaj');?></h1></span>  
		
	 </div> <!-- sub heading -->
	 <div id="page" >
	
	<style>
	h2 { color:#464646;font-family:Georgia,"Times New Roman","Bitstream Charter",Times,serif;
	font-size:20px;
	font-size-adjust:none;
	font-stretch:normal;
	font-style:italic;
	font-variant:normal;
	font-weight:normal;
	line-height:35px;
	margin:0;
	padding:14px 15px 3px 0;
	text-shadow:0 1px 0 #FFFFFF;  }
	.emessage{
	background-color:#F38D8D;
	border:1px solid #FF0000;
	padding:5px;
	}
	.widefat { width:80%;}
	.errormsg{color:#FF0000; padding:7px 5px; border:solid 1px #D83848; font-weight:bold; background-color:#FCCFD7;}
	</style>
	
	<?php
	if(!empty($_REQUEST['emsg']) && $_REQUEST['emsg']=='csvonly')
	{
	echo '<p class="errormsg">'.__('Please select "csv" file only.','vaj').'</p>';
	}elseif(!empty($_REQUEST['emsg']) && $_REQUEST['emsg']=='csvonly')
	{
	echo '<p class="errormsg">'.__('Please check "wp-content/uploads" folder permission. It should be 0777.','vaj').'</p>';
	}elseif(!empty($_REQUEST['emsg']) && $_REQUEST['emsg']=='id_title')
	{
	echo '<p class="errormsg">'.__('Please make sure either "ID" or "PRODUCT_NAME" column is in the CSV file, other wise you cannot do update.','vaj').'</p>';
	}elseif(!empty($_REQUEST['emsg']) && $_REQUEST['emsg']=='wrongfile')
	{
	echo '<p class="errormsg">'.__('The uploaded file is wrong or zero file size.','vaj').'</p>';
	}else if(!empty($_REQUEST['uemsg']) && $_REQUEST['uemsg']=='csvonly')
	{
	echo '<p class="errormsg">'.__('Please select "csv" file only.','vaj').'</p>';
	}elseif(!empty($_REQUEST['uemsg']) && $_REQUEST['uemsg']=='csvonly')
	{
	echo '<p class="errormsg">'.__('Please check "wp-content/uploads" folder permission. It should be 0777.','vaj').'</p>';
	}elseif(!empty($_REQUEST['uemsg']) && $_REQUEST['uemsg']=='id_title')
	{
	echo '<p class="errormsg">'.__('Please make sure "PRODUCT_NAME" column is in the CSV file, other wise you cannot insert the information.','vaj').'</p>';
	}elseif(!empty($_REQUEST['uemsg']) && $_REQUEST['uemsg']=='wrongfile')
	{
	echo '<p class="errormsg">'.__('Wrong file or file type you uploading. Please check the file and try again.','vaj').'</p>';
	}
	elseif(!empty($_REQUEST['uemsg']) && $_REQUEST['uemsg']=='nodata')
	{
	echo '<p class="errormsg">'.__('Sorry, no data to export.','vaj').'</p>';
	}
	
	if(!empty($_REQUEST['msg']) && $_REQUEST['msg']=='success')
	{
		$wp_upload_dir = wp_upload_dir();
		$path=$wp_upload_dir['path'].'/';
		$row_update_counter = $_REQUEST['rowcount'];
		echo "<br><p class=\"updated below-h2\"><br>".__('CSV uploaded successfully.','vaj')."<br><br>".sprintf(__('<b>%s records</b> inserted.','vaj'),$row_update_counter)."<br><br>".sprintf(__('You should upload post images to <b>%s </b>folder, if any.'),$path)."<br><br></p>";
	}
	?>
	<form action="<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=export" method="post" name="bukl_upload_frm" enctype="multipart/form-data">
	<input type="hidden" name="act" value="upload" />
	  <h2><?php _e('Bulk Upload','vaj'); ?></h2>
	  <?php if(!empty($_REQUEST['msg']) && $_REQUEST['msg']=='exist'){?>
	  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
		<p><?php _e('Updated successully.','vaj'); ?></p>
	  </div>
	  <?php }?>
	  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
		<tr>
		  <td width="20%"><?php _e('Select CSV file','vaj'); ?></td>
		  <td width="80%">:
			<input type="file" name="bulk_upload_csv" id="bulk_upload_csv1"></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		<td><input type="submit" name="submit" value="<?php _e('Submit','vaj'); ?>" onClick="return check_upload_frm();" class="button-secondary action" >    </tr>
		<tr>
		  <td>&nbsp;</td>
		<td>    </tr>
		<tr>
		  <td colspan="2"><p style="color:#990000;"><u><?php _e('Note','vaj');?></u>:- <?php _e('Please make sure "post_title" column should included in the CSV file otherwise system will never accept the data. New data will insert every time as per the file you are uploading.','vaj');?></p></td>
		</tr>
		 <tr>
		 <?php global $plugin_foldername;?>
		  <td colspan="2"><b><a href="<?php echo WP_PLUGIN_URL.'/'.$plugin_foldername; ?>/sample.csv"><?php _e('Click to Download Sample CSV file','vaj');?></a></b></td>
		</tr>
	  </table>
	</form>
	<script>
	function check_upload_frm()
	{
		if(document.getElementById('bulk_upload_csv1').value == '')
		{
			alert("<?php _e('Please select csv file to Insert Data','vaj');?>");
			return false;
		}
		return true;
	}
	</script>
	
	<br /><br /><br />
	<form action="<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=export" method="post" name="bukl_upload_frm" enctype="multipart/form-data">
	<input type="hidden" name="act" value="update" />
	  <h2><?php _e('Bulk Update','vaj'); ?></h2>
	  <?php if(!empty($_REQUEST['msg']) && $_REQUEST['msg']=='exist'){?>
	  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
		<p><?php _e('Updated successully.','vaj'); ?></p>
	  </div>
	  <?php }?>
	  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
		<tr>
		  <td width="20%"><?php _e('Select CSV file','vaj'); ?></td>
		  <td width="80%">:
			<input type="file" name="bulk_upload_csv" id="bulk_upload_csv"></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		<td><input type="submit" name="submit" value="<?php _e('Submit','vaj'); ?>" onClick="return check_update_frm();" class="button-secondary action" >    </tr>
		<tr>
		  <td>&nbsp;</td>
		<td>    </tr>
		 <tr>
		  <td colspan="2"><p style="color:#990000"><u><?php _e('Note','vaj');?></u>:- <?php _e('Please make sure either "ID" or "post_title" column should included in the CSV file, your are going to update the data. Data will updated if either ID or post_title match','vaj');?></p></td>
		</tr>
	  </table>
	</form>
	<script>
	function check_update_frm()
	{
		if(document.getElementById('bulk_upload_csv').value == '')
		{
			alert("<?php _e('Please select csv file to Update','vaj');?>");
			return false;
		}
		return true;
	}
	</script>
	
	
	<br /><br /><br />
	<h2><?php _e('Download Complete Data Excel','vaj'); ?></h2>
	<?php if(!empty($_REQUEST['msg']) && $_REQUEST['msg']=='exist'){?>
	<div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
	<p><?php _e('Updated successully.','vaj'); ?></p>
	</div>
	<?php }?>
	<table width="50%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
	<tr><td colspan="2"><b><?php _e('You can download all posts information <u>Excel format</u> by clicking "Get Posts Backup Data". Get posts data excel and safe it as backup for future use in the case of any mistake or data loss.','vaj');?></b></td></tr>
	<tr>
	<tr>
	  <td>&nbsp;</td>
	<td>    </tr>
	<tr>
	  <td colspan="2"><a href="<?php echo site_url('/wp-admin/tools.php?page=export&backup=posts');?>"><input type="submit" class="button-secondary action" value="<?php _e('Get Posts Backup Data Excel','vaj'); ?>" name="submit">
	 </a>    </td>
	</tr>
	</table>
	</div> <!-- page #end -->
	 </div>   <!-- wrapper #end -->
	 <?php
}
}
?>