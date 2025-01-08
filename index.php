<?php
/**
 * 一款简约的相册主题
 * @package 洪墨时光
 * @author zhheo
 * @version 2.12
 * @link https://zhheo.com/
 */
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php $this->options->IndexName(); ?> - <?php $this->options->Indexdict() ?> </title>
  <meta http-equiv="content-type" content="text/html; charset=<?php $this->options->charset(); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <meta name="keywords" content="<?php $this->options->keywords(); ?>" />
  <meta name="description" content="<?php $this->options->description(); ?>" />
  <link rel="apple-touch-icon" href="<?php $this->options->AppleIcon(); ?>">
  <meta name="apple-mobile-web-app-title" content="<?php $this->options->IndexName(); ?>">
  <link rel="bookmark" href="<?php $this->options->AppleIcon(); ?>">
  <link rel="apple-touch-icon-precomposed" sizes="180x180" href="<?php $this->options->AppleIcon(); ?>">
  <link rel="icon" href="<?php $this->options->IconUrl() ?>">
  <link rel="stylesheet" type="text/css" href="<?php $this->options->themeUrl('assets/css/main.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php $this->options->themeUrl('assets/css/noscript.css'); ?>" />
  <noscript>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/noscript.css'); ?>" />
  </noscript>
  <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/main.css'); ?>" />
  <link rel="stylesheet" href="https://cdn3.codesign.qq.com/icons/dDyopjDLkGjVe1g/latest/iconfont.css">
</head>

<body class="is-preload">
  <header id="header">
    <a href="<?php $this->options->siteUrl(); ?>"><img class="site-logo" src="<?php $this->options->IconUrl(); ?>"></a>
    <h1><a href="<?php $this->options->siteUrl(); ?>"><strong><?php $this->options->zmkiabout() ?></strong></h1></a>
    <span class="discription"><?php $this->options->zmkiabouts() ?></span>
    <nav>
      <ul class="nav_links">


        <li class='nav-item'>
          <a class="icon solid fa-info-circle nav-item-name">分类</a>
          <ul class="nav-item-child">
            <?php
            $categories = \Widget\Metas\Category\Rows::alloc()->listCategories();
            echo '<li class="category-level-0 category-parent"><a style="cursor: pointer;" href="/">全部</a></li>';
            if ($categories) {
              foreach ($categories as $category) {
                echo '<li class="category-level-0 category-parent"><a style="cursor: pointer;">' . $category . '</a></li>';
              }
            }
            ?>
          </ul>
        </li>



        <li><a type="button" id="fullscreen" class="btn btn-default visible-lg visible-md" alt="切换全屏">
          <i class="iconfont icon-quanping"></i>
              <use xlink:href="#icon-zmki-ziyuan-copy"></use>
            </svg></a></li>
        <li><a href="#footer">关于</a></li>
      </ul>
    </nav>
  </header>

  <!-- Wrapper -->
  <div id="wrapper">
    <!-- Header -->
    <!-- Main -->
    <div id="main">

      <?php while ($this->next()): ?>
        <article class="thumb img-area">
          <a class="image my-photo" alt="loading"
            href="<?php echo $this->fields->img(); ?><?php $this->options->zmki_sy() ?>">
            <img class="zmki_px  my-photo"
              onerror="this.src='<?php $this->options->themeUrl('assets/img/loading.gif'); ?>';this.onerror=null"
              data-src="<?php echo $this->fields->img(); ?><?php $this->options->zmki_ys() ?>" />
          </a>
          <h2><?php $this->title() ?></h2>
          <?php if($this->content): ?>
          <div class="content-wrapper">
            <p><?php $this->content('内容加载中...'); ?></p>
          </div>
          <?php endif; ?>
          <li class="tag-info tag-info-bottom">
            <?php if($this->fields->device): ?>
            <span class="tag-device"><i class="iconfont icon-camera-lens-line"></i><?php echo $this->fields->device(); ?></span>
            <?php endif; ?>
            <?php if($this->fields->location): ?>
            <span class="tag-location"><i class="iconfont icon-map-pin-2-line"></i><?php echo $this->fields->location(); ?></span>
            <?php endif; ?>
            <span class="tag-time"><i class="iconfont icon-time-line"></i><?php $this->date(); ?></span>
          </li>
          <li class="tag-info">
            <span class="tag-categorys"><?php $this->category(''); ?></span>
            <?php if($this->tags): ?>
            <span class="tag-list"><?php $this->tags(); ?></span>
            <?php endif; ?>
          </li>
        </article>
      <?php endwhile; ?>
    </div>

    <body>
      <!-- Footer -->
      <footer id="footer" class="panel">
        <div class="inner split">
          <div class="inner split">
            <div>
              <section>
                <h2>关于<?php $this->options->IndexName() ?></h2>
                <p><?php echo str_replace("/n", "<br>", $this->options->Biglogo()); ?></p>
              </section>
              <section style="
    margin-bottom: 1.8rem;
