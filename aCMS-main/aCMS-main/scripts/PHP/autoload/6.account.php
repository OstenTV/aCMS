<?php

// Check if the user is logged in.
if (IsUserLoggedIn()) {
    // Check if we need to log out the user.
    if (
        !UserExists($_SESSION['user']['id']) ||
        $_SESSION['user']['ip'] != $_SERVER['REMOTE_ADDR'] ||
        IsUserSuspended($_SESSION['user']['id']) ||
        (time() - $_SESSION['user']['last_active']) > 900
    ) {
        // Log out the user.
        header('Location: /?script=user&action=LogOut&return='. $_GET['view']);
    } else {
        // Login session is valid.
        $_SESSION['user']['last_active'] = time();
    }
}

function HashPassword(string $password) {
    $options = [
        'cost' => 15,
    ];

    $password = password_hash($password, PASSWORD_DEFAULT, $options);

    if ($password) {
        return $password;
    } else {
        return false;
    }
}
function IsUsernameAvailable(string $username) {
    global $dbc;

    $username = mysqli_real_escape_string($dbc, $username);

    $query = 'SELECT username FROM accounts WHERE username LIKE "' . $username . '"';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (is_null($result)) {
            return true;
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0000');
        echo Alert('error', 'No response from database.', '0x0003:0000');
        exit;
    }
}
function IsEMailAvailable(string $email) {
    global $dbc;

    $email = mysqli_real_escape_string($dbc, $email);

    $query = 'SELECT email FROM accounts WHERE email LIKE "' . $email . '"';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (is_null($result)) {
            return true;
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0001');
        echo Alert('error', 'No response from database.', '0x0003:0001');
        exit;
    }
}
function IsActivationCodeAvailable(string $activation_code) {
    global $dbc;

    $activation_code = mysqli_real_escape_string($dbc, $activation_code);

    $query = 'SELECT uses_left FROM activation_codes WHERE activation_code = "' . $activation_code . '"';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (is_null($result)) {
            return false;
        } else {
            $uses_left = $result['uses_left'];
            if ($uses_left > 0) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        LogError('0x0003:0002');
        echo Alert('error', 'No response from database.', '0x0003:0002');
        exit;
    }
}
function UseActivationCode(string $activation_code) {
    if (IsActivationCodeAvailable($activation_code)) {
        global $dbc;

        $activation_code = mysqli_real_escape_string($dbc, $activation_code);

        $query = 'SELECT uses_left FROM activation_codes WHERE activation_code = "' . $activation_code . '"';
        $response = @mysqli_query($dbc, $query);

        if ($response) {
            $result = mysqli_fetch_assoc($response);
            $uses_left = $result['uses_left'];
            $uses_left--;

            $query = 'UPDATE activation_codes SET uses_left = "'.$uses_left.'" WHERE activation_code = "'.$activation_code.'"';
            $stmt = @mysqli_prepare($dbc, $query);
            @mysqli_stmt_execute($stmt);

            return true;
        } else {
            LogError('0x0003:0003');
            echo Alert('error', 'No response from database.', '0x0003:0003');
            exit;
        }
    } else {
        return false;
    }
}
function VerifyUserPassword(int $id, string $password) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    if ($id) {
        $query = 'SELECT password FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
        $response = @mysqli_query($dbc, $query);

        if ($response) {
            $result = mysqli_fetch_assoc($response);

            if (!is_null($result)) {
                if (password_verify($password, $result['password'])) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } else {
            LogError('0x0003:0007');
            echo Alert('error', 'No response from database.', '0x0003:0007');
            exit;
        }
    } else {

        // Add some delay so that you can't see if the user exists or not.
        sleep(2.8);

        return false;
    }
}
function UpdateUserPassword(int $id, string $password) {
    global $dbc;

    $password = HashPassword($password);

    if ($password) {

        $id = mysqli_real_escape_string($dbc, $id);
        $id = str_replace('%', '\%', $id);
        $id = str_replace('_', '\_', $id);

        $query = 'UPDATE accounts SET password = "'.$password.'" WHERE ID = "'.$id.'"';
        $stmt = @mysqli_prepare($dbc, $query);
        @mysqli_stmt_execute($stmt);

        return true;
    } else {
        LogError('0x0003:0008');
        header('Location: /?error_code=0x0003:0008');
        exit;
    }
}
function UpdateUserEMail(int $id, string $email) {
    global $dbc;

    if (IsEMailLegal($email)) {

        $email = mysqli_real_escape_string($dbc, $email);
        $id = mysqli_real_escape_string($dbc, $id);
        $id = str_replace('%', '\%', $id);
        $id = str_replace('_', '\_', $id);

        $query = 'UPDATE accounts SET email = "'.$email.'" WHERE ID = "'.$id.'"';
        $stmt = @mysqli_prepare($dbc, $query);
        @mysqli_stmt_execute($stmt);

        return true;
    } else {
        return false;
    }
}
function IsUsernameLegal(string $username) {
    return true;
}
function IsEMailLegal(string $username) {
    return true;
}
function IsUserSuspended(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'SELECT suspended FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if ($result['suspended'] == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0004');
        echo Alert('error', 'No response from database.', '0x0003:0004');
        exit;
    }
}
function GetUserGlobalRole(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'SELECT global_role FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (!is_null($result)) {
            return $result['global_role'];
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0005');
        echo Alert('error', 'No response from database.', '0x0003:0005');
        exit;
    }
}
function GetUserEMail(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'SELECT email FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (!is_null($result)) {
            return $result['email'];
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0006');
        echo Alert('error', 'No response from database.', '0x0003:0006');
        exit;
    }
}
function IsUserLoggedIn() {
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}
function UserExists(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'SELECT ID FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (!is_null($result)) {
            return true;
        } else {
            return false;
        }
    } else {
        LogError('0x0003:0009');
        echo Alert('error', 'No response from database.', '0x0003:0009');
        exit;
    }
}
function GetUserID(string $username) {
    global $dbc;

    $username = mysqli_real_escape_string($dbc, $username);
    $username = str_replace('%', '\%', $username);
    $username = str_replace('_', '\_', $username);

    $query = 'SELECT ID FROM accounts WHERE username LIKE "' . $username . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (!is_null($result)) {
            return $result['ID'];
        } else {
            return false;
        }
    } else {
        LogError('0x0003:000A');
        echo Alert('error', 'No response from database.', '0x0003:000A');
        exit;
    }
}
function GetUsername(int $id) {
    global $dbc;

    $query = 'SELECT username FROM accounts WHERE ID = "' . $id . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);
        if (!is_null($result)) {
            return $result['username'];
        } else {
            return false;
        }
    } else {
        LogError('0x0003:000B');
        echo Alert('error', 'No response from database.', '0x0003:000B');
        exit;
    }
}
function IsUserInRole(int $id, string $role, bool $above) {
    switch ($role)
    {
        case 'user':
            if ($above) {
                if (GetUserGlobalRole($id) >= 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 0) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'contributer':
            if ($above) {
                if (GetUserGlobalRole($id) >= 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'moderator':
            if ($above) {
                if (GetUserGlobalRole($id) >= 2) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 2) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'administrator':
            if ($above) {
                if (GetUserGlobalRole($id) >= 3) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 3) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'co-owner':
            if ($above) {
                if (GetUserGlobalRole($id) >= 4) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 4) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'owner':
            if ($above) {
                if (GetUserGlobalRole($id) >= 5) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 5) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'superuser':
            if ($above) {
                if (GetUserGlobalRole($id) >= 6) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 6) {
                    return true;
                } else {
                    return false;
                }
            }
        ;
        case 'root-superuser':
            if ($above) {
                if (GetUserGlobalRole($id) >= 7) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (GetUserGlobalRole($id) == 7) {
                    return true;
                } else {
                    return false;
                }
            }
        ;

    	default:
            return false;
        ;
    }
}
function IsAccountUsernameUnique(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'SELECT ID FROM accounts WHERE username LIKE "' . GetUsername($id) . '"';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        while($row = mysqli_fetch_assoc($response)){
            $accounts[] = $row;
        }
        if ((count($accounts) > 1) && $accounts['0']['ID'] != $id) {
            return false;
        } else {
            return true;
        }
    } else {
        LogError('0x0003:000C');
        echo Alert('error', 'No response from database.', '0x0003:000C');
        exit;
    }
}
function DeleteAccount(int $id) {
    global $dbc;

    $id = mysqli_real_escape_string($dbc, $id);
    $id = str_replace('%', '\%', $id);
    $id = str_replace('_', '\_', $id);

    $query = 'DELETE FROM accounts WHERE ID = "' . $id . '"';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        if (mysqli_affected_rows($response) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        LogError('0x0003:000D');
        echo Alert('error', 'No response from database.', '0x0003:000D');
        exit;
    }
}
function RegisterFailedLoginAttempt(string $ip) {
    global $dbc;

    $ip = mysqli_real_escape_string($dbc, $ip);

    $query = 'SELECT failed_attempts FROM failed_login_attempts WHERE ip_addr = "' . $ip . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);

        if (is_null($result)) {
            $query = 'INSERT INTO failed_login_attempts (ID, ip_addr, failed_attempts, timestamp) VALUES (NULL, "'.$ip.'", "1", "'.time().'")';
            $response = mysqli_query($dbc, $query);

            if ($response) {

            } else {
                LogError('0x0003:000F');
                echo Alert('error', 'No response from database.', '0x0003:000F');
                exit;
            }
        } else {
            $query = 'UPDATE failed_login_attempts SET failed_attempts = "'.++$result['failed_attempts'].'", timestamp = "'.time().'" WHERE ip_addr = "'.$ip.'"';
            $stmt = @mysqli_prepare($dbc, $query);
            @mysqli_stmt_execute($stmt);
        }
    } else {
        LogError('0x0003:000E');
        echo Alert('error', 'No response from database.', '0x0003:000E');
        exit;
    }
}
function IsUserLoginBlocked(string $ip) {
    global $dbc;

    $ip = mysqli_real_escape_string($dbc, $ip);

    $query = 'SELECT failed_attempts, timestamp FROM failed_login_attempts WHERE ip_addr = "' . $ip . '" LIMIT 1';
    $response = @mysqli_query($dbc, $query);

    if ($response) {
        $result = mysqli_fetch_assoc($response);

        if (is_null($result)) {
            return false;
        } else {
            if ((time() - $result['timestamp']) > 300) {
                $query = 'DELETE FROM failed_login_attempts WHERE ip_addr = "'.$ip.'"';
                $stmt = @mysqli_prepare($dbc, $query);
                @mysqli_stmt_execute($stmt);

                return false;
            } elseif ($result['failed_attempts'] >= 3) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        LogError('0x0003:0010');
        echo Alert('error', 'No response from database.', '0x0003:0010');
        exit;
    }
}

?>