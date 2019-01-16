<?php

switch ($_GET['action'])
{
    case 'Register':
        RegisterUser();
        break;
    ;
    case 'logIn':
        LogInUser();
        break;
    ;
    case 'LogOut':
        LogOutUser();
        break;
    ;
    case 'UpdateData':
        UpdateUserData();
        break;
    ;
	default:
        break;
    ;
}

function RegisterUser() {
    if (
        isset($_POST['email']) &&
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['confirm_password']) &&
        isset($_POST['activation_code']) &&

        ($_POST['email'] != '') &&
        ($_POST['username'] != '') &&
        ($_POST['password'] != '') &&
        ($_POST['confirm_password'] != '') &&
        ($_POST['activation_code'] != '')
    ) {
        if (IsActivationCodeAvailable($_POST['activation_code'])) {
            if (IsUsernameAvailable($_POST['username'])) {
                if (IsEMailAvailable($_POST['email']))
                {
                    if ($_POST['password'] == $_POST['confirm_password'])
                    {
                        global $dbc;

                        $email =  mysqli_real_escape_string($dbc, $_POST['email']);
                        $username =  mysqli_real_escape_string($dbc, $_POST['username']);

                        // Hash password
                        $password = HashPassword($_POST['password']);

                        if ($password) {
                            $default_role = 0;
                            $reset_hash = '';
                            $email_verified = 0;
                            $suspended = 0;

                            // Insert into database.
                            $query = 'INSERT INTO accounts (ID, username, password, email, email_verified, global_role, reset_hash, creation_date, suspended) VALUES (NULL, "'.$username.'", "'.$password.'", "'.$email.'", "'.$email_verified.'", "'.$default_role.'", "'.$reset_hash.'", "'.time().'", "'.$suspended.'")';
                            $response = mysqli_query($dbc, $query);

                            if ($response) {
                                $created_account_id = mysqli_insert_id($dbc);
                                if (IsAccountUsernameUnique($created_account_id)) {
                                    UseActivationCode($_POST['activation_code']);
                                    LogInUser();
                                } else {
                                    // Username is taken.
                                    DeleteAccount($created_account_id);
                                    header('Location: /?view=' . $_GET['return'] . '&register_error=Someone took your username while I was creating your account.#RegisterModal');
                                    exit();
                                }
                            } else {
                                // Failed to register user.
                                LogError('0x0004:0003');
                                header('Location: /?error_code=0x0004:0003');
                            }
                        } else {
                            // Failed to hash password.

                        }
                    } else {
                        // Passwords don't match.
                        header('Location: /?view=' . $_GET['return'] . '&´register_error=Passwords don\'t match.#RegisterModal');
                        exit();
                    }
                } else {
                    // Email is taken.
                    header('Location: /?view=' . $_GET['return'] . '&register_error=E-Mail is already in use.#RegisterModal');
                    exit();
                }
            } else {
                // Username is taken.
                header('Location: /?view=' . $_GET['return'] . '&register_error=Username is not available.#RegisterModal');
                exit();
            }
        } else {
            // Activation code is invalid.
            header('Location: /?view=' . $_GET['return'] . '&register_error=Invalid activation code.#RegisterModal');
            exit();
        }
    } else {
        // Missing variables.
        LogError('0x0004:0000');
        header('Location: /?error_code=0x0004:0000');
        exit();
    }
}
function LogInUser() {
    if (
        isset($_POST['username']) &&
        isset($_POST['password']) &&

        ($_POST['username'] != '') &&
        ($_POST['password'] != '')
    ) {
        if (!IsUserLoginBlocked($_SERVER['REMOTE_ADDR'])) {

            $id = GetUserID($_POST['username']);

            if (VerifyUserPassword($id, $_POST['password'])) {
                 if (!IsUserSuspended($id)) {
                    global $dbc;

                    $query = 'SELECT ID, email, email_verified FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
                    $response = @mysqli_query($dbc, $query);
                    if ($response) {
                        $result = mysqli_fetch_assoc($response);

                        $_SESSION['user']['id'] = $result['ID'];
                        $_SESSION['user']['ip'] = $_SERVER['REMOTE_ADDR'];
                        $_SESSION['user']['last_active'] = time();

                        header('Location: /?view='. $_GET['return']);
                    } else {
                        LogError('0x0004:0002');
                        header('Location: /?error_code=0x0004:0002');
                        exit();
                    }
                } else {
                    // User suspended.
                    header('Location: /?view=' . $_GET['return'] . '&login_error=You account has been suspended.#LogInModal');
                    exit();
                }
            } else {
                // Wrong password.
                RegisterFailedLoginAttempt($_SERVER['REMOTE_ADDR']);
                if (IsUserLoginBlocked($_SERVER['REMOTE_ADDR'])) {
                    // Login blocked.
                    header('Location: /?view=' . $_GET['return'] . '&login_error=Login blocked.#LogInModal');
                    exit();
                } else {
                    // Wrong password, login not blocked.
                    header('Location: /?view=' . $_GET['return'] . '&login_error=Username or password incorrect.#LogInModal');
                    exit();
                }
            }
        } else {
            // Login blocked.
            header('Location: /?view=' . $_GET['return'] . '&login_error=Login blocked.#LogInModal');
            exit();
        }

    } else {
        LogError('0x0004:0001');
        header('Location: /?error_code=0x0004:0001');
        exit();
    }
}
function LogOutUser() {
    if (IsUserLoggedIn()) {
        session_unset();
        session_destroy();
        header('Location: /?view='. $_GET['return']);
    } else {
        // User not logged in.
        header('Location: /?view='. $_GET['return']);
    }
}
function UpdateUserData() {
    if (IsUserLoggedIn()) {
        if (!IsEmpty($_POST['current_password'])) {
            if (VerifyUserPassword($_SESSION['user']['id'], $_POST['current_password'])) {
                if (!IsEmpty($_POST['new_password'])) {
                    if ($_POST['new_password'] == $_POST['confirm_password']) {
                        if (!UpdateUserPassword($_SESSION['user']['id'], $_POST['new_password'])) {
                            // Failed to update password.
                            header('Location: /?view=profile&update_error=Failed to update password.');
                            exit();
                        }
                    } else {
                        // Passwords don't match.
                        header('Location: /?view=profile&update_error=Passwords don\'t match up!');
                        exit();
                    }
                }
                if (!IsEmpty($_POST['email'])) {
                    if ($_POST['email'] != GetUserEMail($_SESSION['user']['id'])) {
                        if (IsEMailAvailable($_POST['email'])) {
                            if (!UpdateUserEMail($_SESSION['user']['id'], $_POST['email'])) {
                                // Failed to update E-Mail.
                                header('Location: /?view=profile&update_error=Failed to update E-Mail.');
                                exit();
                            }
                        } else {
                            // E-Mail already in use.
                            header('Location: /?view=profile&update_error=E-Mail already in use.');
                            exit();
                        }
                    }
                }
                // Return to profile when tasks have been completed.
                header('Location: /?view=profile');
            } else {
                // Wrong password.
                header('Location: /?view=profile&update_error=Wrong password.');
                exit();
            }
        } elseif (IsUserInRole($_SESSION['user']['id'], 'administrator', true) && $_SESSION['user']['id'] != $_GET['id']) {
            if (GetUserGlobalRole($_SESSION['user']['id']) > GetUserGlobalRole($_GET['id'])) {
                if (!IsEmpty($_POST['new_password'])) {
                    if ($_POST['new_password'] == $_POST['confirm_password']) {
                        if (!UpdateUserPassword($_GET['id'], $_POST['new_password'])) {
                            // Failed to update password.
                            header('Location: /?view=profile&id='.$_GET['id'].'&update_error=Failed to update password.');
                            exit();
                        }
                    } else {
                        // Passwords don't match.
                        header('Location: /?view=profile&id='.$_GET['id'].'&update_error=Passwords don\'t match up!');
                        exit();
                    }
                }
                if (!IsEmpty($_POST['email'])) {
                    if ($_POST['email'] != GetUserEMail($_GET['id'])) {
                        if (IsEMailAvailable($_POST['email'])) {
                            if (!UpdateUserEMail($_GET['id'], $_POST['email'])) {
                                // Failed to update E-Mail.
                                header('Location: /?view=profile&id='.$_GET['id'].'&update_error=Failed to update E-Mail.');
                                exit();
                            }
                        } else {
                            // E-Mail already in use.
                            header('Location: /?view=profile&id='.$_GET['id'].'&update_error=E-Mail already in use.');
                            exit();
                        }
                    }
                }
                // Return to profile when tasks have been completed.
                header('Location: /?view=profile&id='. $_GET['id']);
            } else {
                // The user you're trying to edit has more power than you.
                header('Location: /?view=profile&update_error=You can\'t edit this user.&id=' . $_GET['id']);
                exit();
            }
        } else {
            // No password entered.
            header('Location: /?view=profile&update_error=Please enter your current password.');
            exit();
        }
    } else {
        // Not logged in.
        header('Location: /?view=profile');
        exit();
    }
}

?>