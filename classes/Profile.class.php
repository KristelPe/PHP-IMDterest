<?php

class Profile
{
    private $userId;
    private $title;
    private $state;
    private $image;

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

    public function newB(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("INSERT INTO boards (userid, title, state, image) VALUES (:userid, :title, :state, :image)");
        $statement->bindValue(':userid', $_SESSION['id']);
        $statement->bindValue(':title', $this->title);
        $statement->bindValue(':state', $this->state);
        $statement->bindValue(':image', $this->image);
        $statement->execute();

        header('location: profile.php?id=' . $_SESSION['id']);
    }

    public function BoardPosts(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("select p.*, count(l.user_id) as likes from posts p left join likes l on p.id = l.post_id where board = :board group by p.id order BY id DESC");
        $statement->bindValue(':board', $this->userId);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function Boards(){
        $conn = Db::getInstance();

        $statemnt = $conn->prepare("select * from boards where userid = :userid");
        $statemnt->bindValue(':userid', $this->userId);
        $statemnt->execute();
        $boards = $statemnt->fetchAll(PDO::FETCH_ASSOC);

        return $boards;
    }

    public function Posts(){
        $conn = Db::getInstance();

        $statemnt = $conn->prepare("select * from posts where userId = :userid");
        $statemnt->bindValue(':userid', $this->userId);
        $statemnt->execute();
        $posts = $statemnt->fetchAll(PDO::FETCH_ASSOC);

        return $posts;
    }

    public function userVMail($email){
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT id, username, image FROM users WHERE email = :email");
        $statement->bindvalue(":email", $email);
        $statement->execute();
        $res = $statement->fetch();
        return $res;
    }
    
    
    public function CountFollowers(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("select count(*) as followers from following where userid = :id");
        $statement->bindvalue(":id", $_SESSION['id']);
        $statement->execute();
        $res = $statement->fetch();
        return $res;
    }

    public function Followers(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("select u.* from following f inner join users u on f.followerId = u.id where f.userid = :id");
        $statement->bindvalue(":id", $_SESSION['id']);
        $statement->execute();
        $res = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }
}