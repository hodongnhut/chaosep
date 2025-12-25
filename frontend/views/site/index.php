<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
/** @var yii\web\View $this */

$this->title = 'Chào Sếp - Phần mềm CRM Quản lý Lead, Pipeline Sales & Marketing Automation Việt Nam';

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Chào Sếp - CRM & Marketing Automation hàng đầu Việt Nam. Quản lý pipeline sales, AI lead scoring, dashboard realtime, tích hợp Zalo ZNS, SMS, Email, AI Call. Tăng doanh thu B2B nhanh chóng.',
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'phần mềm CRM, CRM Việt Nam, marketing automation, quản lý khách hàng, telesales, email marketing, Zalo ZNS, SMS marketing, phần mềm quản lý lead, CRM doanh nghiệp, tự động hóa marketing, Chào Sếp CRM',
]);


$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['property' => 'og:description', 'content' => 'Chào Sếp - Giải pháp CRM & Marketing Automation chuyên sâu cho doanh nghiệp Việt Nam. Quản lý 1.5 triệu data doanh nghiệp, tích hợp multi-channel.']);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->request->absoluteUrl]);
$this->registerMetaTag(['property' => 'og:image', 'content' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80']); // Thay bằng link ảnh thực

?>
<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
    <div class="absolute inset-0 bg-subtle-grid bg-grid-pattern opacity-50 -z-10"></div>
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50 to-transparent -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-brand-blue text-xs font-semibold uppercase tracking-wide mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-blue animate-pulse"></span>
                    Dữ liệu Big Data 2025
                </div>

                <h1
                    class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl text-gray-900 leading-[1.15] mb-6">
                    Chào đúng Sếp.<br>
                    <span class="text-gradient">Chốt đúng Deal.</span>
                </h1>

                <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Nền tảng CRM toàn diện giúp tiếp cận <strong>2.000.000+ Chủ doanh nghiệp</strong>, quản lý pipeline sales thông minh với AI lead scoring, dashboard realtime & mobile app mạnh mẽ.
                </p>

                <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-10 price-features-container">
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-bolt text-yellow-500"></i>
                        <span class="font-bold text-gray-900">150đ</span>
                        <span class="text-sm text-gray-500">/Zalo ZNS</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-comment-alt text-brand-blue"></i>
                        <span class="font-bold text-gray-900">299đ</span>
                        <span class="text-sm text-gray-500">/SMS Brand</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-phone text-green-500"></i>
                        <span class="font-bold text-gray-900">1.200đ</span>
                        <span class="text-sm text-gray-500">/Phút gọi</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-envelope text-brand-blue"></i>
                        <span class="font-bold text-gray-900">Email</span>
                        <span class="text-sm text-gray-500">- Không giới hạn</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#dang-ky"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold text-white bg-hero-gradient rounded-full shadow-lg hover:shadow-blue-500/30 hover:-translate-y-1 transition duration-300">
                        Dùng thử miễn phí 7 ngày
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <div class="flex items-center gap-2 text-slate-500 text-sm font-medium px-6">
                        <i class="fas fa-shield-alt text-green-500"></i> Bảo mật 100%
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">
                    <i class="fas fa-check-circle text-green-500 mr-1"></i> Không cần thẻ tín dụng
                    <span class="mx-2">•</span>
                    <i class="fas fa-check-circle text-green-500 mr-1"></i> Setup trong 5 phút
                </p>
            </div>

            <div class="relative lg:h-auto">
                <div
                    class="relative rounded-2xl overflow-hidden shadow-2xl border border-gray-200 bg-white p-2 animate-fade-in-up">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Chào Sếp CRM Dashboard với Pipeline & AI Insights"
                        alt="Dashboard Analytics" class="rounded-xl w-full h-auto object-cover opacity-95">

                    <div class="absolute bottom-10 -left-6 bg-white p-4 rounded-xl shadow-xl border border-gray-100 flex items-center gap-4 animate-bounce"
                        style="animation-duration: 3s;">
                        <div
                            class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xl">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold">Vừa gửi thành công</p>
                            <p class="text-sm font-bold text-gray-900">GĐKD - VinHomes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="mobile-app" class="py-24 bg-brand-dark overflow-hidden relative">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-blue rounded-full opacity-20 blur-[100px]">
    </div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-brand-indigo rounded-full opacity-20 blur-[100px]">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-16">

            <div class="lg:w-1/2 text-white">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-300 text-xs font-bold uppercase tracking-wide mb-6">
                    <i class="fas fa-mobile-alt"></i> Mobile CRM Đầu Tiên Tại VN
                </div>
                <h2 class="font-display font-bold text-4xl md:text-5xl mb-6 leading-tight">
                    CRM Đầy Đủ Trên Mobile<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Quản lý Pipeline, Lead Scoring mọi lúc.</span>
                </h2>
                <p class="text-slate-400 text-lg mb-8 leading-relaxed">
                    Xem dashboard realtime, cập nhật deal, nhận gợi ý AI next action ngay trên điện thoại – dù đang gặp khách hay di chuyển.
                </p>

                <div class="space-y-6 mb-10">
                    <div class="flex items-start gap-4 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition">
                            <i class="fas fa-fingerprint text-xl"></i></div>
                        <div>
                            <h4 class="font-bold text-lg">One-Touch Send</h4>
                            <p class="text-slate-400 text-sm">Bấm 1 nút - Gửi 10.000 tin Zalo/SMS ngay lập tức.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 group">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-400 group-hover:bg-green-500 group-hover:text-white transition">
                            <i class="fas fa-bell text-xl"></i></div>
                        <div>
                            <h4 class="font-bold text-lg">Thông báo Realtime</h4>
                            <p class="text-slate-400 text-sm">Nhận thông báo ngay khi Khách hàng phản hồi hoặc quan
                                tâm.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:bg-blue-500 group-hover:text-white transition">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg">Báo cáo trực quan</h4>
                            <p class="text-slate-400 text-sm">Biểu đồ tăng trưởng, chi phí hiển thị rõ ràng từng
                                phút.</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-white/5 rounded-xl border border-white/10 backdrop-blur-sm">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-blue-300"><i class="fas fa-tools mr-2"></i>Đang phát
                            triển - Ra mắt Q1/2026</span>
                    </div>
                    <a href="#dang-ky"
                        class="block text-center w-full py-3 bg-white text-brand-dark font-bold rounded-lg hover:bg-gray-100 transition shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                        Đăng ký nhận App miễn phí trọn đời
                    </a>
                </div>
            </div>

            <div class="lg:w-1/2 relative h-[600px] w-full flex justify-center items-center">
                <div class="absolute z-20 w-[280px] h-[580px] phone-mockup bg-white animate-float">
                    <img src="https://images.unsplash.com/photo-1555421689-491a97ff2040?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        class="w-full h-full object-cover" alt="App Interface">
                    <div
                        class="absolute bottom-10 left-4 right-4 bg-white/90 backdrop-blur p-3 rounded-xl shadow-lg">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-800">Đã gửi thành công</p>
                                <p class="text-[10px] text-gray-500">Chiến dịch: BĐS Novaland</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="absolute z-10 w-[260px] h-[540px] phone-mockup bg-gray-100 translate-x-20 translate-y-10 opacity-80 border-gray-700">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        class="w-full h-full object-cover grayscale" alt="App Analytics">
                </div>
            </div>

        </div>
    </div>
</section>

<section id="crm-features" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-4">Tính Năng CRM Thông Minh - Ra Mắt Đầy Đủ 2026</h2>
            <p class="text-slate-600 text-lg">Từ outbound mạnh mẽ đến quản lý deal toàn diện với AI – Chào Sếp sẽ là CRM Việt Nam dẫn đầu thị trường B2B.</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 shadow-hover">
                <img src="https://multipurposethemes.com/wp-content/uploads/2025/05/CRM-Admin-Templates-1200x675.jpg" alt="Pipeline Sales & Dashboard Realtime" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-bold text-lg">Pipeline Sales & Dashboard Realtime</h3>
                <p class="text-sm text-slate-600">Theo dõi stages deal, doanh số từng sales, gamification đội ngũ.</p>
            </div>
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 shadow-hover">
                <img src="https://www.hubspot.com/hs-fs/hubfs/Lead%20Scoring%20(1).png" alt="AI Lead Scoring" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-bold text-lg">AI Lead Scoring & Next Best Action</h3>
                <p class="text-sm text-slate-600">AI chấm điểm lead nóng/lạnh, gợi ý hành động tối ưu realtime.</p>
            </div>
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 shadow-hover">
                <img src="https://www.geckoboard.com/uploads/Sales-Team-Leaderboard-dashboard.png" alt="Gamification & Team Analytics" class="rounded-lg mb-4 w-full h-48 object-cover">
                <h3 class="font-bold text-lg">Conversation Intelligence & Caller ID</h3>
                <p class="text-sm text-slate-600">Phân tích cuộc gọi, pop-up info khách, ghi âm tự động gắn lead.</p>
            </div>
        </div>
        <div class="text-center mt-12">
            <a href="#dang-ky" class="inline-block px-8 py-4 bg-hero-gradient text-white font-bold rounded-full hover:shadow-lg transition">Đăng ký Beta CRM Module miễn phí ngay</a>
        </div>
    </div>
</section>

<!-- SECTION MỚI: TÍNH NĂNG CRM THÔNG MINH -->
<section class="py-10 border-y border-gray-100 bg-gray-50/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-sm font-semibold text-gray-400 uppercase tracking-widest mb-8">
            Được tin dùng bởi hơn 5,000+ doanh nghiệp hàng đầu
        </p>
        <div
            class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2 text-xl font-bold text-gray-600"><i class="fas fa-building"></i>
                Vinhomes</div>
            <div class="flex items-center gap-2 text-xl font-bold text-gray-600"><i class="fas fa-shield-alt"></i>
                Prudential</div>
            <div class="flex items-center gap-2 text-xl font-bold text-gray-600"><i class="fas fa-university"></i>
                VPBank</div>
            <div class="flex items-center gap-2 text-xl font-bold text-gray-600"><i class="fas fa-chart-line"></i>
                MISA</div>
            <div class="flex items-center gap-2 text-xl font-bold text-gray-600"><i class="fas fa-bolt"></i> FPT
            </div>
        </div>
    </div>
</section>

<section id="tinh-nang" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-display font-bold text-3xl md:text-4xl text-slate-900 mb-4">4 Kênh tiếp cận – 1 Nền tảng
                duy nhất</h2>
            <p class="text-slate-600 text-lg">Chào Sếp tự động hóa quy trình "săn" khách hàng VIP, giúp bạn xuất
                hiện ở mọi nơi họ hiện diện.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Zalo -->
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 transition duration-300">
                <div
                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 text-xl mb-4">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Zalo ZNS Official</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">Gửi tin nhắn chăm sóc khách hàng với thương
                    hiệu đã đăng ký (Verified). Tỷ lệ xem > 90%.</p>
                <div class="text-xs font-semibold text-brand-blue bg-blue-50 inline-block px-2 py-1 rounded">Rẻ hơn
                    SMS 40%</div>
            </div>

            <!-- SMS -->
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 transition duration-300">
                <div
                    class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 text-xl mb-4">
                    <i class="fas fa-sms"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">SMS Brandname</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">Hiển thị tên công ty thay vì số rác. Khẳng
                    định uy tín thương hiệu ngay từ cái nhìn đầu tiên.</p>
                <div class="text-xs font-semibold text-indigo-600 bg-indigo-50 inline-block px-2 py-1 rounded">100%
                    người nhận</div>
            </div>

            <!-- Email (Highlighted) -->
            <div
                class="feature-card bg-white p-6 rounded-2xl border border-slate-100 transition duration-300 relative overflow-hidden group">
                <div
                    class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-500 text-xl mb-4">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">Email Marketing</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">Hệ thống gửi Email Amazon SES uy tín.
                    Template chuẩn doanh nhân, vào Inbox, tránh Spam.</p>

                <!-- Mini visual of email template -->
                <div
                    class="bg-slate-50 border border-slate-200 rounded p-2 mt-2 group-hover:bg-orange-50 transition">
                    <div class="h-2 w-1/3 bg-slate-200 rounded mb-1"></div>
                    <div class="h-2 w-full bg-slate-200 rounded mb-1"></div>
                    <div class="h-2 w-2/3 bg-slate-200 rounded"></div>
                    <div class="mt-2 text-[10px] text-green-600 font-bold"><i class="fas fa-check-circle"></i> Tỷ lệ
                        mở 45%</div>
                </div>
            </div>

            <!-- Call -->
            <div class="feature-card bg-white p-6 rounded-2xl border border-slate-100 transition duration-300">
                <div
                    class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 text-xl mb-4">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="font-bold text-lg text-slate-900 mb-2">AI Auto Call</h3>
                <p class="text-sm text-slate-600 leading-relaxed mb-4">Gọi 10.000 cuộc/giờ bằng giọng đọc AI tự
                    nhiên. Tự động lọc khách quan tâm chuyển về Sale.</p>
                <div class="text-xs font-semibold text-purple-600 bg-purple-50 inline-block px-2 py-1 rounded">Tiết
                    kiệm 80% nhân sự</div>
            </div>
        </div>
    </div>
</section>

<section id="bang-gia" class="py-24 bg-gray-900 text-white relative overflow-hidden">
  <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
    <div class="absolute w-96 h-96 bg-brand-blue rounded-full blur-[128px] opacity-20 -top-20 -left-20"></div>
    <div class="absolute w-96 h-96 bg-brand-indigo rounded-full blur-[128px] opacity-20 bottom-0 right-0"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="font-display font-bold text-3xl md:text-4xl mb-4">
        Đầu tư nhỏ – Lợi nhuận lớn
      </h2>
      <p class="text-lg text-gray-400">
        Chọn gói dữ liệu phù hợp với quy mô tăng trưởng của bạn.
      </p>
    </div>
    <div class="flex flex-col md:flex-row justify-center items-center gap-8">
      <!-- Gói Starter MỚI -->
      <div class="w-full max-w-md bg-gray-800 border border-gray-700 rounded-2xl p-8 hover:border-gray-500 transition">
        <h3 class="text-xl font-semibold text-gray-300 mb-2">Gói Starter</h3>
        <div class="flex items-baseline gap-1 mb-6">
          <span class="text-4xl font-bold text-white">8.000.000</span>
          <span class="text-gray-400">VNĐ</span>
        </div>
        <p class="text-gray-400 text-sm mb-8 border-b border-gray-700 pb-8">
          Lý tưởng cho cá nhân, freelancer hoặc team sales mới bắt đầu tiếp cận lead B2B.
        </p>
        <ul class="space-y-4 mb-8">
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            <strong>20.000 Data Boss</strong> chất lượng cơ bản
          </li>
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            Tặng 500 ZNS miễn phí
          </li>
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            Support qua Zalo cơ bản
          </li>
        </ul>
        <a href="#dang-ky" class="block w-full py-3 px-4 bg-gray-700 text-white text-center font-semibold rounded-lg hover:bg-gray-600 transition">
          Đăng ký Gói Starter
        </a>
      </div>

      <!-- Gói Pro -->
      <div class="w-full max-w-md bg-gray-800 border border-gray-700 rounded-2xl p-8 hover:border-gray-500 transition">
        <h3 class="text-xl font-semibold text-gray-300 mb-2">Gói Pro</h3>
        <div class="flex items-baseline gap-1 mb-6">
          <span class="text-4xl font-bold text-white">15.000.000</span>
          <span class="text-gray-400">VNĐ</span>
        </div>
        <p class="text-gray-400 text-sm mb-8 border-b border-gray-700 pb-8">Dành cho cá nhân hoặc team sales
          nhỏ muốn tiếp cận khách hàng tiềm năng.</p>
        <ul class="space-y-4 mb-8">
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            50.000 Data Boss chất lượng</li>
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            Tặng 1.000 ZNS miễn phí</li>
          <li class="flex items-center text-gray-300"><i class="fas fa-check text-brand-blue mr-3"></i>
            Support qua Zalo</li>
        </ul>
        <a href="#dang-ky" class="block w-full py-3 px-4 bg-gray-700 text-white text-center font-semibold rounded-lg hover:bg-gray-600 transition">
          Đăng ký Gói Pro
        </a>
      </div>

      <!-- Gói Business (giữ nổi bật) -->
      <div class="w-full max-w-md bg-white text-gray-900 rounded-2xl p-8 border-4 border-brand-blue relative transform md:-translate-y-4 shadow-2xl shadow-blue-900/50">
        <div class="absolute top-0 right-0 bg-brand-blue text-white text-xs font-bold px-3 py-1 rounded-bl-lg rounded-tr-lg">
          PHỔ BIẾN NHẤT
        </div>
        <h3 class="text-xl font-semibold text-brand-blue mb-2">Gói Business</h3>
        <div class="flex items-baseline gap-1 mb-6">
          <span class="text-5xl font-bold text-gray-900">39.000.000</span>
          <span class="text-gray-500">VNĐ</span>
        </div>
        <p class="text-gray-500 text-sm mb-8 border-b border-gray-200 pb-8">Giải pháp toàn diện cho doanh
          nghiệp muốn thống lĩnh thị trường.</p>
        <ul class="space-y-4 mb-8">
          <li class="flex items-center"><i class="fas fa-check-circle text-brand-blue mr-3"></i>
            <strong>200.000 Data Boss</strong> (Full info)
          </li>
          <li class="flex items-center"><i class="fas fa-check-circle text-brand-blue mr-3"></i> Tặng
            5.000 ZNS + Brandname</li>
          <li class="flex items-center"><i class="fas fa-check-circle text-brand-blue mr-3"></i> Tích hợp
            Auto-Call System</li>
          <li class="flex items-center"><i class="fas fa-check-circle text-brand-blue mr-3"></i> Support
            1:1 Ưu tiên</li>
        </ul>
        <a href="#dang-ky" class="block w-full py-4 px-4 bg-hero-gradient text-white text-center font-bold rounded-lg hover:shadow-lg hover:opacity-95 transition">
          Đăng ký Gói Business ngay
        </a>
      </div>
    </div>
  </div>
</section>

<section id="dang-ky" class="py-24 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <div class="md:w-5/12 bg-hero-gradient p-10 text-white flex flex-col justify-between">
                <div>
                    <h3 class="font-display font-bold text-2xl mb-4">Bắt đầu chốt Deal ngay hôm nay</h3>
                    <p class="text-blue-100 mb-6">Để lại thông tin, chuyên viên của Chào Sếp sẽ demo trực tiếp dữ
                        liệu cho bạn trong vòng 30 phút.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-4">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64"
                            alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=64&h=64"
                            alt="">
                        <img class="w-10 h-10 rounded-full border-2 border-white"
                            src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=64&h=64"
                            alt="">
                    </div>
                    <p class="text-sm font-medium text-white">+2 Triệu Sếp Việt Nam chỉ từ 150đ</p>
                </div>
            </div>

            <div class="md:w-7/12 p-10">
                <?php $form = ActiveForm::begin([
                    'id' => 'consultation-form',
                    'options' => ['class' => 'space-y-6'],
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'errorOptions' => ['class' => 'text-red-600 text-sm mt-1'],
                    ],
                ]); ?>

                    <?= $form->field($model, 'email')->textInput([
                        'placeholder' => 'vi-du@congty.com',
                        'class' => 'mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition'
                    ])->label('Email công ty <span class="text-red-500">*</span>', ['class' => 'block text-sm font-medium text-gray-700']) ?>

                    <?= $form->field($model, 'phone')->textInput([
                        'placeholder' => '0912 xxx xxx',
                        'class' => 'mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition'
                    ])->label('Số điện thoại (Zalo) <span class="text-red-500">*</span>', ['class' => 'block text-sm font-medium text-gray-700']) ?>

                    <?= $form->field($model, 'company')->textInput([
                        'placeholder' => 'Bất động sản, Bảo hiểm, Giáo dục...',
                        'class' => 'mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition'
                    ])->label('Tên công ty / Lĩnh vực kinh doanh', ['class' => 'block text-sm font-medium text-gray-700']) ?>

                    <?= $form->field($model, 'industry')->textInput([
                        'placeholder' => 'Ví dụ: Bất động sản, Bảo hiểm, F&B... (tùy chọn)',
                        'class' => 'mt-1 block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition'
                    ])->label('Lĩnh vực chi tiết (tùy chọn)', ['class' => 'block text-sm font-medium text-gray-700']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Nhận tư vấn & Demo miễn phí ngay', [
                            'class' => 'w-full py-4 px-6 bg-blue-900 text-white font-bold text-lg rounded-lg hover:bg-blue-800 transition transform hover:-translate-y-1 shadow-lg'
                        ]) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>