<?php
defined('_VALID') or die('Restricted Access!');

Auth::checkAdmin();

$email      = array();
$EID        = ( isset($_GET['EID']) && $_GET['EID'] != '' ) ? trim($_GET['EID']) : NULL;
if ( $EID ) {
    if ( isset($_POST['edit_email']) ) {
        $subject    = trim($_POST['subject']);
        $content    = trim($_POST['content']);
        $comment    = trim($_POST['comment']);
        $path       = trim($_POST['email_path']);
        
        if ( $subject == '' )
            $errors[] = 'Email subject field cannot be blank!';
        elseif ( $content == '' )
            $errors[] = 'Email content field cannot be blank!';
        
        if ( !$errors ) {
            $sql = "UPDATE emailinfo SET email_subject = '" .mysql_real_escape_string($subject). "',
                                         comment = '" .mysql_real_escape_string($comment). "'
                    WHERE email_id = '" .mysql_real_escape_string($EID). "' LIMIT 1";
            $conn->execute($sql);

            $handle = fopen($config['BASE_DIR']. '/templates/' .$path, 'w');
            if ( $handle ) {
                fwrite($handle, $content);
                fclose($handle);
                $messages[] = 'Email was successfuly updated!';
            } else
                $errors[] = 'Failed to write email! Please make sure \'' .$config['BASE_DIR']. '/templates/' .$path. '\' has the right permissions!';
        }
    }

    $sql                    = "SELECT * FROM emailinfo WHERE email_id = '" .mysql_real_escape_string($EID). "' LIMIT 1";
    $rs                     = $conn->execute($sql);
    $email                  = $rs->getrows();
    $email['0']['details']  = @file_get_contents($config['BASE_DIR']. '/templates/' .$email['0']['email_path']);
    if ( !$email['0']['details'] )
        $errors[] = 'Could not real email file! Please make sure \'' .$config['BASE_DIR']. '/templates/' .$email['0']['email_path']. '\' has the right permissions!';
} else {
    $errors[] = 'Email id is not set!';
}

$smarty->assign('email', $email);
?>
