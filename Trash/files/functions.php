<?php 
include("config.php");

function getstates()
{
    global $link;
    $sql="SELECT * FROM tbl_state_master";
	$rs1=$link->query($sql);
	$states=array();
	while($rs2 =$rs1->fetch_array())
	{
        $states[]=$rs2['sc_sm_id'];
        $states[]=$rs2['sc_sm_name'];
	}
	return $states;
}

function getEmailTemplateByKey($key)
{
    global $link;
    $select = $link->query("SELECT * FROM tbl_email_template WHERE email_key = '$key'");	
	$result = $select->fetch_array();
	return $result;          
}
        
function getSupportEmail()
{
	return 'support@societyconnect.in';
}
        
function CreateEmailQueue($from, $from_name, $to, $to_name, $subject, $message)
{
    global $link;
    $message = $link->real_escape_string(($message));
    $data  = "INSERT INTO `tbl_email_queue`(`from`,`to`,`to_name`,`subject`,`message`,`from_name`,`flag`,`priority`,'module') VALUES('".$from."','".$to."','".$to_name."','".$subject."','".$message."','".$from_name."','In Queue','High','CONTACT');";
    $result = $link->query($data);
}

function register($formdata)
{		
    global $link;
    $adminemail = getSupportEmail();
    $q="INSERT INTO `tbl_tmp_new_society`(`fullname`,`society_name`,`city`,`email`,`contact`,`remark`) VALUES('".$formdata['name']."','".$formdata['apartment_name']."','".$formdata['city']."','".$formdata['email']."','".$formdata['contact_no']."','".$formdata['remark']."')";
    $result = $link->query($q);

    $emailrow = getEmailTemplateByKey('CONTACT_US');
                
	$from_name = 'Team SocietyConnect';
    $from = getSupportEmail();
    $to = $formdata['email'];
    $to_name = $formdata['name'];
	$subject = $emailrow['subject'];
    $message = $emailrow['message'];
    $message = str_replace("[NAME]",$formdata['name'],$message);
    $message = str_replace("[DETAILS]",'Contact #'.$formdata['contact_no'].'<br/>Email: '.$to.'<br/>',$message);
    
    CreateEmailQueue($from, $from_name, $to, $to_name, $subject, $message);

    $emailrow1 = getEmailTemplateByKey('NEW_ENQUIRY');
	$from_name1 = $formdata['name'];
    $from1 = 'noreply@societyconnect.in';
    $to1 = getSupportEmail();
    $to_name1 = 'Management SocietyConnect';
    $subject1 = $emailrow1['subject'];
    $message1 = $emailrow1['message'];
    $message1 = str_replace("[NAME]",$formdata['name'],$message1);
    $message1 = str_replace("[SOCIETY]",$formdata['apartment_name'],$message1);
    $message1 = str_replace("[DETAILS]",'Contact #'.$formdata['contact_no'].'<br/>Email: '.$to.'<br/>',$message1);
    
    CreateEmailQueue($from1, $from_name1, $to1, $to_name1, $subject1, $message1);
    /********* Send SMS *************/          
                
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://smshorizon.co.in/api/sendsms.php");
    curl_setopt($ch, CURLOPT_POST, 1);// set post data to true
    curl_setopt($ch, CURLOPT_POSTFIELDS,"user=".SMS_USER."&apikey=".SMS_KEY."&mobile=".$formdata['contact_no']."&message=Thank you for contacting us. We will get in touch with you ASAP. Regards, Team SocietyConnect.&senderid=".SMS_SENDER_ID."&type=".SMS_TYPE);   // post data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close ($ch);
}

function getResCount()
{
    global $link;
    $select = $link->query("SELECT ROUND(COUNT(*)) as res_count FROM tbl_residents");
	$result = $select->fetch_array();
    $select1 = $link->query("SELECT ROUND(COUNT(*)) as res_count FROM tbl_resident_members");
	$result1 = $select1->fetch_array();

    if ($result[0]+$result1[0]>999999999999)
        return (round($result[0]+$result1[0],-10)/1000000000000).' (Tr)';
    elseif ($result[0]+$result1[0]>999999999)
        return (round($result[0]+$result1[0],-7)/1000000000).' (Bn)';
    elseif ($result[0]+$result1[0]>999999)
        return (round($result[0]+$result1[0],-5)/1000000).' (Mn)';
    else
        return number_format($result[0]+$result1[0],0);
}
function getBillCount()
{
    global $link;
    $select = $link->query("SELECT ROUND(SUM(charged_amount)) AS bill_count FROM pg_payment_log WHERE status='success'");	
	$result = $select->fetch_array();
	if ($result[0]>999999999999)
		return (round($result[0],-10)/1000000000000).' (Tr)';
	elseif ($result[0]>999999999)
		return (round($result[0],-7)/1000000000).' (Bn)';
	elseif ($result[0]>999999)
		return (round($result[0],-5)/1000000).' (Mn)';
	else
		return number_format($result[0],0);
}
function getTicketCount()
{
    global $link;
    $select = $link->query("SELECT COUNT(*) as ticket_count FROM tbl_help_desk");	
	$result = $select->fetch_array();
    if ($result[0]>999999999999)
        return (round($result[0],-10)/1000000000000).' (Tr)';
    elseif ($result[0]>999999999)
        return (round($result[0],-7)/1000000000).' (Bn)';
    elseif ($result[0]>999999)
        return (round($result[0],-5)/1000000).' (Mn)';
    else
        return number_format($result[0],0);
}
function getNoticeCount()
{
    global $link;
    $select = $link->query("SELECT COUNT(notice_id) AS notice_count FROM tbl_notice");	
	$result = $select->fetch_array();
	if ($result[0]>999999999999)
        return (round($result[0],-10)/1000000000000).' (Tr)';
    elseif ($result[0]>999999999)
        return (round($result[0],-7)/1000000000).' (Bn)';
    elseif ($result[0]>999999)
        return (round($result[0],-5)/1000000).' (Mn)';
    else
        return number_format($result[0],0);
}
function getAppDownloadCount()
{
    global $link;
    $select = $link->query("SELECT ROUND(COUNT(sc_user_id)) as app_count FROM tbl_users where sc_otp_1 IS NOT NULL");
    return $select->fetch_array();
}
?>