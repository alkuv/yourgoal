<?php

//echo '<pre>'; print_r($data); echo '</pre>';
$sql="select * from profile where user_id =".$data->id."";
    $information= Yii::app()->db->createCommand($sql)->queryAll();
   // echo '<prE>'; print_r($information); echo '<pre>';
?>
<li class="people-side-item">
            <a href="" class="img-box">
<!--                  <img src="<?php echo Yii::app()->baseUrl; ?>/images/people/user1.png" width="150" height="150" alt="" />-->
                <img src ="<?php echo Yii::app()->baseUrl; ?>/images/people/user1.png" width="150" height="150" alt="" />
             </a>
            <a href="" class="people-name">
                <span><?php 
                
                if(empty ($information[0]['firstname']))
                {
                echo $data->username ;              
                }
                else
                    {
                    echo $information[0]['firstname'];
                    }
                
                ?></span>
            </a>
            <p class="people-objects">
                <?php  echo $cnt=Goal::model()->countByAttributes(array('author_id'=>$data->id));  ?>
                     target
            </p>
            <p class="people-comment">
                  <?php  echo $cnt=Comment::model()->countByAttributes(array('email'=>$information[0]['email'])); ?> comments
            </p>
             <hr />
            <a href="" class="blue-link">Add as friend</a>

</li>