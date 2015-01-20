<?php
//error_reporting(-1);
//echo "test";
include("../config/data.config.php");
include("$LIB_DIR/functions.library.php");
include("$LIB_DIR/class.database.php");
include("$LIB_DIR/data.constant.php");
include("$LIB_DIR/msgs.inc.php");
include("$LIB_DIR/class.pagingClass.php");
$db=new DbConnect($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, $DB_REPORT_ERROR, $DB_PERSISTENT_CONN);
$db->open() or die($db->error());
$tech_id = $_REQUEST['tech_id']; // technician id fk
$job_id = $_REQUEST['job_id']; // job id fk
$step = $_REQUEST['step'];

if($tech_id != '' && $job_id !='' && $step == 'upload'){
//echo "test";
$base = $_REQUEST['image'];
if(!$base) {
$message= "Image not found";
$errorcode = "IMNF-12002";
header('Content-type: application/json');
echo json_encode(errVar($message,$errorcode,$db));
exit();
	}
else		   
// Insert image data in phto board by saurabh 
{
$time = time();
$fileName = 'img_'.$time.'.'.'jpg';
$insertimagedata = array(
'job_id'=>$job_id,
'tech_id'=>$tech_id,
'photoImage'=>$fileName,
'status'=>1,
'createdOn'=>date('Y-m-d h:i:s',time())
);
$status = 1;
if(dbRowInsert(TBL_PHOTO_JOB,$insertimagedata)) {
$img_upload_path = $JOB_URL;
$photo = $img_upload_path;
$imgFilename = addBase64img($base,$photo);
$message="Job Image uploaded Successfully";
$errorcode = "JIM-12001";
header('Content-type: application/json');
 echo json_encode(succVar($message,$errorcode,$db));
exit;
}
else {
$message= "Image Not Uploaded";	
$errorcode = "IMN-12002";
header('Content-type: application/json');
echo json_encode(errVar($message,$errorcode,$db));
exit();
}
}
}
else {
$message= "Web service error!";	
$errorcode = "WSE-1001";
header('Content-type: application/json');
echo json_encode(errVar($message,$errorcode,$db)); 
exit();
}	

?>