">
                <h2>联系我</h2>
                <ul class="icons">
                  <li><a class="contact_link" href="<?php $this->options->xxhome() ?>" target="_blank"
                      rel="noopener nofollow"><i class="iconfont icon-shouye"></i></a></li>
                  <li><a class="contact_link" href="<?php $this->options->xxweibo() ?>" target="_blank"
                      rel="noopener nofollow"><i class="iconfont icon-weibo"></i></a></li>
                  <li><a class="contact_link" href="<?php $this->options->xxgithub() ?> " target="_blank"
                      rel="noopener nofollow"><i class="iconfont icon-github"></i></a></li>
                </ul>
              </section>
              <span style="color: #b5b5b5; font-size: 0.8em;">
                <?php $this->options->cnzz() ?>
                <p class="copyright">
                    &copy; 设计 ZHHEO & ZMKI 主题：<a href="https://github.com/zhheo/TimePlus" target="_blank" rel="noopener nofollow">TimePlus</a>.
                    <?php
                    $icp = $this->options->icp();
                    if ($icp) {
                        echo 'ICP备案号:<a href="http://beian.miit.gov.cn/" target="_blank" rel="noopener nofollow">' . $icp . '</a>';
                    }
                    ?>
                </p>

            </div>
          </div>
      </footer>
      <script type="text/javascript">
        function isInSight(el) {
          const bound = el.getBoundingClientRect();
          const clientHeight = window.innerHeight;
          //如果只考虑向下滚动加载
          //const clientWidth=window.innerWeight;
          return bound.top <= clientHeight + 100;
        }

        let index = 0;
        function checkImgs() {
          const imgs = document.querySelectorAll('.my-photo');
          for (let i = index; i < imgs.length; i++) {
            if (isInSight(imgs[i])) {
              loadImg(imgs[i]);
              index = i;
            }
          }
          // Array.from(imgs).forEach(el => {
          //   if (isInSight(el)) {
          //     loadImg(el);
          //   }
          // })
        }

        function loadImg(el) {
          if (!el.src) {
            const source = el.dataset.src;
            el.src = source;
          }
        }

        function throttle(fn, mustRun = 10) {
          const timer = null;
          let previous = null;
          return function () {
            const now = new Date();
            const context = this;
            const args = arguments;
            if (!previous) {
              previous = now;
            }
            const remaining = now - previous;
            if (mustRun && remaining >= mustRun) {
              fn.apply(context, args);
              previous = now;
            }
          }
        }
      </script>
      <script>
        window.onload = checkImgs;
        window.onscroll = throttle(checkImgs);
      </script>
  </div>
  <!-- Scripts -->
  <script src="https://lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/1.7.2/jquery.min.js"></script>
  <script src="<?php $this->options->themeUrl('assets/js/jquery.poptrox.min.js'); ?>"></script>
  <script src="<?php $this->options->themeUrl('assets/js/browser.min.js'); ?>"></script>
  <script src="<?php $this->options->themeUrl('assets/js/breakpoints.min.js'); ?>"></script>
  <script src="<?php $this->options->themeUrl('assets/js/util.js'); ?>"></script>
  <script src="<?php $this->options->themeUrl('assets/js/main.js'); ?>"></script>

</body>

</html>