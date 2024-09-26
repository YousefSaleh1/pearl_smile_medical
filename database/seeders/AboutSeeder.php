<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        About::create([
            'title_en' =>'About Us',
            'title_ar' =>'حولنا',
            'description_en' =>' At Pearl Smile, we are committed to providing complete health and beauty services under  one roof. Our center is equipped with the latest technology and a highly qualified team to  ensure the highest quality of care. Whether you are seeking comprehensive skin care  treatments, cosmetic dentistry, gynecology services, or laser hair removal, we put your  comfort and results first.',
            'description_ar' =>'في Pearl Smile، نحن ملتزمون بتقديم خدمات الصحة والجمال الكاملة تحت سقف واحد. تم تجهيز مركزنا بأحدث التقنيات وفريق مؤهل تأهيلا عاليا لضمان أعلى مستويات الجودة في الرعاية. سواء كنت تبحث عن علاجات شاملة للعناية بالبشرة، أو طب الأسنان التجميلي، أو خدمات أمراض النساء، أو إزالة الشعر بالليزر، فإننا نضع راحتك ونتائجك في المقام الأول.',
            'email' =>'preal@gmail.com',
            'facebook_link' =>'preal@facebook.com',
            'instegram_link' =>'preal@instagram.com',
            'whatsapp' =>'+234809820938',
            'phone_numbers' =>'+434234234324',
            'address_en' =>'Entifadah Rd - Al Majaz 3 - Al Majaz - Sharjah - United Arab Emirates',
            'address_ar' =>'طريق الانتفاضة - المجاز 3 - المجاز - الشارقة - الإمارات العربية المتحدة'
        ]);
    }
}
