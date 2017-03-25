<?php

class UserVerify
{
    private $m_vEmail;
    private $m_vPassword;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->m_vEmail;
    }

    /**
     * @param mixed $m_vEmail
     */
    public function setEmail($m_vEmail)
    {
        if ($m_vEmail == ""){
            throw new Exception("Email cannot be empty!");
        }
        $this->m_vEmail = $m_vEmail;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->m_vPassword;
    }

    /**
     * @param mixed $m_vPassword
     */
    public function setPassword($m_vPassword)
    {
        if ($m_vPassword == ""){
            throw new Exception("Password cannot be empty!");
        }
        $this->m_vPassword = $m_vPassword;
    }

    public function Verify(){
        // conn (PDO)
        $conn = Db::getInstance();

        // statement: SELECT query
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email ;");
        $statement->bindValue(":email", $this->m_vEmail);

        // execute statement
        $res = $statement->execute();

        // confirmation
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach( $results as $row ) {
            if (password_verify($this->m_vPassword, $row['password'])) {

                header("Location: ./index.php");
                session_start();
                $_SESSION['user'] = $this->m_vEmail;
            } else {

                throw new Exception("OOPS looks like you've filled in the wrong username or password");
            }
        }



        return $res;
    }
}