<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // مسح البيانات القديمة إن وجدت للبدء من جديد
        OrderStatus::truncate();

        $statuses = [
            [
                'name_ar' => 'تحت المراجعة',
                'name_en' => 'Under Review',
                'name_zh' => '审核中',
                'image'   => 'order_statuses/under_review.png',
            ],
            [
                'name_ar' => 'تحت الموافقة',
                'name_en' => 'Pending Approval',
                'name_zh' => '待批准',
                'image'   => 'order_statuses/pending_approval.png',
            ],
            [
                'name_ar' => 'تمت الموافقة',
                'name_en' => 'Approved',
                'name_zh' => '已批准',
                'image'   => 'order_statuses/approved.png',
            ],
            [
                'name_ar' => 'الرفض',
                'name_en' => 'Rejected',
                'name_zh' => '已拒绝',
                'image'   => 'order_statuses/rejected.png',
            ],
            [
                'name_ar' => 'مراجعة المكتب',
                'name_en' => 'Office Review',
                'name_zh' => '办公室审查',
                'image'   => 'order_statuses/office_review.png',
            ],
            [
                'name_ar' => 'يتم تجهيز او تصنيع الطلب',
                'name_en' => 'Manufacturing / Processing',
                'name_zh' => '正在制造 / 处理中',
                'image'   => 'order_statuses/manufacturing.png',
            ],
            [
                'name_ar' => 'طلبك جاهز يرجى مراجعة المكتب الخاص بك',
                'name_en' => 'Order Ready, please process with your office',
                'name_zh' => '订单已准备就绪，请联系您的办公室',
                'image'   => 'order_statuses/ready.png',
            ],
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
