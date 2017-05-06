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

        $statement = $conn->prepare("select COUNT(*) from selectedtopics where userId = :user and topicId = :topic LIMIT 1");
        $statement->bindvalue(":topic", $this->topicId);
        $statement->bindvalue(":user", $_SESSION['id']);
        $statement->execute();

        if ($statement->fetchColumn()) {
            echo "You already are added to this topic";
        } else {
            $stmnt = $conn->prepare("insert into selectedtopics (userId, topicId) values (:user, :topic)");
            $stmnt->bindvalue(":topic", $this->topicId);
            $stmnt->bindvalue(":user", $_SESSION['id']);
            $stmnt->execute();
            echo "You have subscrided to this topic";
        }
        header("Location: ./index.php");
    }
}