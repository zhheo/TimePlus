<?php
/**
 * 一款简约的相册主题
 * @package 洪墨时光
 * @author zhheo
 * @version 2.14
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
          <?php 
          // 将多行图片链接分割成数组
          $images = array_filter(explode("\n", $this->fields->img));
          // 获取第一张图片作为缩略图
          $firstImage = trim($images[0]); 
          ?>
          <a class="image my-photo" alt="loading" href="<?php echo $firstImage; ?><?php $this->options->zmki_sy() ?>">
            <img class="zmki_px my-photo"
              onerror="this.src='<?php $this->options->themeUrl('assets/img/loading.gif'); ?>';this.onerror=null"
              data-src="<?php echo $firstImage; ?><?php $this->options->zmki_ys() ?>" />
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
            <span class="tag-list"><?php $this->tags('', true); ?></span>
            <?php endif; ?>
          </li>
          <!-- 只有当图片数量大于1时才显示面包屑导航 -->
          <?php if(count($images) > 1): ?>
          <div class="breadcrumb-nav" data-images='<?php echo json_encode($images); ?>'>
            <?php foreach($images as $index => $image): ?>
            <span class="nav-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>"></span>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        </article>
      <?php endwhile; ?>
      
      <!-- 分页导航 -->
      <?php
        $total = ceil($this->getTotal() / $this->parameter->pageSize);
        if($total > 1):
      ?>
      <div class="pagination-container">
        <?php 
          $current = $this->_currentPage;
          $max_pages = 6; // 最多显示的页码数
          
          // 计算显示的页码范围
          $start = max(1, min($current - floor($max_pages/2), $total - $max_pages + 1));
          $end = min($start + $max_pages - 1, $total);
          
          // 获取当前分类路径
          $category = '';
          if ($this->is('category')) {
            $category = $this->getArchiveSlug();
          }
          
          // 上一页按钮
          if ($current > 1): 
            $prevUrl = $category ? $this->options->siteUrl . 'index.php/category/' . $category . '/' . ($current-1) . '/' : $this->options->siteUrl . 'index.php/page/' . ($current-1);
            echo '<a href="' . $prevUrl . '" class="page-btn prev-btn">上一页</a>';
          endif;

          // 页码按钮
          for ($i = $start; $i <= $end; $i++):
            if ($i == $current): ?>
              <span class="page-btn current"><?php echo $i; ?></span>
            <?php else: 
              $pageUrl = $category ? $this->options->siteUrl . 'index.php/category/' . $category . '/' . $i . '/' : $this->options->siteUrl . 'index.php/page/' . $i;
            ?>
              <a href="<?php echo $pageUrl; ?>" class="page-btn"><?php echo $i; ?></a>
            <?php endif;
          endfor;

          // 下一页按钮
          if ($current < $total): 
            $nextUrl = $category ? $this->options->siteUrl . 'index.php/category/' . $category . '/' . ($current+1) . '/' : $this->options->siteUrl . 'index.php/page/' . ($current+1);
            echo '<a href="' . $nextUrl . '" class="page-btn next-btn">下一页</a>';
          endif; ?>
      </div>
      <?php endif; ?>

      <!-- 原有的 load-more div -->
      <div id="load-more" data-page="1" data-total-pages="<?php echo $total; ?>"></div>
    </div>

    <body>
      <!-- Footer -->
      <footer id="footer" class="panel">
            <div id="about">
              <section>
                <h2>关于<?php $this->options->IndexName() ?></h2>
                <p><?php echo $this->options->Biglogo(); ?></p>
              </section>
              <section>
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
                <div class="copyright-info">
                    <span class="copyright">&copy; 设计 ZHHEO & ZMKI</span>
                    <span class="theme">主题：<a href="https://github.com/zhheo/TimePlus" target="_blank" rel="noopener nofollow">洪墨时光</a></span>
                    <?php if ($this->options->police): ?>
                    <span class="police">
                        <img src="<?php $this->options->themeUrl('assets/img/police.png'); ?>" alt="公安备案" style="vertical-align: middle; width: 14px;">
                        <a href="https://beian.mps.gov.cn/#/query/webSearch" target="_blank" rel="noopener nofollow"><?php $this->options->police(); ?></a>
                    </span>
                    <?php endif; ?>
                    <?php if ($this->options->icp): ?>
                    <span class="icp">
                        <a href="http://beian.miit.gov.cn/" target="_blank" rel="noopener nofollow"><?php $this->options->icp(); ?></a>
                    </span>
                    <?php endif; ?>
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
      <script>
      document.addEventListener('DOMContentLoaded', function() {
        //修改代码
       window.isTransitioning = false;
  function switchImage(nav, img, idx) {
    window.isTransitioning = true;
    img.style.transition = 'opacity .3s';
    img.style.opacity = 0;
    setTimeout(function() {
      img.src = JSON.parse(nav.dataset.images)[idx] + '<?php $this->options->zmki_sy() ?>';
      img.onload = function() { img.style.opacity = 1; setTimeout(()=>window.isTransitioning=false,300); };
      img.onerror = function() { window.isTransitioning = false; };
      nav.querySelectorAll('.nav-dot').forEach(d=>d.classList.remove('active'));
      nav.querySelectorAll('.nav-dot')[idx].classList.add('active');
    }, 300);
  }
  var pic = document.querySelector('.poptrox-popup .pic');
  if (pic) {
    pic.addEventListener('touchstart', function(e) {
      if (window.isTransitioning) return;
      var t = e.touches[0]; this.startY = t.clientY; this.startX = t.clientX;
    }, { passive: true, capture: true });
    pic.addEventListener('touchend', function(e) {
      if (window.isTransitioning) return;
      var t = e.changedTouches[0], dY = t.clientY - this.startY, dX = t.clientX - this.startX;
      if (Math.abs(dY) > 50 && Math.abs(dY) > Math.abs(dX)) {
        var nav = pic.closest('.poptrox-popup').querySelector('.breadcrumb-nav'),
            dots = nav.querySelectorAll('.nav-dot'),
            cur = Array.from(dots).findIndex(d=>d.classList.contains('active')),
            nxt = dY<0 && cur<dots.length-1 ? cur+1 : dY>0 && cur>0 ? cur-1 : cur;
        if (nxt!==cur) switchImage(nav, pic.querySelector('img'), nxt);
      }
    }, { passive: true, capture: true });
    pic.addEventListener('wheel', function(e) {
      e.stopImmediatePropagation(); e.preventDefault();
      if (window.isTransitioning) return;
      var nav = pic.closest('.poptrox-popup').querySelector('.breadcrumb-nav'),
          dots = nav.querySelectorAll('.nav-dot'),
          cur = Array.from(dots).findIndex(d=>d.classList.contains('active')),
          nxt = e.deltaY>0 ? (cur+1)%dots.length : (cur-1+dots.length)%dots.length;
      switchImage(nav, pic.querySelector('img'), nxt);
    }, { passive: false, capture: true });
  }
      });
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
