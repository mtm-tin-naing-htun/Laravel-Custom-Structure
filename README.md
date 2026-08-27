# # Laravel Custom Structure

# # # app/
Laravel ရဲ့ အဓိက Application Logic တွေကို စုထားတဲ့ folder ဖြစ်ပါတယ်။ ဒီထဲမှာ subfolders များစွာရှိပါတယ်။

- Console/ - Artisan command များ (php artisan ...) ကို custom လုပ်ဖို့ Command classes များကို ထားတတ်သည်။
- Exceptions/ - Error/Exception Handling ကို စီမံတဲ့နေရာ။ Handler.php ပါဝင်သည်။

- Enums/ - App တစ်ခုလုံးမှာ အသုံးပြုတဲ့ fixed value set (e.g. user roles, lock status) တွေကို PHP native Enum အနေနဲ့ ထားရာ folder ဖြစ်ပါတယ်။ (ရှေးက Constants/GeneralConst.php ထဲက array constant တွေကို ဒီမှာ Enum အဖြစ် ပြောင်းလိုက်ပါတယ်။)
- - Enums/UserRoleEnum.php: `role` column အတွက် backed int Enum (ADMIN = 0, USER = 1)။ `label()` method က UI/API response မှာ ပြသဖို့ label ပေးပြီး၊ `options()` က select box options array ပေးပြီး၊ `values()` က validation rule (`Rule::enum()`) အတွက် သုံးနိုင်ပါတယ်။ `App\Models\User` model ရဲ့ `casts()` ထဲမှာ `role` column ကို ဒီ Enum အဖြစ် auto-cast လုပ်ထားလို့ `$user->role` က Enum instance ဖြစ်ပြီး `$user->role->label()` ခေါ်လို့ရပါတယ်။
- - Enums/LockStatusEnum.php: `lock_flg` column အတွက် backed int Enum (UNLOCK = 0, LOCK = 1)။ ရှေးက `LOCK_STATUS` array မှာ label နှစ်ခုလုံးကို 'Admin'/'User' လို့ ကူးထားမိတဲ့ bug ရှိခဲ့ပါတယ် (ROLES array ကနေ copy-paste မှားခဲ့တာ) — ဒီ Enum မှာ 'Unlocked'/'Locked' လို့ ပြင်ထားပါပြီ။ `lock_flg` က nullable column ဖြစ်လို့ `$user->lock_flg?->label()` လို့ null-safe operator နဲ့ သုံးပါတယ်။
- - Enums/Contracts/HasLabel.php: `label(): string` method ရှိရမယ်ဆိုတာကို သတ်မှတ်ပေးတဲ့ interface — Enum အသစ်တွေ ထပ်ထည့်ရင် အလားတူ contract လိုက်နာအောင် ဖြစ်ပါတယ်။
- - App name — Laravel ရဲ့ standard `config('app.name')` (`.env` ထဲက `APP_NAME`) ကို အစားထိုးသုံးထားပါတယ်။

- Http/
- - Controllers/: Controller classes များကို ထားသည်။
- - Controllers/Controller.php: အခြား controller တွေအားလုံးရဲ့ base class ဖြစ်တတ်ပါတယ်။
- - Controllers/UserController.php: User-related action (register, login, edit, delete) တွေကို ထိန်းချုပ်တဲ့ controller ဖြစ်ပါတယ်။
- - Controllers/Auth/: အသုံးပြုသူ authentication တွေနဲ့ဆိုင်တဲ့ controller များထားဖို့နေရာ ဖြစ်နိုင်ပါတယ်။
- - Controllers/Api/: Api တွေနဲ့ဆိုင်တဲ့ controller များထားဖို့နေရာ ဖြစ်နိုင်ပါတယ်။
- - Middleware/: Request တစ်ခုလာသောအခါ ထိန်းချုပ်ရန် middleware များ။
- - Middleware/Authenticate.php: Laravel built-in middleware တစ်ခုဖြစ်ပြီး authentication မရှိရင် login page သို့ redirect လုပ်ပါတယ်။
- - Middleware/Api/: Api Request တစ်ခုလာသောအခါ ထိန်းချုပ်ရန် middleware များ။
- - Requests/UserSaveRequest.php: Form validation ကို တိကျဖို့ Form Request Class တစ်ခု ဖြစ်ပါတယ်။ e.g. user register/update data တွေကို validate လုပ်ခြင်း။
- - Requests/Api/: Api Request တစ်ခုအတွက် validationစစ်ရန် Request File များ။
- - Resources/Api/: Api Response တစ်ခုအတွက် formatပြင်ရန် Resource File များ။

