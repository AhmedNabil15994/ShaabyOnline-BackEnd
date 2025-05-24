<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\Entities\Permission;
use DB;

class PermissionsTableSeeder extends Seeder
{
    protected $mapKey = [
        "show" => [
            "lang" => [
                "ar" => "عرض",
                "en" => "show",
            ]
        ],
        "add" => [
            "lang" => [
                "ar" => "إضافة",
                "en" => "add"
            ]
        ],
        "edit" => [
            "lang" => [
                "ar" => "تعديل",
                "en" => "edit"
            ]
        ],
        "delete" => [
            "lang" => [
                "ar" => "حذف",
                "en" => "delete"
            ]
        ],
    ];

    private $permissions = [
        'dashboard_access' => [
            'category' => ['ar' => 'لوحة التحكم الموظفين', 'en' => 'Admins Dashboard Access'],
            'single' => true,
            'name' => 'dashboard_access',
            'display_name' => [
                'en' => 'Dashboard Access',
                'ar' => 'صلاحية المرور للوحة تحكم الموظفين'
            ],
        ],
        'seller_access' => [
            'category' => ['ar' => 'لوحة تحكم البائعين', 'en' => 'Seller Dashboard Access'],
            'single' => true,
            'name' => 'seller_access',
            'display_name' => [
                'en' => 'Seller Dashboard Access',
                'ar' => 'صلاحية المرور للوحة تحكم البائعين'
            ],
        ],
        'driver_access' => [
            'category' => ['ar' => 'لوحة تحكم السائقين', 'en' => 'Driver Dashboard Access'],
            'single' => true,
            'name' => 'driver_access',
            'display_name' => [
                'en' => 'Driver Dashboard Access',
                'ar' => 'صلاحية المرور للوحة تحكم السائقين'
            ],
        ],
        'statistics' => [
            'category' => ['ar' => 'لوحة التحكم', 'en' => 'access'],
            'single' => true,
            'name' => 'statistics',
            'display_name' => [
                'en' => 'Show Statistics',
                'ar' => 'عرض الإحصائيات',
            ],
        ],

        'roles' => [
            'display_name' => ['ar' => 'الصلاحيات', 'en' => 'roles'],
            'single' => false
        ],
        'users' => [
            'display_name' => ['ar' => 'العملاء', 'en' => 'users'],
            'single' => false
        ],
        'admins' => [
            'display_name' => ['ar' => 'المدراء', 'en' => 'admins'],
            'single' => false
        ],
        'countries' => [
            'display_name' => ['ar' => 'الدول', 'en' => 'countries'],
            'single' => false
        ],
        'cities' => [
            'display_name' => ['ar' => 'المدن', 'en' => 'cities'],
            'single' => false
        ],
        'states' => [
            'display_name' => ['ar' => 'المناطق', 'en' => 'states'],
            'single' => false
        ],
        'categories' => [
            'display_name' => ['ar' => 'الأقسام', 'en' => 'categories'],
            'single' => false
        ],
        'products' => [
            'display_name' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => false
        ],
        'order_statuses' => [
            'display_name' => ['ar' => 'حالات الطلب', 'en' => 'order statuses'],
            'single' => false
        ],
        'orders' => [
            'display_name' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => false
        ],
        'delivery_charges' => [
            'display_name' => ['ar' => 'قيم التوصيل', 'en' => 'delivery charges'],
            'single' => false
        ],
        'companies' => [
            'display_name' => ['ar' => 'شركات التوصيل', 'en' => 'companies'],
            'single' => false
        ],
        'options' => [
            'display_name' => ['ar' => 'إختلافات المنتجات', 'en' => 'options'],
            'single' => false
        ],
        'drivers' => [
            'display_name' => ['ar' => 'السائقين', 'en' => 'drivers'],
            'single' => false
        ],
        'slider' => [
            'display_name' => ['ar' => 'الإسلايدر', 'en' => 'sliders'],
            'single' => false
        ],
        'coupon' => [
            'display_name' => ['ar' => 'الكوبونات', 'en' => 'coupons'],
            'single' => false
        ],
        'tags' => [
            'display_name' => ['ar' => 'الوسوم', 'en' => 'tags'],
            'single' => false
        ],
        'search_keywords' => [
            'display_name' => ['ar' => 'كلمات البحث', 'en' => 'search keywords'],
            'single' => false
        ],
        'pages' => [
            'display_name' => ['ar' => 'الصفحات', 'en' => 'pages'],
            'single' => false
        ],
        'packages' => [
            'display_name' => ['ar' => 'باقات المتاجر', 'en' => 'packages'],
            'single' => false
        ],
        'subscriptions' => [
            'display_name' => ['ar' => 'إشتراكات المتاجر', 'en' => 'subscriptions'],
            'single' => false
        ],
        'sections' => [
            'display_name' => ['ar' => 'أنواع المتاجر', 'en' => 'sections'],
            'single' => false
        ],
        'vendor_categories' => [
            'display_name' => ['ar' => 'أقسام المتاجر', 'en' => 'vendor categories'],
            'single' => false
        ],
        'vendors' => [
            'display_name' => ['ar' => 'المتاجر', 'en' => 'vendors'],
            'single' => false
        ],
        'sellers' => [
            'display_name' => ['ar' => 'البائعين', 'en' => 'sellers'],
            'single' => false
        ],
        'addon_categories' => [
            'display_name' => ['ar' => 'أقسام الإضافات', 'en' => 'addon categories'],
            'single' => false
        ],
        'addon_options' => [
            'display_name' => ['ar' => 'الإضافات', 'en' => 'addon options'],
            'single' => false
        ],
        'home_categories' => [
            'display_name' => ['ar' => 'أقسام الصفحة الرئيسية', 'en' => 'home categories'],
            'single' => false
        ],
        'advertising' => [
            'display_name' => ['ar' => 'الإعلانات', 'en' => 'advertising'],
            'single' => false
        ],
        'notifications' => [
            'display_name' => ['ar' => 'الإشعارات', 'en' => 'notifications'],
            'single' => false
        ],
        'user_addresses' => [
            'display_name' => ['ar' => 'عناوين العميل', 'en' => 'User Addresses'],
            'single' => false
        ],
        'apphomes' => [
            'display_name' => ['ar' => 'الصفحة الرئيسية للموقع', 'en' => 'Home Page'],
            'single' => false
        ],

        // single products
        'edit_products_price' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_price',
            'display_name' => [
                'en' => 'Edit Products Price',
                'ar' => 'تعديل سعر المنتج ',
            ],
        ],

