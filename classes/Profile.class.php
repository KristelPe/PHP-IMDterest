<?php

class Profile
{
    private $userId;

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

    public function Profile(){
        $conn = Db::getInstance();

        $stment = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stment->bindValue(':id', $this->userId);
        $stment->execute();
        $use = $stment->fetchAll(PDO::FETCH_ASSOC);

        return $use;
    }

    public function Follow(){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("select userid from following where userid = :id and followerid = :follower");
        $stmnt->bindValue(':id', $this->userId);
        $stmnt->bindValue(':follower', $_SESSION['id']);
        $stmnt->execute();
        $status =  $stmnt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($status)) {
            $state = "unfollow";
        } else {
            $state = "follow";
        }

        if (!empty($_POST)) {
            if (!empty($status)) {
                $statement = $conn->prepare("DELETE FROM following WHERE userid = :userid AND followerid = :followerid");
                $statement->bindValue(':userid', $this->userId);
                $statement->bindValue(':followerid', $_SESSION['id']);
                $statement->execute();
                $state = "unfollow";
            } else {
                $statement = $conn->prepare("INSERT INTO following (userid, followerid) VALUES (:userid, :followerid)");
                $statement->bindValue(':userid', $this->userId);
                $statement->bindValue(':followerid', $_SESSION['id']);
                $statement->execute();
                $state = "follow";
            }
            header("Refresh:0");
        }

        return $state;
    }
}