<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Review;
use App\Models\ContactMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        User::updateOrCreate(
            ['email' => 'admin@vision-medical.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed Settings
        $settings = [
            'store_name' => 'فيجن ميديكال | Vision Medical',
            'store_name_ar' => 'فيجن ميديكال للأجهزة الطبية',
            'store_name_en' => 'Vision Medical for Devices',
            'store_email' => 'info@vision-medical.com',
            'store_phone' => '+20 100 123 4567',
            'whatsapp' => '201001234567', // WhatsApp format without +
            'maintenance_phone' => '+20 111 765 4321',
            'maintenance_whatsapp' => '201117654321', // WhatsApp format without +
            'about_us_title' => 'من نحن - فيجن ميديكال',
            'about_us_title_ar' => 'من نحن - فيجن ميديكال',
            'about_us_title_en' => 'About Us - Vision Medical',
            'about_us_content' => 'نحن في فيجن ميديكال (Vision Medical) نوفر أحدث وأجود الأجهزة والمستلزمات الطبية للعيادات والمستشفيات والاستخدام المنزلي. نلتزم بأعلى معايير الجودة العالمية ونطمح لتسهيل الحصول على الرعاية الصحية المتكاملة لجميع عملائنا من خلال تقديم منتجات معتمدة وموثوقة بنسبة 100%. تأسست شركتنا لتكون الشريك الأول في توفير الحلول الطبية المتقدمة.',
            'about_us_content_ar' => 'نحن في فيجن ميديكال (Vision Medical) نوفر أحدث وأجود الأجهزة والمستلزمات الطبية للعيادات والمستشفيات والاستخدام المنزلي. نلتزم بأعلى معايير الجودة العالمية ونطمح لتسهيل الحصول على الرعاية الصحية المتكاملة لجميع عملائنا من خلال تقديم منتجات معتمدة وموثوقة بنسبة 100%. تأسست شركتنا لتكون الشريك الأول في توفير الحلول الطبية المتقدمة.',
            'about_us_content_en' => 'We at Vision Medical provide the latest and finest medical equipment and supplies for clinics, hospitals, and home use. We commit to the highest international quality standards and aspire to facilitate integrated healthcare for all our clients by providing 100% certified and reliable products.',
            'footer_text' => 'جميع الحقوق محفوظة © فيجن ميديكال 2026. نسعى دائماً لتقديم الأفضل لصحتكم.',
            'footer_text_ar' => 'جميع الحقوق محفوظة © فيجن ميديكال 2026. نسعى دائماً لتقديم الأفضل لصحتكم.',
            'footer_text_en' => 'All rights reserved © Vision Medical 2026. We always strive to provide the best for your health.',
            'company_map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110502.61186196237!2d31.188339176313795!3d30.059483810452335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e84d3b7d!2sCairo%2C%20Cairo%20Governorate%2C%20Egypt!5e0!3m2!1sen!2seg!4v1717540000000!5m2!1sen!2seg',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Seed Categories
        $categoriesData = [
            [
                'name' => ['ar' => 'الأجهزة التشخيصية', 'en' => 'Diagnostic Devices'],
                'slug' => 'diagnostic-devices',
                'description' => ['ar' => 'أجهزة قياس الضغط، السكر، الحرارة وأجهزة التشخيص الدقيقة.', 'en' => 'Blood pressure, glucose, temperature monitors and precision diagnostic tools.'],
                'image' => 'https://images.unsplash.com/photo-1603398938378-e54eab446dde?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => ['ar' => 'المستلزمات الطبية', 'en' => 'Medical Supplies'],
                'slug' => 'medical-supplies',
                'description' => ['ar' => 'كمامات، قفازات، معقمات وأدوات الرعاية اليومية الطبية.', 'en' => 'Masks, gloves, sanitizers and daily medical care tools.'],
                'image' => 'https://images.unsplash.com/photo-1584515901387-aee001d9f56a?auto=format&fit=crop&w=600&q=80',
            ],
            [
                'name' => ['ar' => 'العيون والبصريات', 'en' => 'Ophthalmology & Optics'],
                'slug' => 'ophthalmology-optics',
                'description' => ['ar' => 'عدسات، قطرات عيون وأجهزة فحص النظر المتطورة.', 'en' => 'Lenses, eye drops and advanced vision exam equipment.'],
                'image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=600&q=80',
            ]
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Seed Brands
        $brandsData = [
            [
                'name' => ['ar' => 'أومرون (Omron)', 'en' => 'Omron'],
                'slug' => 'omron',
                'description' => ['ar' => 'الشركة الرائدة عالمياً في أجهزة قياس ضغط الدم ومراقبة الصحة.', 'en' => 'The global leader in blood pressure monitors and health tracking.'],
                'image' => '/images/brands/omron_logo.png',
            ],
            [
                'name' => ['ar' => 'بيورير (Beurer)', 'en' => 'Beurer'],
                'slug' => 'beurer',
                'description' => ['ar' => 'منتجات ألمانية ذات جودة عالية متخصصة في الصحة والعافية.', 'en' => 'German high quality products specializing in health and wellness.'],
                'image' => 'https://images.unsplash.com/photo-1530026405186-ed1ea0ac7a63?auto=format&fit=crop&w=200&q=80',
            ],
            [
                'name' => ['ar' => 'فيليبس ميديكال (Philips)', 'en' => 'Philips Medical'],
                'slug' => 'philips-medical',
                'description' => ['ar' => 'أجهزة التنفس والرعاية الصحية والمستلزمات الطبية المتطورة.', 'en' => 'Advanced respiratory, healthcare and medical equipment.'],
                'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=200&q=80',
            ]
        ];

        $brands = [];
        foreach ($brandsData as $brnd) {
            $brands[] = Brand::updateOrCreate(['slug' => $brnd['slug']], $brnd);
        }

        // 5. Seed Products
        $productsData = [
            [
                'name' => ['ar' => 'جهاز قياس ضغط الدم من العضد Omron M3', 'en' => 'Omron M3 Upper Arm Blood Pressure Monitor'],
                'slug' => 'omron-m3-blood-pressure-monitor',
                'description' => ['ar' => 'جهاز رقمي بالكامل لقياس ضغط الدم مع تقنية IntelliSense لدقة متناهية وقراءة سهلة وسريعة.', 'en' => 'Fully digital blood pressure monitor with IntelliSense technology for precision and quick readings.'],
                'details' => [
                    'ar' => "المميزات الفنية:\n- تقنية IntelliSense للنفخ المريح والقياس الدقيق.\n- كاشف عدم انتظام ضربات القلب.\n- ذاكرة تتسع لـ 60 قراءة لشخصين.\n- مؤشر LED لارتفاع ضغط الدم.\n- يشتمل على كفة متوسطة الحجم (22-42 سم).",
                    'en' => "Technical Features:\n- IntelliSense technology for comfortable inflation and precise measurement.\n- Irregular heartbeat detector.\n- Memory capacity of 60 readings for two users.\n- LED hypertension indicator.\n- Includes a medium cuff (22-42 cm)."
                ],
                'price' => 299.00,
                'image' => '/images/products/omron_m3.png',
                'category_id' => $categories[0]->id, // الأجهزة التشخيصية
                'brand_id' => $brands[0]->id,       // Omron
                'in_stock' => true,
            ],
            [
                'name' => ['ar' => 'جهاز قياس نسبة السكر في الدم Beurer GL50', 'en' => 'Beurer GL50 Blood Glucose Monitor'],
                'slug' => 'beurer-gl50-blood-glucose-monitor',
                'description' => ['ar' => 'جهاز 3 في 1 متطور للغاية يضم جهاز القياس ووخز الإصبع ووصلة USB لنقل البيانات مباشرة للكمبيوتر.', 'en' => 'Highly advanced 3-in-1 device combining blood glucose monitor, lancing device, and USB adapter.'],
                'details' => [
                    'ar' => "المميزات الفنية:\n- سهل الاستخدام مع شرائط اختبار بدون ترميز.\n- كمية دم صغيرة جداً مطلوبة للقياس (0.6 ميكرولتر).\n- زمن قياس سريع جداً (5 ثوانٍ).\n- شاشة عرض بإضاءة خلفية زرقاء واضحة.\n- يحسب متوسط القيم لـ 7 و 14 و 30 و 90 يوماً.",
                    'en' => "Technical Features:\n- Easy to use with coding-free test strips.\n- Minimal blood volume required (0.6 microliters).\n- Fast measurement time (5 seconds).\n- Clear blue backlit display.\n- Calculates averages for 7, 14, 30, and 90 days."
                ],
                'price' => 189.00,
                'image' => '/images/products/beurer_gl50.png',
                'category_id' => $categories[0]->id, // الأجهزة التشخيصية
                'brand_id' => $brands[1]->id,       // Beurer
                'in_stock' => true,
            ],
            [
                'name' => ['ar' => 'جهاز استنشاق البخار النيبولايزر Philips Innospire', 'en' => 'Philips Innospire Nebulizer Compressor System'],
                'slug' => 'philips-innospire-nebulizer',
                'description' => ['ar' => 'جهاز نيبولايزر منزلي فعال جداً لعلاج الربو والاضطرابات التنفسية، مصمم للاستخدام المستمر والآمن.', 'en' => 'Highly effective home nebulizer for asthma and respiratory disorders, designed for safe continuous use.'],
                'details' => [
                    'ar' => "المميزات الفنية:\n- نظام تنفسي نشط ذو كفاءة عالية لتوصيل الدواء بسرعة.\n- حجم صغير وخفيف الوزن لسهولة التنقل به.\n- يشتمل على قناع للكبار وقناع للأطفال وأنبوب هواء.\n- سهل التشغيل بضغطة زر واحدة.\n- صوت هادئ ومناسب للاستخدام في الليل.",
                    'en' => "Technical Features:\n- Highly efficient active breathing system for fast drug delivery.\n- Compact size and lightweight for easy transport.\n- Includes adult mask, child mask and air tubing.\n- Simple single-button operation.\n- Quiet sound suitable for nighttime use."
                ],
                'price' => 350.00,
                'image' => '/images/products/philips_nebulizer.png',
                'category_id' => $categories[1]->id, // المستلزمات الطبية
                'brand_id' => $brands[2]->id,       // Philips
                'in_stock' => true,
            ],
            [
                'name' => ['ar' => 'علبة كمامات طبية عالية الجودة 50 حبة', 'en' => 'Premium Medical Face Masks 50pcs Box'],
                'slug' => 'premium-medical-masks-50pcs',
                'description' => ['ar' => 'كمامات طبية ثلاثية الطبقات مع فلتر حماية عالي الكفاءة، مرنة ومريحة للاستخدام الطويل واليومي.', 'en' => 'Three-layer medical face masks with high efficiency protective filter, flexible and comfortable for daily use.'],
                'details' => [
                    'ar' => "المميزات الفنية:\n- ثلاث طبقات حماية مع طبقة وسطى مفلترة (Melt-blown).\n- حلقات مطاطية مريحة للأذن ودعامة أنف معدنية قابلة للتعديل.\n- خالية من الألياف الزجاجية ومضادة للحساسية.\n- معتمدة للاستخدام في العيادات والمستشفيات والبيئات العامة.\n- نسبة كفاءة فلترة البكتيريا (BFE) تتجاوز 98%.",
                    'en' => "Technical Features:\n- Three-layer protection with Melt-blown filter layer.\n- Comfortable elastic ear loops and adjustable metallic nose clip.\n- Fiberglass-free and hypoallergenic.\n- Certified for use in clinics, hospitals and public spaces.\n- Bacterial Filtration Efficiency (BFE) exceeds 98%."
                ],
                'price' => 25.00,
                'image' => '/images/products/medical_masks.png',
                'category_id' => $categories[1]->id, // المستلزمات الطبية
                'brand_id' => $brands[1]->id,       // Beurer
                'in_stock' => true,
            ],
            [
                'name' => ['ar' => 'جهاز فحص ضغط العين الرقمي الاحترافي', 'en' => 'Professional Digital Eye Tonometer Monitor'],
                'slug' => 'professional-digital-tonometer',
                'description' => ['ar' => 'جهاز متطور محمول لفحص ضغط العين بدقة متناهية ودون الحاجة للتخدير، مثالي للعيادات المتخصصة.', 'en' => 'Advanced portable eye tonometer to screen intraocular pressure precisely without anesthesia, ideal for clinics.'],
                'details' => [
                    'ar' => "المميزات الفنية:\n- قياس سريع ولطيف دون ألم أو تلامس مباشر مؤذٍ.\n- شاشة عرض رقمية ملونة لعرض النتائج مباشرة.\n- تخزين تلقائي لنتائج المرضى مع إمكانية الطباعة اللاسلكية.\n- بطارية قابلة لإعادة الشحن تدوم طويلاً.\n- دقة إكلينيكية عالية مطابقة للمعايير الطبية الدولية للعيون.",
                    'en' => "Technical Features:\n- Fast and gentle measurement without pain or uncomfortable direct contact.\n- Digital color display showing results instantly.\n- Automated storage of patient results with wireless printing support.\n- Long lasting rechargeable battery.\n- High clinical accuracy matching international ophthalmic standards."
                ],
                'price' => 4500.00,
                'image' => '/images/products/eye_tonometer.png',
                'category_id' => $categories[2]->id, // العيون والبصريات
                'brand_id' => $brands[2]->id,       // Philips
                'in_stock' => true,
            ]
        ];

        foreach ($productsData as $prod) {
            $product = Product::updateOrCreate(['slug' => $prod['slug']], $prod);

            // Seed some approved reviews for each product
            Review::create([
                'product_id' => $product->id,
                'reviewer_name' => 'أحمد العتيبي',
                'rating' => 5,
                'comment' => 'منتج ممتاز جداً وجودة التصنيع ممتازة. أنصح بشرائه بشدة، واستخدامه سهل للغاية.',
                'is_approved' => true,
                'created_at' => now()->subDays(rand(1, 10)),
            ]);

            Review::create([
                'product_id' => $product->id,
                'reviewer_name' => 'د. سارة الأحمد',
                'rating' => 4,
                'comment' => 'جهاز عملي ومطابق للمواصفات الطبية المطلوبة في العيادات. التوصيل كان سريعاً والتعامل راقٍ.',
                'is_approved' => true,
                'created_at' => now()->subDays(rand(1, 10)),
            ]);

            // Add one review pending approval to test admin notification system
            Review::create([
                'product_id' => $product->id,
                'reviewer_name' => 'عميل تجريبي',
                'rating' => 3,
                'comment' => 'المنتج جيد ولكن يحتاج لشرح أوفى عن طريقة الاستخدام في كتيب التعليمات.',
                'is_approved' => false,
                'created_at' => now(),
            ]);
        }

        // 6. Seed some Contact Messages
        ContactMessage::create([
            'name' => 'محمد الحربي',
            'email' => 'm.harbi@example.com',
            'subject' => 'استفسار عن توافر جهاز قياس ضغط أومرون بالجملة',
            'message' => 'السلام عليكم، نود الاستفسار عن توافر كمية 50 حبة من جهاز قياس ضغط الدم أومرون M3 وهل توجد خصومات للمستوصفات الطبية؟ شكراً لكم.',
            'is_read' => false,
            'created_at' => now()->subHours(2),
        ]);

        ContactMessage::create([
            'name' => 'مستشفى الشفاء الدولي',
            'email' => 'info@shifa-hospital.com',
            'subject' => 'طلب صيانة جهاز فحص ضغط العين',
            'message' => 'مرحباً، قمنا بشراء جهاز فحص ضغط العين الرقمي من متجركم قبل 3 أشهر، ونرغب في التنسيق لزيارة مهندس الصيانة الدورية لفحص ومعايرة الجهاز. يرجى التواصل معنا.',
            'is_read' => true,
            'created_at' => now()->subDays(2),
        ]);
    }
}
