<?php
if (// Check if all fields are there.
    isset($_POST['nickname']) &&
    isset($_POST['email']) &&
    isset($_POST['subject']) &&
    isset($_POST['message']) &&

    // Check if the required fields have text inside.
    !$_POST['nickname'] == '' &&
    !$_POST['email'] == '' &&
    !$_POST['subject'] == '' &&
    !$_POST['message'] == '' &&

    // Check if we know which page to return to.
    isset($_GET['return']))
{
    // Create array with mail content.
    $info = array(
        'nickname' => $_POST['nickname'],
        'email' => $_POST['email'],
        'subject' => $_POST['subject'],
        'message' => $_POST['message']
    );

    // Escape everything.
    $info['nickname'] = htmlspecialchars($info['nickname'], ENT_QUOTES, 'UTF-8');
    $info['email'] = htmlspecialchars($info['email'], ENT_QUOTES, 'UTF-8');
    $info['subject'] = htmlspecialchars($info['subject'], ENT_QUOTES, 'UTF-8');
    $info['message'] = htmlspecialchars($info['message'], ENT_QUOTES, 'UTF-8');

    $info['nickname'] = htmlentities($info['nickname'], ENT_QUOTES, 'UTF-8');
    $info['email'] = htmlentities($info['email'], ENT_QUOTES, 'UTF-8');
    $info['subject'] = htmlentities($info['subject'], ENT_QUOTES, 'UTF-8');
    $info['message'] = htmlentities($info['message'], ENT_QUOTES, 'UTF-8');

    // Check what form we came from and then send the mail.
    switch ($_GET['return'])
    {
        case "feedback":
            if (SendEMail('feedback@ostentv.dk', $info)) {
                header('Location: /?view=' . $_GET['return'] . '&success=1');
            } else {
                LogError('0x0001:0003');
                header('Location: /?view=' . $_GET['return'] . '&success=0&error_code=0x0001:0003');
            }
            break;
        ;
        case "contact":
            if (SendEMail('kontakt@ostentv.dk', $info)) {
                header('Location: /?view=' . $_GET['return'] . '&success=1');
            } else {
                LogError('0x0001:0003');
                header('Location: /?view=' . $_GET['return'] . '&success=0&error_code=0x0001:0003');
            }
            break;
        ;
    	default:
            LogError('0x0001:0000');
            header('Location: /?error_code=0x0001:0000');
            break;
        ;
    }
} else {
    // Return an error if some fields were empty.
    if (isset($_GET['return'])) {
        LogError('0x0001:0001');
        header('Location: /?view=' . $_GET['return'] . '&success=0&error_code=0x0001:0001');
    } else {
        LogError('0x0001:0002');
        header('Location: /?error_code=0x0001:0002');
    }
}
?>