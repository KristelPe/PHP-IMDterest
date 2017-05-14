<?php

class Stack
{
    private $search;
    private $sessionId;

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
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param mixed $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }


    public function Search($noP) {
        $conn = Db::getInstance();

        $statement = $conn->prepare("SELECT p.*, count(r.postId), count(l.user_id) as likes, u.username as username, u.image as userImage, p.userId, r.postId
                                    FROM users u 
                                    inner join posts p on u.id = p.userId 
                                    left join likes l on p.id = l.post_id
                                    left join reported r on r.postId = p.id
                                    WHERE p.title LIKE :keywords OR p.description LIKE :keywords 
                                    group by p.id
                                    HAVING count(r.postId) < 3 
                                    order by p.id desc limit :noP,20");
        $statement->bindValue(':keywords', '%' . $this->search . '%');
        $statement->bindValue(':noP', $noP, PDO::PARAM_INT);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }


    public function Stacker($noP){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("select userid from following where followerid = :followerid");
        $stmnt->bindValue(':followerid', $this->sessionId);
        $stmnt->execute();
        $status =  $stmnt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($status)) {
            $statement = $conn->prepare("select p.*, count(l.user_id) as likes, u.username as username, u.image as userImage 
                                        from posts p 
                                        inner join following f on f.userid = p.userid 
                                        inner join users u on p.userId = u.id 
                                        left join likes l on p.id = l.post_id 
                                        where followerid = :follwerid 
                                        group by p.id 
                                        ORDER BY p.id desc limit :noP,20");
            $statement->bindValue(':followerid', $this->sessionId);
            $statement->bindValue(':noP', $noP, PDO::PARAM_INT);
            $statement->execute();
        } else {
            $statement = $conn->prepare("select p.*, count(r.postId), count(l.user_id) as likes, u.username as username, u.image as userImage, p.userId, r.postId
                                        from posts p
                                        left join reported r on r.postId = p.id
                                        inner join users u on p.userId = u.id 
                                        left join likes l on p.id = l.post_id
                                        group by p.id
                                        HAVING count(r.postId) < 3
                                        order BY id DESC limit :noP,20");
            $statement->bindValue(':noP', $noP, PDO::PARAM_INT);
            $statement->execute();
        }

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    public function Liked($postId){
        $conn = Db::getInstance();

        $stmnt = $conn->prepare("select * from likes where post_id = :postId AND user_id = :userId");
        $stmnt->bindValue(':userId', $this->sessionId);
        $stmnt->bindValue(':postId', $postId);
        $stmnt->execute();

        $res =  $stmnt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($res)){
            $class = "liked";
        } else {
            $class = "unliked";
        }

        return $class;
    }

}
