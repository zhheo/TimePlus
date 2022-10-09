<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
 <?php $this->need('sidebar.php'); ?>
         <div class="main-content" >
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <h1 class="text-gray"><?php $this->title() ?></h1>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <blockquote>
                                        <?php $this->content(); ?>
                                        <br>
                                        <?php if(isset($this->fields->url)){ ?>
                                            <a href="<?php echo $this->fields->url;?>" rel="nofollow" target="_blank">立即访问 <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
                                        <?php };?>
                                    </blockquote>
                                </div>
                                <?php $this->need('comments.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <!-- Main Footer -->
 <?php $this->need('footer.php'); ?>
   