- Lib/
- - Lib/DateFormat.php: Custom date formatting logic များကို ထားတဲ့ helper class တစ်ခုဖြစ်နိုင်ပါတယ်။

- Models/
- - Models/Post.php: Post table နဲ့ဆက်နွယ်တဲ့ Eloquent Model
- - Models/User.php: User table နဲ့ဆက်နွယ်တဲ့ Model (users table)

- Providers/
- - Providers/AppServiceProvider.php: Laravel service provider တစ်ခု ဖြစ်နိုင်ပြီး, App bootstrapping အတွက် service binding များလုပ်ပါတယ်။

- Services/: Controller တွေကို ပေါ့ပါးအောင်ထားပြီး logic ကို service class ထဲတွင် centralize ပြုလုပ်ခြင်း။
- - Services/UserService.php: User နဲ့ ပတ်သက်တဲ့ Business Logic (ဥပမာ: custom validation, user-specific permission check, external API call) များကို ထည့်သွင်းထားနိုင်တယ်။

- Traits/: classတွေအတွက် Avoid Code Duplication, Clean & Modular, Easy Maintenanceဖြစ်အောင် Featuresအသစ်တွေကို အလွယ်တကူ ပြုလုပ်ပေးနိုင်တယ်
- - Traits/ApiResponseTrait/: Api response အတွက် success, paginate, error, etcတို့ကို  ကြိုက်တဲ့ နေရာက ခေါ်သုံးနိုင်ဖို့ traitနဲ့ ရေးထားတာ


# # # public/
Web Server Access ပြုနိုင်သောနေရာ

- css/, js/: Bootstrap/jQuery/jQuery UI စတဲ့ vendor library တွေကို static file အဖြစ် ဒီမှာ မထားတော့ပါ — `package.json` (npm) ကနေတစ်ဆင့် `resources/css`, `resources/js` ထဲမှာ import လုပ်ပြီး Vite က build လုပ်တဲ့အခါ `public/build/` ထဲကို auto-generate လုပ်ပါတယ်။ (`js/user_list.js` တစ်ခုပဲ ဒီမှာ ကျန်ပါတယ် — blade ဘယ်နေရာကမှ မခေါ်တဲ့ dead file ဖြစ်နေလို့ သီးခြား စစ်ကြည့်ဖို့ လိုပါတယ်။)

- img/: Website သုံးတဲ့ ပုံများအတွက် folder

- build/: `npm run build` run ပြီးရင် Vite auto-generate လုပ်တဲ့ folder (.gitignore ထဲပါ၊ commit မလုပ်ပါ)

- index.php: Laravel app entry point
- .htaccess: Apache server config
- favicon.ico, robots.txt: SEO နှင့် browser support


# # # resources/
- css/app.css: Tailwind + Bootstrap + jQuery UI CSS (npm packages) + `reset.css`/`style.css` (custom overrides) ကို `@import` လုပ်ထားတဲ့ entry file
- css/reset.css, style.css: Global CSS overrides (ရှေးက `public/css/reset.css`/`style.css` က ဒီကို ရွှေ့ထားတာ)
- js/app.js: `bootstrap.js` (axios, jQuery, jQuery UI, Bootstrap JS setup) နဲ့ `common.js` ကို import လုပ်တဲ့ entry file
- js/bootstrap.js: axios/jQuery/Bootstrap JS setup — `window.$`, `window.jQuery`, `window.bootstrap` အဖြစ် global expose လုပ်ထားတယ်
- js/common.js: Shared Common JS (ရှေးက `public/js/common.js` က ဒီကို ရွှေ့ထားတာ)

- views/: Blade Templates
- - auth/: Login, Register စသော auth-related UI

- - includes/
- - includes/common/footer.blade.php, header.blade.php: Shared layout parts (header/footer)
- - includes/modals/: Popup modal blade files

- - layouts/
- - layouts/app.blade.php: Main layout
- - layouts/authApp.blade.php: Login layout

- - user/: User-specific UI layout blades' folder


# # # routes/
- routes/: web.php, api.php စသည်ဖြင့် route definition files


# # # storage/
- storage/: Logs, Cache, File Upload အတွက်


# # # tests/
- tests/: PHP Unit Testing files

# # # others
- .env: App config for current environment

- composer.json: PHP packages list

- package.json: JS packages (Vue/React etc.) list

- artisan: Laravel CLI command file

- .gitignore, .editorconfig: Git နှင့် coding standard

- README.md: Project Description

- vite.config.js: Laravel application တွင် Vite ကိုအသုံးပြုသည့်အခါ frontend asset bundling (JavaScript, CSS, Vue, React…) အတွက် configuration ဖိုင်ဖြစ်ပါတယ်။
