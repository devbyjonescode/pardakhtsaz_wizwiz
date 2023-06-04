<p align="center">
  <a href="https://github.com/wizwizdev/wizwizxui-timebot" target="_blank" rel="noopener noreferrer">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://user-images.githubusercontent.com/27927279/227711552-d2bc1089-5666-477b-9be7-d7e50a5286dc.png">
      <img width="200" height="200" src="https://user-images.githubusercontent.com/27927279/227711552-d2bc1089-5666-477b-9be7-d7e50a5286dc.png">
    </picture>
  </a>
</p>

<p align="center">
	<a href="./README.md">
	English
	</a>
	/
	<a href="./README-fa.md">
	فارسی
	</a>

</p>

<h1 align="center"/>ویزویز</h1>

<p align="center">
فروش آسان با <a href="https://github.com/wizwizdev/wizwizxui-timebot">ویزویز</a> نصب فقط با یک دستور
</p>

<p align="center">
ویزویز یک ربات قدرتمند و حرفه ای است که از چندین نوع پنل پشتیبانی می کند و بهترین گزینه برای فروش است، اکثر پروتکل ها را پشتیبانی می کند و نصب آسانی دارد. این ربات برای مردم عزیز ایران آماده شده است. یک جایگزین عالی برای فروش است تا بتوانید به راحتی کار خود را مدیریت کنید.
</p>


<div align=center>

