<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/favicon.ico">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@600;700;800&display=swap">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Manrope', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            blue: '#0066FF',
                            indigo: '#4F46E5',
                            dark: '#0B1120',
                        }
                    },
                    backgroundImage: {
                        'hero-gradient': 'linear-gradient(135deg, #0066FF 0%, #4F46E5 100%)',
                        'subtle-grid': 'radial-gradient(#E5E7EB 1px, transparent 1px)',
                    }
                }
            }
        }
    </script>
    <?php $this->head() ?>
</head>
<body class="font-sans text-gray-800 antialiased bg-white">
<?php $this->beginBody() ?>

    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center cursor-pointer">
                    <span class="font-display font-extrabold text-2xl tracking-tight text-brand-dark">
                        Chào<span class="text-brand-blue">Sếp</span>.
                    </span>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#tinh-nang" class="text-sm font-medium text-gray-600 hover:text-brand-blue transition">Giải
                        Pháp</a>
                    <a href="#mobile-app"
                        class="text-sm font-semibold text-slate-600 hover:text-brand-blue transition">Ứng dụng</a>

                    <a href="#bang-gia" class="text-sm font-medium text-gray-600 hover:text-brand-blue transition">Bảng
                        giá</a>
                    <a href="#dang-ky"
                        class="text-sm font-medium text-white bg-hero-gradient px-6 py-2.5 rounded-full hover:shadow-lg hover:opacity-90 transition transform hover:-translate-y-0.5">
                        Đăng ký miễn phí
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <span class="font-display font-extrabold text-2xl tracking-tight text-brand-dark">
                        Chào<span class="text-brand-blue">Sếp</span>.
                    </span>
                    <p class="mt-4 text-gray-500 text-sm">Giải pháp tiếp cận khách hàng cao cấp B2B hàng đầu Việt Nam.
                    </p>
                    <p class="mt-4 text-gray-500 text-sm">Địa Chỉ
                    Tòa nhà BCONS POLYGON Tower, 15 Bế Văn Đàn, An Bình, Dĩ An, Tp.HCM</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Sản phẩm</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-brand-blue">Data Doanh nghiệp</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Zalo - Marketing</a></li>
                        <li><a href="#" class="hover:text-brand-blue">SMS - Marketing</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Email - Marketing</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Website - Marketing</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Phone call - Marketing</a></li>
                        <li><a href="#" class="hover:text-brand-blue">App - Marketing</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Công ty</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-brand-blue">Về chúng tôi</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Điều khoản</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Tin Tức</a></li>
                        <li><a href="#" class="hover:text-brand-blue">API</a></li>
                        <li><a href="#" class="hover:text-brand-blue">Quyền Riêng Tư</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Liên hệ</h4>
                    <p class="text-sm text-gray-600 mb-2">Hotline: 0934880855</p>
                    <p class="text-sm text-gray-600">Email: support@chaosep.com</p>
                    <p class="text-sm text-gray-600">Hồ Chí Minh, Việt Nam</p>
                </div>
            </div>
            <div class="border-t border-gray-100 pt-8 text-center text-sm text-gray-500">
                &copy; 2025 Chào Sếp. All rights reserved.This website make by 
                <a href="https://stonenetworktech.com/" target="_blank" rel="nofollow noopener" class="font-display font-extrabold text-2x2 tracking-tight text-brand-dark">StoneNetwork</a>
            </div>
        </div>
    </footer>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.querySelector('.md\\:hidden button');
    const mobileMenu = document.createElement('div');
    mobileMenu.className = 'mobile-menu fixed top-0 right-0';
    mobileMenu.innerHTML = `
      <div class="text-right mb-8">
        <button class="text-3xl text-gray-600" id="closeMenu">&times;</button>
      </div>
      <a href="#tinh-nang">Giải Pháp</a>
      <a href="#mobile-app">Ứng dụng</a>
      <a href="#bang-gia">Bảng giá</a>
      <a href="#dang-ky" class="inline-block mt-8 w-full text-center py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-full">Đăng ký miễn phí</a>
    `;

    const overlay = document.createElement('div');
    overlay.className = 'overlay';

    document.body.appendChild(mobileMenu);
    document.body.appendChild(overlay);

    function openMenu() {
      mobileMenu.classList.add('open');
      overlay.classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
      mobileMenu.classList.remove('open');
      overlay.classList.remove('open');
      document.body.style.overflow = '';
    }

    menuBtn.addEventListener('click', openMenu);
    overlay.addEventListener('click', closeMenu);
    mobileMenu.querySelector('#closeMenu').addEventListener('click', closeMenu);

    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', closeMenu);
    });
  });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
