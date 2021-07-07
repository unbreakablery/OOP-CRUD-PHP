<?php
namespace Anthony;

class User
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * to check if the username already exists
     *
     * @param string $username
     * @return boolean
     */
    public function isUsernameExists($username)
    {
        $query = 'SELECT * FROM users where username = ?';
        $paramType = 's';
        $paramValue = array(
            $username
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to check if the email already exists
     *
     * @param string $email
     * @return boolean
     */
    public function isEmailExists($email)
    {
        $query = 'SELECT * FROM users where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $resultArray = $this->ds->select($query, $paramType, $paramValue);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * to signup / register a user
     *
     * @return string[] registration status message
     */
    public function registerUser()
    {   
        $isUsernameExists = $this->isUsernameExists($_POST["username"]);
        $isEmailExists = $this->isEmailExists($_POST["email"]);
        if ($isUsernameExists) {
            $response = array(
                "status" => "danger",
                "message" => "Username already exists."
            );
        } else if ($isEmailExists) {
            $response = array(
                "status" => "danger",
                "message" => "Email already exists."
            );
        } else {
            if (! empty($_POST["password"])) {

                // PHP's password_hash is the best choice to use to store passwords
                $hashedPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);
            }
            $query = 'INSERT INTO users (username, password, email) VALUES (?, ?, ?)';
            $paramType = 'sss';
            $paramValue = array(
                htmlspecialchars($_POST["username"]),
                $hashedPassword,
                htmlspecialchars($_POST["email"])
            );
            $userId = $this->ds->insert($query, $paramType, $paramValue);
            if (! empty($userId)) {
                $response = array(
                    "status" => "success",
                    "message" => "You have registered successfully."
                );
            }
        }
        return $response;
    }

    public function getUser($email)
    {
        $query = 'SELECT * FROM users where email = ?';
        $paramType = 's';
        $paramValue = array(
            $email
        );
        $userRecord = $this->ds->select($query, $paramType, $paramValue);
        return $userRecord;
    }

    /**
     * to login a user
     *
     * @return string
     */
    public function loginUser()
    {
        $email = htmlspecialchars($_POST["email"]);
        $userRecord = $this->getUser($email);
        $loginPassword = 0;
        if (! empty($userRecord)) {
            if (! empty($_POST["password"])) {
                $password = htmlspecialchars($_POST["password"]);
            }
            $hashedPassword = $userRecord[0]["password"];
            $loginPassword = 0;
            if (password_verify($password, $hashedPassword)) {
                $loginPassword = 1;
            }
        } else {
            $loginPassword = 0;
        }
        if ($loginPassword == 1) {
            // login sucess so store the user's email in
            // the session
            session_start();
            $_SESSION["user_id"] = $userRecord[0]["id"];
            $_SESSION["user_name"] = $userRecord[0]["username"];
            $_SESSION["email"] = $userRecord[0]["email"];
            session_write_close();
            $url = "./addressbook.php";
            header("Location: $url");
        } else if ($loginPassword == 0) {
            $loginStatus = "Invalid email or password.";
            return $loginStatus;
        }
    }
}
