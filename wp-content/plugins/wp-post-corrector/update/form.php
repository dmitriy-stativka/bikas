<br /><br /><br />
<form action="<?php echo get_option('siteurl')?>/wp-admin/admin.php?page=export" method="post" name="bukl_upload_frm" enctype="multipart/form-data">
<input type="hidden" name="act" value="update" />
  <h2><?php _e('Bulk Update'); ?></h2>
  <?php if($_REQUEST['msg']=='exist'){?>
  <div class="updated fade below-h2" id="message" style="background-color: rgb(255, 251, 204);" >
    <p><?php _e('Updated successully.'); ?></p>
  </div>
  <?php }?>
  <table width="75%" cellpadding="3" cellspacing="3" class="widefat post fixed" >
    <tr>
      <td width="20%"><?php _e('Select CSV file'); ?></td>
      <td width="80%">:
        <input type="file" name="bulk_upload_csv" id="bulk_upload_csv"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    <td><input type="submit" name="submit" value="<?php _e('Submit'); ?>" onClick="return check_update_frm();" class="button-secondary action" >    </tr>
    <tr>
      <td>&nbsp;</td>
    <td>    </tr>
	 <tr>
      <td colspan="2"><p style="color:#FF0000"><u><?php _e('Note');?></u>:- <?php _e('Please make sure either "ID" or "post_title" column should included in the CSV file, your are going to update the data. Data will updated if either ID or post_title match');?></p></td>
    </tr>
  </table>
</form>
<script>
function check_update_frm()
{
	if(document.getElementById('bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to Update');?>");
		return false;
	}
	return true;
}
</script>