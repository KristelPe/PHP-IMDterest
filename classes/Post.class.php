<?php

class Post
{
    private $m_title;
    private $m_afbeelding;
    private $m_link;
    private $m_description;
    private $m_userId;
    private $m_board;
    private $m_postId;
    private $topic;

    /**
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
    }



    /**
     * @return mixed
     */
    public function getMBoard()
    {
        return $this->m_board;
    }

    /**
     * @param mixed $m_board
     */
    public function setMBoard($m_board)
    {
        $this->m_board = $m_board;
    }

    /**
     * @return mixed
     */
    public function getMUserId()
    {
        return $this->m_userId;
    }

    /**
     * @param mixed $m_userId
     */
    public function setMUserId($m_userId)
    {
        $this->m_userId = $m_userId;
    }

    /**
     * @return mixed
     */
    public function getMTitle()
    {
        return $this->m_title;
    }

    /**
     * @param mixed $m_title
     */
    public function setMTitle($m_title)
    {
        $this->m_title = $m_title;
    }

    /**
     * @return mixed
     */
    public function getMAfbeelding()
    {
        return $this->m_afbeelding;
    }

    /**
     * @param mixed $m_afbeelding
     */
    public function setMAfbeelding($m_afbeelding)
    {
        $this->m_afbeelding = $m_afbeelding;
    }


    /**
     * @return mixed
     */
    public function getMLink()
    {
        return $this->m_link;
    }

    /**
     * @param mixed $m_link
     */
    public function setMLink($m_link)
    {
        $this->m_link = $m_link;
    }

    /**
     * @return mixed
     */
    public function getMDescription()
    {
        return $this->m_description;
    }

    /**
     * @param mixed $m_description
     */
    public function setMDescription($m_description)
    {
        $this->m_description = $m_description;
    }

    /**
     * @return mixed
     */
    public function getMPostId()
    {
        return $this->m_postId;
    }

    /**
     * @param mixed $m_postId
     */
    public function setMPostId($m_postId)
    {
        $this->m_postId = $m_postId;
    }




    public function Upload()
    {
        $conn = Db::getInstance();
        $stmnt = $conn->prepare("
          insert into posts (title, userId, image, description, link, board, date) 
          values (:title, :userId, :afbeelding, :description, :link, :board, :date)");
        $stmnt->bindvalue(":userId", $this->m_userId);
        $stmnt->bindvalue(":title", $this->m_title);
        $stmnt->bindvalue(":afbeelding", $this->m_afbeelding);
        $stmnt->bindvalue(":description", $this->m_description);
        $stmnt->bindvalue(":link", $this->m_link);
        $stmnt->bindvalue(":board", $this->m_board);
        $stmnt->bindvalue(":date", date('Y-m-d H:i:s'));
        $stmnt->execute();
    }

    public function Report()
    {
        $conn = Db::getInstance();
        $statement = $conn->prepare("select COUNT(*) from reported where postId = :postId and userId = :userId LIMIT 1");
        $statement->bindvalue(":postId", $this->m_postId);
        $statement->bindvalue(":userId", $this->m_userId);
        $statement->execute();

        //$result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($statement->fetchColumn()) {
            echo "You have already reported this post!";
        } else {
            $stmnt = $conn->prepare("insert into reported (postId,userId) values (:postId,:userId)");
            $stmnt->bindvalue(":postId", $this->m_postId);
            $stmnt->bindvalue(":userId", $this->m_userId);
            $stmnt->execute();
            echo "You have successfully reported this post!";
        }
    }

    public function AddTopic(){
        $conn = Db::getInstance();

        $statement = $conn->prepare("select COUNT(*) from selectedtopics where userId = :user and topicId = :topic LIMIT 1");
        $statement->bindvalue(":topic", $this->topic);
        $statement->bindvalue(":user", $this->m_userId);
        $statement->execute();

        if ($statement->fetchColumn()) {
            echo "You already are added to this topic";
        } else {
            $stmnt = $conn->prepare("insert into selectedtopics (userId, topicId) values (:user, :topic)");
            $stmnt->bindvalue(":topic", $this->topic);
            $stmnt->bindvalue(":user", $this->m_userId);
            $stmnt->execute();
            echo "You have subscrided to this topic";
        }
    }

    public function Datum($date){
        $currentDate = strtotime(date("Y-m-d H:i:s"));
        $savedDate = strtotime($date);
        $diff = $currentDate-$savedDate;
        if($diff>60 and $diff<3600 ){
            $result = floor($diff / 60);
            if($result==1){
                $result = $result." minuut geleden";
            }else{
                $result = $result." minuten geleden";
            }
        }else if ($diff>3600 and $diff<86400) {
            $result = floor($diff / 3600)." uur geleden";
        }else if($diff>86400 and $diff<604800){
            $result = floor($diff/86400);
            if($result==1){
                $result = $result." dag geleden";
            }else{
                $result = $result." dagen geleden";
            }
        }else if($diff>604800 and $diff<31449600){
            $result = floor($diff/604800);
            if($result==1){
                $result = $result." week geleden";
            }else{
                $result = $result." weken geleden";
            }
        }else if($diff>31449600){
            $result = floor($diff/31449600)." jaar geleden";
        }else{
            $result = $diff." seconde geleden";
        }
        return $result;
    }
}