        'edit_products_qty' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_qty',
            'display_name' => [
                'en' => 'Edit Products Quantity',
                'ar' => 'تعديل كمية المنتج',
            ],
        ],

        'edit_products_title' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_title',
            'display_name' => [
                'en' => 'Edit Products Title',
                'ar' => 'تعديل عنوان المنتج',
            ],
        ],

        'edit_products_description' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_description',
            'display_name' => [
                'en' => 'Edit Products Description',
                'ar' => 'تعديل وصف المنتج',
            ],
        ],

        'edit_products_image' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_image',
            'display_name' => [
                'en' => 'Edit Products Image',
                'ar' => 'تعديل صورة المنتج',
            ],
        ],

        'edit_products_gallery' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_gallery',
            'display_name' => [
                'en' => 'Edit Products Gallery',
                'ar' => 'تعديل صور المنتج',
            ],
        ],

        'edit_products_category' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'edit_products_category',
            'display_name' => [
                'en' => 'Edit Products Category',
                'ar' => 'تعديل قسم المنتج',
            ],
        ],

        'show_product_addons' => [
            'category' => ['ar' => 'الإضافات', 'en' => 'addons'],
            'single' => true,
            'name' => 'show_product_addons',
            'display_name' => [
                'en' => 'Edit Product Addons',
                'ar' => 'عرض إضافات المنتج',
            ],
        ],

        'pending_products_for_approval' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'pending_products_for_approval',
            'display_name' => [
                'en' => 'Add Product Without Approval',
                'ar' => 'اضافة منتج دون الموافقة',
            ],
        ],

        'review_products' => [
            'category' => ['ar' => 'المنتجات', 'en' => 'products'],
            'single' => true,
            'name' => 'review_products',
            'display_name' => [
                'en' => 'Review Products',
                'ar' => 'مراجعة المنتجات',
            ],
        ],
        //////////////// end single product permissions

        // repors


        'show_product_sale_reports' => [
            'category' => ['ar' => 'التقارير', 'en' => 'reports'],
            'single' => true,
            'name' => 'show_product_sale_reports',
            'display_name' => [
                "ar" => "عرض تقارير المنتجات المباعة",
                "en" => "Show Product Sale Reports"
            ]
        ],

        'show_order_sale_reports' => [
            'category' => ['ar' => 'التقارير', 'en' => 'reports'],
            'single' => true,
            'name' => 'show_order_sale_reports',
            'display_name' => [
                "ar" => "عرض تقارير مبيعات الطلبات",
                "en" => "Show Order Sale Reports "
            ]
        ],

        'show_product_stock_reports' => [
            'category' => ['ar' => 'التقارير', 'en' => 'reports'],
            'single' => true,
            'name' => 'show_product_stock_reports',
            'display_name' => [
                "ar" => "عرض تقارير مخزون المنتجات",
                "en" => "Show Product Stock Reports"
            ]
        ],
        //////////////// end single reports permissions

        // single order

        'show_all_orders' => [
            'category' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => true,
            'name' => 'show_all_orders',
            'display_name' => [

                "ar" => "عرض جميع العمليات",
                "en" => "Show All Orders"
            ],
        ],

        'show_order_details_tab' => [
            'category' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => true,
            'name' => 'show_order_details_tab',
            'display_name' => [

                "ar" => "عرض نافذة تفاصيل الطلب",
                "en" => "Show Order Details Tab"
            ],
        ],

        'show_order_change_status_tab' => [
            'category' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => true,
            'name' => 'show_order_change_status_tab',
            'display_name' => [

                "ar" => "عرض نافذة تغيير حالة الطلب",
                "en" => "Show Change Order Status Tab"
            ],
        ],

        'refund_order' => [
            'category' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => true,
            'name' => 'refund_order',
            'display_name' => [

                "ar" => "إسترجاع الطلب",
                "en" => "Refund Order"
            ],
        ],

        'confirm_payment_order' => [
            'category' => ['ar' => 'الطلبات', 'en' => 'orders'],
            'single' => true,
            'name' => 'confirm_payment_order',
            'display_name' => [

                "ar" => "تأكيد دفع الطلب",
                "en" => "Confirm payment Order"
            ],
        ],
        
        //////////////// end single orders permissions


        'show_client_settings' => [
            'category' => ['ar' => 'الإعدادات العامة', 'en' => 'client settings'],
            'single' => true,
            'name' => 'show_client_settings',
            'display_name' => [
                'en' => 'Show',
                'ar' => 'عرض ',
            ],
        ],
    ];

    public function run()
    {
        foreach ($this->permissions as $route => $options) {
            if (isset($options['single']) && $options['single']) {
                $this->createPermission($options['name'], $options['category'] ?? null, $options['display_name']);
            } else {
                foreach ($this->mapKey as $key => $value) {
                    $this->createPermission($key . "_" . $route, $options['display_name'], $value['lang']);
                }
            }
        }
    }

    public function createPermission($name, $display_name, $description)
    {
        $perm = Permission::where([
            "name" => $name,
        ])->first();

        if ($perm) {
            $perm->update([
                "name" => $name,
                "description" => $description ?? null,
                'display_name' => $display_name,
            ]);
        } else {
            Permission::create([
                "name" => $name,
                "description" => $description ?? null,
                'display_name' => $display_name,
            ]);
        }
    }
}
