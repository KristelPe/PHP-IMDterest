<?php

class Board
{
    private $title;
    private $state;
    private $userId;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $pTitle
     */
    public function setTitle($title)
    {
        if ($title=="") {
            throw new Exception("Board name can not be empty");
        }
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $pState
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }


    public function newB(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("INSERT INTO boards (userid, title, state) VALUES (:userid, :title, :state)");
        $statement->bindValue(':userid', $_SESSION['id']);
        $statement->bindValue(':title', $this->title);
        $statement->bindValue(':state', $this->state);
        $statement->execute();

        header('location: profile.php?id=' . $_SESSION['id']);
    }

    public function Boards(){
        $conn = Db::getInstance();
        $statement = $conn->prepare("select p.*, count(l.user_id) as likes from posts p left join likes l on p.id = l.post_id where board = :board group by p.id order BY id DESC");
        $statement->bindValue(':board', $this->userId);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}