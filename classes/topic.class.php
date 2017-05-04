<?php

class topic
{
    private $topicId;
    private $search;
    private $email;

    /**
     * @return mixed
     */
    public function getTopicId()
    {
        return $this->topicId;
    }

    /**
     * @param mixed $topicId
     */
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }

    /**
     * @return mixed
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
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
        $this->email = $email;
    }

    public function Topics(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select * from topics");
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function SearchUser(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $statement->bindvalue(":email", $this->email);
        $statement->execute();
        $userid = $statement->fetchColumn();
        return $userid;
    }

    public function Search() {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT * FROM topics WHERE title LIKE :keywords");
        $statement->bindValue(':keywords', '%' . $this->search . '%');
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function SaveTopic(){
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("INSERT into selectedTopic (user_id, topic_id) VALUES (:userid, :topicId)");
        $stmnt->bindvalue(":topicId", $this->topicId);
        $stmnt->bindvalue(":userid", $_SESSION['id']);
        $stmnt->execute();
        header("Location: ./index.php");
    }
}