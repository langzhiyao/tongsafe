<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/home/www/chenganxjh/public/../application/admin/view/teachvideo/view.html";i:1558338271;}*/ ?>

<div class="page">
    <form method="post" enctype="multipart/form-data" name="form1" action="">
        <div class="ncap-form-default">
            <dl>
                <dt>视频名称：<?php echo $video_info['t_title']; ?></dt>
            </dl>
            <?php if(!empty($video_info['t_picture'])){ ?>
                <img src="<?php echo $path.$video_info['t_picture']; ?>" height="500px">
            <?php }elseif(!empty($video_info['t_videoimg'])){ ?>
                <img src="<?php echo $video_info['t_videoimg']; ?>" height="500px">
            <?php } ?>

        </div>
    </form>
</div>







