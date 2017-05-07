<?php

spl_autoload_register(function ($class) {
    include_once("classes/" . $class . ".class.php");
});

try{
    //PROFILE
    $userid = $_SESSION['id'];
    $profile = new Profile();
    $profile->setUserId($userid);
    $use = $profile->Profile();

} catch (Exception $e) {
    echo $e->getMessage();
}

?>
<div id="navigatie">
    <a href="index.php">
        <img src="images/spark_logo.svg" alt="spark_logo" class="logo">
    </a>
    <nav>
        <span class="nav_text"><a href="upload.php">Upload</a></span>
            <a href="profile.php?id=<?php echo htmlspecialchars($_SESSION['id']);?>">
                <span class="hidden_text">Profile</span>
                <?php foreach ($use as $u): ?>
                    <img src="<?php echo htmlspecialchars($u['image'])?>" alt="<?php echo htmlspecialchars($u['username'])?>" class="profile_icon">
                <?php endforeach;?>
            </a>
        <span class="nav_text"><a href="logout.php">Logout</a></span>
    </nav>
</div>