<?
///
/// Initialize variables
///
//$sample_url='index.php?view=distributors';
$sample_view='distributors';
$detail_view='distributor';
$detail_url='index.php?view=distributor&';

//$host_DB='.ua';
//$user_DB='cc_user';
//$pass_DB='cc_password';
$db_DB='Distributors';
$table='List';

//$path='/etc/osis/asterisk/devices/phones/';
//$path='configs/'; /// !!! FOR TESTS !!! ///
//$file_phones='conf_phones';
//$file_conf_phone='conf_';
//$field_phone='mac';
//$file_extensions='conf_extensions';
//$file_conf_extension='conf_extension_';
//$field_extension='extension';

//$template_path='/etc/osis/asterisk/devices/phones/';
//$template_path=''; /// !!! FOR TESTS !!! ///
//$template_file='phone_template';

$fields_sample_array = array('name', 'login', 'file_type', 'update_date'); // Fields that shown in bulk view (List all stores)
$main_field='name'; // == $column_names[0]. This is parameter for POST request

/// Variables for MAC Validation
// http://www.usermadetutorials.com/2010/07/php-validate-mac-address-using-regex/
//$validation_pattern = '/^[a-f0-9]{12}$/i'; // 12 symbols, no ':', '.', '-'.  
//$validation_string_length='12';

/// Error Messages
$error_add_message='Error: This Distributor also present in DB, Please enter another Distributor Name, or delete this Distributor.<br>';
//$error_validation='Please Enter Valid MAC Address.<br> 12 symbols, lower case, without any special character.';
$error_case_default='Please Load Page Correctly ( error:store.php -> switch (action) -> case default )';

?>