[![Telegram Channel](https://img.shields.io/endpoint?label=Channel&style=flat-square&url=https%3A%2F%2Ftg.sumanjay.workers.dev%2Fwizwizch&color=blue)](https://telegram.dog/wizwizch)
[![Telegram Group](https://img.shields.io/endpoint?color=neon&label=Support%20Group&style=flat-square&url=https%3A%2F%2Ftg.sumanjay.workers.dev%2Fwizwizdev)](https://telegram.dog/wizwizdev)
<img src="https://img.shields.io/github/license/wizwizdev/wizwizxui-timebot?style=flat-square" />
<img src="https://img.shields.io/github/v/release/wizwizdev/wizwizxui-timebot.svg" />
<!-- <img src="https://visitor-badge.glitch.me/badge?page_id=wizwizdev.wizwizdev" />
 -->
</div>

<br>
<br>
    <a align="center">
        <img src="https://github.com/wizwizdev/wizwiz-xui-pro/assets/27927279/c8e45ef9-2b4d-4a3e-aa5a-40df4f61abf3" />
    </a>     
<br>
<br>

# دستور نصب روی Ubuntu-20.4


- اگر سرور شما دسترسی روت ندارد، لطفا با دستور sudo -i دسترسی روت بدهید و سپس نصب کنید
- یک ربات در @botfather ایجاد کنید و آن را استارت کنید
- قبل از نصب حتما ip سرور را روی دامنه تنظیم کنید 
> دستور نصب را در کنسول وارد کرده و موارد مورد نیاز را برای تکمیل نصب وارد کنید.
```
bash <(curl -s https://raw.githubusercontent.com/wizwizdev/wizwizxui-timebot/main/wizwiz.sh)
```
- در مرحله اول «sub.domain.com» یا «domain.com» را بدون https وارد کنید
- ایمیل را وارد کنید
- کلمه y را وارد کنید
- عدد 2 را وارد کنید
- نام کاربری برای دیتابیس را وارد کنید
- رمز عبور برای دیتابیس را وارد کنید
- توکن ربات را وارد کنید
- آیدی عددی ادمین را از @userinfobot بگیرید و وارد کنید
- مجدد «sub.domain.com» یا «domain.com» را بدون https وارد کنید
- بسیار خوب، پیام نصب ( ✅ ربات wizwiz با موفقیت نصب شد! ) به ربات ارسال می شود.

<br>
<br>

## دستور آپدیت ربات - آپدیت پنل - بک آپ - حذف ویزویز

- با هر به روز رسانی و بک آپ، یک اعلان برای ربات مدیر ارسال می شود


```
bash <(curl -s https://raw.githubusercontent.com/wizwizdev/wizwizxui-timebot/main/update.sh)
```


<br>

<hr>

<br>

<h2 align="center">
	<a href="https://t.me/wizwizch/193">آموزش نصب روی سرور ابونتو</a>
</h2>

<br>

<h2 align="center">
	<a href="https://t.me/wizwizch/192">آموزش نصب روی هاست سی پنل</a>
</h2>



<br>
<hr>
<br>


## دستور نصب روی هاست ، از طریق لینک زیر پروژه را دانلود کنید
````
https://github.com/wizwizdev/wizwizxui-timebot/archive/refs/heads/main.zip
````

<br>

# موارد مهم در هاست

### 1- خطای 500 در هاست

> در هاست cpanel بر روی گزینه Select PHP Version کلیک کنید و در قسمت افزونه گزینه های زیر را فعال کنید:
- pdo_mysql
- mysqlnd
- nd_mysqli
> گزینه های زیر را غیرفعال کنید:
- mysqli
- nd_pdo_mysql
#### اگر گزینه زیر آبی است، لطفا آن را فعال کنید:

<br>
     <a align="center">
         <img src="https://user-images.githubusercontent.com/27927279/230842783-16f6d1a5-e726-4533-a57b-98cb04fa8dfc.PNG" />
     </a>
<br>

<br>

### 2- فعال بودن اکستنشن های زیر
- soap ( برای درگاه پرداخت )
- ssh2 ( برای بک آپ گیری از پنل ) برای بعضی هاست ها این مورد وجود نداره و نمیتونین از قابلیت بک اپ استفاده کنین
- fileinfo ( توکن نامعتبر )


<br>


### 3- نکات بعد از نصب


- بعد از نصب حتما پوشه install و فایل createDB.php که داخل پوشه wizwizxui-timebot-main به طور کامل حذف شود



<br>

### 4- کرونجاب برای فایل های زیر

- messagewizwiz.php
- rewardReport.php
- warnusers.php
- backupnutif.php

````
/usr/bin/php -q /home/wizwizro/public_html/wizwizxui-timebot-main/settings/messagewizwiz.php >/dev/null 2>&1
````


- به جای wizwizro باید آدرس مورد نظرتون رو طبق تصویر زیر از هاست بردارید و وارد کنید 


<p align="center">
    <img src="https://user-images.githubusercontent.com/27927279/229339959-3da695e6-eee8-49b0-a520-37552d50090f.PNG" />
</p>



- برای هر کدام از فایل های warnusers.php - rewardReport.php - messagewizwiz.php باید کرون جاب جدا ایجاد کنید ولی برای فایل backupnutif.php فرق می کند که باید به شکل زیر انجام بدید


````
/usr/bin/php -q /home/wizwizro/public_html/اسم_پوشه_پنل/backupnutif.php >/dev/null 2>&1
````


<br>
<hr>
<br>


# سوالات پرتکرار


- ارسال نشدن مشخصات کانکشن : اگه مشخصات کانکشن برای کاربر ارسال نمیشه دقت کنید حتما باید داخل پوشه wizwizxui-timebot-main برید و فایل baseinfo.php رو ویرایش کنین یه جایی ادرس دامنه شما هست و حتما باید مثل نمونه باشه و به جای yourdomain.com باید دامنه خودتون رو بزارید و مشکل حل میشه چون بعضی از دوستان این مورد رو اصلا دقت نمیکنن

````
$botUrl = "https://yourdomain.com/wizwizxui-timebot-main/";
````


- مشکل اجرا نشدن پنل ویزویز در هاست: حتما باید پوشه ربات و پنل کنار هم به این صورت قرار بگیرن


<p align="center">
    <img src="https://github.com/wizwizdev/wizwizxui-timebot/assets/27927279/c875fa9d-66e0-4b23-87be-b6f7c967cf6b.PNG" />
</p>



- درگاه weswap: اگه میخواین از این در این درگاه استفاده کنین باید تو سایت nowpayment با یه ایمیل ثبت نام کنین آدرس کیف پول ترون رو بهش بدید و کلید api رو ازش بگرید و برای nowpayment قرار بدید ( یعنی این گزینه خودکار هم برای nowpayment و هم برای weswap تنظیم میشه، برای weswap باید مبلغ بالای 25 تومن باشه و برای nowpayment هم باید بالای 3.5 دلار اینا باشه وگرنه خطا میگیرید )
- برای قفل اجباری کانال، مطمئن شوید که ربات ادمین کانال است و تمام دسترسی ادمین را به آن بدهید (همه آنها را علامت بزنید)
- اگر پنل ویزویز را روی هاست نصب کردید حتما اکستنشن ssh2 را فعال کنید تا کار بک اپ را انجام دهد.
- برای استفاده از درگاه NowPayment، مبلغ شارژ باید بالای 3.5 دلار باشد زیرا زیر 3.5 دلار قابل پرداخت نیست.
- لوکیش هاست یا لینوکس نباید در ایران میزبانی شود (چون تلگرام در ایران محدود و سانسور شده است)
- اگر از پروتکل تروجان استفاده می کنید، پنل x-ui شما باید از تروجان پشتیبانی کند، در غیر این صورت پنل شما با مشکل مواجه می شود.
- در صورتی که ترافیک باقیمانده سرویس به یک گیگابایت و زمان باقی مانده به یک روز برسد، برای کاربر اعلان ارسال می شود.
- اگر کاربر ظرف 48 ساعت سرویس را تمدید نکند، اعلان حذف سرویس برای کاربر ارسال می شود و سرویس حذف می شود.
- برای ایجاد اکانت تست قیمت را روی 0 قرار دهید، هر کاربر فقط یک بار می تواند اکانت تست را داشته باشد.
- برای استفاده از HTTP و Header در ربات باید مقدار Header Type را روی http قرار دهید و مقدار Host:domain.ir را برای هدر درخواست وارد کنید.
- اگر از reality استفاده می کنیم بعد از ثبت پلن ، لطفا پلن را ویرایش کنید و مقدار dest و servername دلخواه را وارد کنید
- اگر از تانل استفاده میکنید حتما <a href="https://t.me/wizwizch/177">متن</a> داخل کانال را با دقت بخوانید.
- اگر هنگام خرید با خطای ( ارتباط شما با سرور برقرار نیست ) برخوردید حتما <a href="https://t.me/wizwizch/186">ویس</a> داخل کانال را گوش بدید



<br>
<hr>
<br>



# پنل های پشتیبانی شده


- (Niduka Akalanka)
````
bash <(curl -Ls https://raw.githubusercontent.com/NidukaAkalanka/x-ui-english/master/install.sh)
````
- (Sanaei)
````
bash <(curl -Ls https://raw.githubusercontent.com/mhsanaei/3x-ui/master/install.sh)
````
- (Alireza)
````
bash <(curl -Ls https://raw.githubusercontent.com/alireza0/x-ui/master/install.sh)
````
- (Vaxilu)
````
bash <(curl -Ls https://raw.githubusercontent.com/vaxilu/x-ui/master/install.sh)
````

- بقیه پنل ها تست نشده،  می توانید خودتان آن را تست و استفاده کنید


<br>
<hr>
<br>


# حمایت

- Sepe Bank: `5892101222351344`
- Tron (TRX): `TY8j7of18gbMtneB8bbL7SZk5gcntQEemG`
- Bitcoin: `bc1qcnkjnqvs7kyxvlfrns8t4ely7x85dhvz5gqge4`
- Dogecoin: `DMyGMghEh4W55P3VeVHntCN3vYAFtshvVH`



<br>
<hr>
<br>


# امکانات

- درگاه nowpayments - zarinpal - nextpay - weswap
- پشتیبانی از - xtls - tls - reality - Grpc - ws - tcp
- پشتیبانی vless - vmess - trojan
- امکان تمدید سرویس
- اشتراک هوشمند
- وضعیت فیلتر شدن سرورها
- تغییر مکان خودکار
- افزایش حجم و زمان سرویس دهی
- قابلیت پاس کردن
- امکان سفارش طرح مورد نظر توسط کاربر
- احراز هویت شماره تماس ایرانی و خارجی
- پشتیبان گیری از پنل x-ui
- زیر مجموعه و کمیسیون
- کدهای تخفیف و هدیه ایجاد کنید
- امکان ردیابی کاربر
- ایجاد دکمه و پاسخ برای آن
- خروجی پیکربندی با IP یا دامنه های مختلف
- امکان تغییر پروتکل و نوع شبکه
- تنظیم پورت پیکربندی به صورت تصادفی یا خودکار
- کیف پول (امکان شارژ - انتقال موجودی)
- ارسال اعلان عضو جدید در ربات به (ادمین)
- نمایش اطلاعات کاربر (user-admin)
- امکان ارسال پیام خصوصی از ادمین به کاربر
- امکان مدیریت و مشاهده سرورها - دسته بندی ها - پلن ها
- قابلیت مسدود کردن و آزادسازی
- امکان اضافه کردن ادمین
- نمایش موجودی سرورها
- امکان ارسال گزارش درآمد به کانال
- ارسال پیام های عمومی
- پیکربندی های فروخته شده را دریافت کنید
- ایجاد پورت مشترک و پیکربندی پورت اختصاصی
- تست حساب برای کاربران
- قابلیت کارت به کارت
- نمایش حساب های فروخته شده هر طرح
- قابلیت نمایش (لینک نرم افزار)
- ارسال پیام های عمومی با CronJob
- اعلام پایان حجم و زمان پیکربندی (به کاربر)
- قفل اجباری کانال
- امکان دریافت جزئیات لینک
- قابلیت خاموش/روشن (همه ویژگی های ربات)
- اطلاع رسانی اطلاعات خرید + تمدید و ... به صورت کامل به ربات ادمین



<br>
<hr>
<br>


حتما به گروه و کانال بپیوندید و از ما حمایت کنید

## Contact Developer
💎 Group: https://t.me/wizwizdev
💎 Channel: https://t.me/wizwizch

<br>
<br>

## Stargazers over time

[![Stargazers over time](https://starchart.cc/wizwizdev/wizwizxui-timebot.svg)](https://starchart.cc/wizwizdev/wizwizxui-timebot)
