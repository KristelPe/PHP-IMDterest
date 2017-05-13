<?php

class User
{
    private $firstname;
    private $lastname;
    private $username;
    private $email;
    private $password;
    private $image;
    private $sessionUser;

    /**
     * @return mixed
     */
    public function getSessionUser()
    {
        return $this->sessionUser;
    }

    /**
     * @param mixed $sessionUser
     */
    public function setSessionUser($sessionUser)
    {
        $this->sessionUser = $sessionUser;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        if ($firstname=="") {
            throw new Exception("Name can not be empty");
        }
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        if ($lastname=="") {
            throw new Exception("Lastname can not be empty");
        }
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        if ($username=="") {
            throw new Exception("Username can not be empty");
        }
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        if ($email=="") {
            throw new Exception("Email can not be empty");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is not a valid one");
        }
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        if ($password=="") {
            throw new Exception("Password can not be empty");
        }
        if (strlen($password) < 6) {
            throw new Exception("Password is too short");
        }
        if (!preg_match("#[a-zA-Z]+#", $password)) {
            throw new Exception("Password is not valid");
        }
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    public function Register()
    {
        $conn = Db::getInstance();

        $options = [
            'cost' => 12,
        ];
        $password = password_hash($this->password, PASSWORD_DEFAULT, $options);

        $stmnt = $conn->prepare("insert into users (email, firstname, lastname, username, password, image) values (:email, :firstname, :lastname, :username, :password, :image)");
        $stmnt->bindvalue(":email", $this->email);
        $stmnt->bindvalue(":firstname", $this->firstname);
        $stmnt->bindvalue(":lastname", $this->lastname);
        $stmnt->bindvalue(":username", $this->username);
        $stmnt->bindvalue(":password", $password);
        $stmnt->bindvalue(":image", $this->image);
        $stmnt->execute();
        header("Location: ./topics.php");

        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email ;");
        $statement->bindValue(":email", $this->email);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            session_start();
            $_SESSION["id"] = $row["id"];
            $_SESSION['user'] = $this->email;
        }
    }

    public function Login()
    {
        // conn (PDO)
        $conn = Db::getInstance();

        // statement: SELECT query
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email ;");
        $statement->bindValue(":email", $this->email);

        // execute statement
        $res = $statement->execute();

        // confirmation
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            if (password_verify($this->password, $row['password'])) {
                header("Location: ./index.php");
                session_start();
                $_SESSION["id"] = $row["id"];
                $_SESSION['user'] = $this->email;
            } else {
                throw new Exception("OOPS looks like you've filled in the wrong username or password");
            }
        }

        return $res;
    }
    /* UPDATE */

    public function prevUsername(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT username FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $username = $statement->fetchColumn();
        return $username;
    }

    public function prevPassword(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT password FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $password = $statement->fetchColumn();
        return $password;
    }

    public function newUsername($username){
        //echo "old username: ";
        //echo $username;
        //echo "new username: ";
        //echo $this->username;
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("UPDATE users SET username = REPLACE(username, '$username', '$this->username') WHERE INSTR(username, '$username') > 0;");
        $res = $stmnt->execute();
        return $res;
    }

    public function newPassword($password){
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("UPDATE users SET password = REPLACE(password, '$password', '$this->password') WHERE INSTR(password, '$password') > 0;");
        $res = $stmnt->execute();
        return $res;
    }

    public function newEmail($email){
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET email = REPLACE(email, '$email', '$this->email') WHERE INSTR(email, '$email') > 0;");
        $res = $statement->execute();
        return $res;
    }

    public function newImg($email, $target_file){
        $conn = Db::getInstance();
        $statement = $conn->prepare("UPDATE users SET image = '$target_file' WHERE email = :email");
        $statement->bindvalue(":email", $email);
        $res = $statement->execute();
        return $res;
    }

    public function userId(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->sessionUser);
        $statement->execute();
        $userid = $statement->fetchColumn();

        return $userid;
    }
}
