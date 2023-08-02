<!--  



// simple algorithm of mvc in laravel to view pages : 
// route contain controller 
// and controller contain action 
// and action return view page 


//Route::get("uri",[Controller::class,"action"]);
// home page - $uri - $action [controller,action] -  uri can be : [" " - home]
// Route::get("/home",[HomeController::class,"home"]); 





 // helper fn url : link me to routes - par : uri 
    // <a href="{{url('home')}}"> Home </a>


//how to recevie parameter or variable or query string in url or route to pass it to fn
// Route::get("/home/{id}/{id2}",[HomeController::class,"home"]); //  {name of par} / {}  ...


        // view helper fn => par : $view " " , $data [ ]  

use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;

       return view("home.welcome",
        [
            "id" => $id
        ]);


//die & dump : 
        // dd($id); // "5" // app\Http\Controllers\HomeController.php:15 "full path to line"


     /*
        * compact mean compressed "for par $data mention prevoious"
        * compact fn create an array include parmeters to send them to view
        * pars : (var_name " " , ...);     
        */
         return view("home.welcome",compact("id"));   


/*
* if iwant to make paramter optional put ? after parmter name
*/
// Route::get("/home/{id?}",[HomeController::class,"home"]); // paramter {name of par}


    // public function home($id=null) // make id = null "default value but if u put a value will override"
    // {
    //     // dd($id); // null // app\Http\Controllers\HomeController.php:14 "if no parameter"
    //     // dd($id); // "4" // app\Http\Controllers\HomeController.php:14 "if found parameter"

    // }


// name convention in laravel mvc : 

/*
* if we have table in db : students 
* model file : Student {cap - single}
* migration file : create_students_table {snake - pleural}
* controller file : StudentController {caps studly}
*/


// migration file and create table - structure 
// public function up(): void
// {
//     Schema::create('categories', function (Blueprint $table) {
//         $table->id(); // unsigned bigint "اعداد كبيره موجبه" - primary - auto_increment
//         $table->string("name");
//         $table->timestamps(); // created at - updated at 
//     });
// }

// redirect : logical action - url : blade -> route(uri)
// return view in view action by (view : redirect to view folder)



#################################################################################


// practical 
##################


<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Unique;

/*
// logical action formula - checklist :
1- validat data
2- store data
3- redirect with session of success
*/


/*
    validation and session checklist or formula :
    1- $requst->validate([rule|rule]);
    2- sesstion of errors :  send automatic to view page and diplay it in view page
    3- session of success : send with redirect by : with["success,"msg] and diplay it in index page

*/

class CategoryController extends Controller
{
    //fn to get data from db and send data to view

    public function index()
    {
        //1-  get all categories from db by query builder
        // select * from categories
        // $categories = DB::table("categories")->get(); // static fn in db class - method chaining
        // dd($categories);
        // dump($categories);

        // 1- get all data by elqoent throug model

        $categories = Category::all(); // or get(); - mostly use get better for security

        // dd($categories);





        //2- return or send  all data(categories) to view

        return view("Admin.pages.categories.index",compact("categories"));
    }

    // send to "create view"

    public function create()
    {
       return view("Admin.pages.categories.create");
    }


    //fn to store data in db

    public function store(Request $request)
    {

        // sanitization : laravel do it by default to any input globally - like trim

        // validation
        // by default or automatically "validate" do check : if true -> pass ----- if false : 1- redirect to view page come from and---- 2- push error message in session of errors "errors : regestied for laravel "
        $request->validate
        (
            [
                "name" => "required|min:3|max:50|unique:categories,name" // validation rules
                 //unique : 3 par : table name , field name , value to exclude(in update) - and case insensitive -> ex ahmed Ahmed (taken)
            ]
        );




        // dd($request->all());

        // store data in db by querybuilder

        // DB::table("categories")->insert(
        //     [
        //         "name" => $request->name
        //     ]
        // );

        // store data using eloqunt model

        $category = new Category(); // create new obj from model
        // dd($category);
        $category->name = $request->name; // push the data to obj
        // dd($category);
        $category->save(); // save the model to db

        // session of success - category created successsfully

        $request->session()->flash("success","Category Has Been Created Successfully");
        // session helper fn inside request use to take obj from session class
        // flash helper fn in session class use to save key and value - msg to session

        // redirect to index page
        // return redirect("/categories");
        return redirect(url("/categories")); // more accurate from previous
    }


    // public function edit($id)/
    public function edit(Category $category)//model binding - inject model and take obj or var from it - model do find or fail automatic
    {
        // dd($category);

        // edit : 1- val id -----  2- return view

        // 1- check if id found (search) {where action} ? and get data by id by querybuilder (get data) {first action}

        // where : colum , operator = "=" , value - and if u need change op ..write it like < , >
        // $category = DB::table("categories")->where("id",$id)->first(); // first to get the first result

        // dd($category); // عود نفسك تعمل dd بعد كل متجيب داتا - and must check for error

        //check error (if category not found = null)

        // if(!$category)
        // {
        //     abort("404"); // throw httpExeption depend on code
        // }

        // 1- get data by eloquent model {or check fron=m id found or not}

        // $category = Category::findOrfail($id); // fail instead of abort 404 - find or fail only with id- less code = clean code
        // dd($category);


        // 2- return view with data (caregory)

        return view("Admin.pages.categories.edit",compact("category"));


    }


    // public function update(Request $request,$id)
    public function update(Category $category,Request $request) // model binding
    {

            // dd($id);

            // first check id found or not then validate
            // $category = Category::findOrfail($id);

            //validation
            $request->validate
            (
                [
                    // "name" => "required|min:3|max:50|unique:categories,name,"
                    "name" => "required|min:3|max:50|unique:categories,name," . $category->id
                    // id 3 par : mean exclue this name of unique check
                    //dont forget , after name
                     //unique : 3 par : table name , field name , value to exclude(in update) - and case insensitive -> ex ahmed Ahmed (taken)
                ]
            );

        // dd($request->all()); // [token - metod "input hidden" + name]
        // get or find data by id by qb
    //     $category = DB::table("categories")->find($id); // where + first = find {both to get data}
    //    if(!$category)
    //    {
    //       abort("404");
    //    }

    // //    dd($category);

    // // update data
    // DB::table("categories")->where("id",$id)->update
    // (
    //     [
    //         "name" => $request->name
    //     ]
    // );

    //1- get or find data by id by eloquent model

    // $category = Category::findOrfail($id); //

    //update category - u dont need to take obj bec already to ken in find - prove : dd($caregory);
    $category->name = $request->name;
    $category->save();



    // redirect to index

    return redirect("/categories")->with("success","Category Has Been Updated Successfully"); // flash message or key add to session

    }

    public function destroy(Category $category)
    // public function destroy($id)
    {

        // dd($category);
        // dd($id); // انت مش محتاج تعمل ريكويست هنا لانك باعت id في url - بس نفس الوقت بطريقه post

        // get data by id by qb
        // $category = DB::table("categories")->find($id);

             // dd($category);

        // delete data
        // DB::table("categories")->delete(); // = where("id",$id)->delete(); // لازم تحدد id عشان متمسحش كله

        ###########################

        // get data by id by eloequent model
        // $category = Category::findOrfail($id);

        // delete data by em
        $category->delete(); // انت مشك حتاج تحدد id لانك بتتعامل مع اوبجيكت مفهوش غير القيمه اللي انت بتعملها delte

        // redirect to index
        return redirect("/categories")->with("success","Category Has Been Deleted Successfully");



    }


}


// index
// may be need show (button to display details viewed in index ex : u have category have many products )
//create (form)
// store (logic & db)
// edit(form)
//update (logic and db)
// delete = destroy

// store - update : شبه بعض شويه فيو واوجيك


// ملخص elloquent model :



    //     $categories = Category::get(); - index
    //     $category->delete(); - delete

    //    // store - update
    //     $category = new Category(); // = model binding in update "يعني مش بتعملها ف الابديت"
    //     $category->name = $request->name;
    //     $category->save();
    //







// ملخص Querybullder :


/*

* DB::table::staticfn depend on action

find on $id
index action : get action
store : insert
update : update
destroy : delete

*/





<?php

/*

// خلي بالك وانت بتعمل import لكلاس
// اختار الكلاس الصح
// لان ممكن يبقي الكلاس موجود ف كذا فولدر

// يبقي عشان اعمل pagination - 3 خطوات :
// 1- return data paginated by : Product::paginate();
// 2- paginate view :         {{ $products->links() }}
// 3- paginate bootstrap          Paginator::useBootstrap(); at fn regestier at file app provider in providers folder

// $image_name = time() . "_" . $image->getClientOriginalName(); //getClientOriginalExtension() - time()
// $image->move(public_path("images/products"), $image_name); //to(path),image_name

"category_id" => "required|exists:categories,id", //i do exists with category table not product
"image" => "nullable|image|mimes:png,jpg,jpeg|max:2048", //img at update nullable

"image" => $image_name ?? $product->image //consider order

if ($request->image) { //=$request->hasFile("image)

$image = $request->image; //=$request->file("image")

$products = Product::latest()->paginate(); //opposite sort

-  trait & private :
تريت زي انكلود او كوبي
فلو ف بريفت فانكشن هتسخدمها عادي.. ميزه
عيب... ممكن يبقي فيه فانكشن مش محتاجها ف الكلاس

- single reaponablility :
هو ان الكلاس والفانكشن يكونوا بيعملوا حاجه واحده
فمثلا : كلاس بروديكت مينفعش يبقي فيه فانكشن upload and remove inage
مش هدخله غير وانا عايز اعمل حاحه ل product بس (6or7 fn )
وفانكشن update :
مينفعش يكون فيها validate,  upload,  return,  update
ميكومش فيها db and view بس كشغل controller
والباقي تستخدم فيه ميثود خارجيه تقوم باللوجيك ده

- custom request :
ريكويست متفصل بفالديشنز
يتم انشاءه ب artisan
تسميته : UpdateProductRequest
place :  App\Http\Requests\product\UpdateProductRequest;

- laravel debugbar :
1-composer require barryvdh/laravel-debugbar --dev

2-if you want to use the facade to log messages, add this to your facades in app.php in Package Service Providers :

        Barryvdh\Debugbar\ServiceProvider::class,

3- php artisan vendor:publish --provider="Barryvdh\Debugbar\ServiceProvider"

-debugbar bar :
بيشوف duplicate & uniqness in quries
وبيعرفك معموله فين :  view or cpntroller
والصح : انك متعملش كوريز ف الفيو
وميبقاش ف duplicate
وتقلل وقت الكوريز  واستهلاك موارد السيرفر زي الرام

- $products = Product::with("category")->latest()->paginate(); :
ويز بتجيب البروديكت ب ريلاشن بتاعته اللي هو الكاتجوري
فبكده يبقي اتجابوا مره واحده باستخدام ان و بعيدا عن الفيو
//select * from `categories` where `categories`.`id` in (1, 3, 5, 6, 7, 8, 9, 10)

-  لو عندك كود متكرر او لوجيك معقد كبير
او عايز تنقل لوجيك بتاعك ف حته تانيه
وتخلي الكود abstracted اكتر و encapsulate اكتر
ويبقي انضف واسهل ف traice
اعمل trait لكل مودويل ظبط فيه الحاجه دي
وخاصه الكود المتكرر عشان لو حبيت تغير ف حاجه تطبق ف كله

-diff between use class and use trait?

-first ...class :
1- كاني عملت كوبي ف الصفجه بس برا الكلاس :
يعني اقدر access static method by ::
2- لو حبيت اخد منه obj بعمل injection للكلاس جوا الفانكشن بواسطه model binding
وب access ع الفانشكن اللي جوا ب obj

-second ..trait :
لما بعمل use للtrait كامي عملت كوبي جوا الكلاس
فكانها اندمجت مع الكلاس
واقدر اكسيس ع private method بتاعه trait
ب this
فدي ميزه ف access
ولكنها عيب لو ف حاجه ف trait الكلاس مش محتاجها هتبقي overload or useless code

- try :
// dump(['image' => $image_name]);
// dd( $request->validated() + ['image' => $image_name]);
// Product::create(  $request->validated() + ['image' => $image_name]);
// // dd($request->validated() + ["image" => $image_name]);
// // Product::create($request->validated() + [ "image" => $image_name]);
$request->merge(['image' => $image_name]);
$product = Product::create($request->validated());

-  // toast("Product Has Been Deleted Successfully","success"); // PAR ; TITLE - type:
رساله صغير ع الجنب ل sweetalert

- sweetalert :
no need to with for "redirect" and diplay session of success in index

-  private function indexRedirect()
{
return redirect()->route("products.index");
}

return $this->indexRedirect(); : (fn inside fn)
why use return with this :
bec every fn need to return

- sweetalert :
// githup : https://github.com/realrashid/sweet-alert

1- composer require realrashid/sweet-alert

2- search for app(inside config folder):
//put it in Package Service Providers..

RealRashid\SweetAlert\SweetAlertServiceProvider::class,

Also, put that down it in Class Aliases:

'Alert' => RealRashid\SweetAlert\Facades\Alert::class,

3- php artisan sweetalert:publish

4- in scripts @include('sweetalert::alert')


 */
##########################################

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\StoreProductRequest;
use App\Http\Requests\product\UpdateProductRequest;
use App\Http\Traits\FileTrait;
use App\Http\traits\ProductTrait;
use App\Models\Product;

class ProductController extends Controller
{
    use FileTrait;
    use ProductTrait;

    public function index()
    {
        $products = Product::with("category")->latest()->paginate();
        return view("Admin.pages.products.index", compact("products"));
    }

    public function create()
    {
        $categories = $this->getAllCategory();
        return view('Admin.pages.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $image_name = $this->uploadImage(Product::PATH, $request->image);

        Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "price" => $request->price,
            "category_id" => $request->category_id,
            "image" => $image_name,
        ]);

        $this->alert("Product Has Been Created Successfully");
        return $this->indexRedirect();
    }

    public function edit(Product $product)
    {
        $categories = $this->getAllCategory();
        return view('Admin.pages.products.edit', compact('categories', "product"));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

        if ($request->image) {
            $image_name = $this->uploadImage(Product::PATH, $request->image, $product->image);
        }

        $product->update
            (
            [
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "category_id" => $request->category_id,
                "image" => $image_name ?? $product->image,
            ]
        );
        $this->alert("Product Has Been Updated Successfully");
        return $this->indexRedirect();

    }

    public function destroy(Product $product)
    {
        $this->deleteImage(Product::PATH, $product->image);
        $product->delete();
        $this->alert("Product Has Been Deleted Successfully");
        return $this->indexRedirect();
    }

}




<?php

/*

-authentication :
attempt :
1- found in db and correct data
2- if true :make session of auth
2- if false :make session of error

-why logout :
auth... make session... i destroy session

-auth :
1- manual : simple like admin auth
20 breeze : complicated like user auth
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function loginPage()
    {
        return view("Admin.pages.login.adminLogin");
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);
        if (auth()->attempt($credentials) && auth()->user()->role == "admin") {
            return redirect()->route("admin.index");
        }
        $this->handelLogout();
        return redirect()->back()->with(["error" => "Invalid Credentials"]);
    }

    public function logout()
    {
        $this->handelLogout();
        return redirect()->route("admin.loginPage");
    }

    private function handelLogout()
    {
        Auth::logout();
        session()->flush();
        session()->regenerate();
    }
}

// with : key , value
return redirect()->route('products.index')
->with('success', 'Product has been deleted successfully');





<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    // action to return view welcome 

    // public function home($id=null) // make id = null "default value but if u put a value will override"
    // {
    //     // dd($id); // null // app\Http\Controllers\HomeController.php:14 "if no parameter"
    //     // dd($id); // "4" // app\Http\Controllers\HomeController.php:14 "if found parameter"

    // }

    public function home()
    {


        return view("home.welcome");
    }
    // public function home($id = null)
    // {

    //     // dd($id); // "5" // app\Http\Controllers\HomeController.php:15 "full path to line"

    //     // view helper fn => par : $view " " , $data [ ]  
    //     // return view("home.welcome",
    //     // [
    //     //     "id" => $id
    //     // ]);

    //     /*
    //     * compact mean compressed "for par $data mention prevoious"
    //     * compact fn create an array include parmeters to send them to view
    //     * pars : (var_name " " , ...);     
    //     */
    //      return view("home.welcome",compact("id"));   


    // }

    // public function home($id,$id2)
    // {

    //     echo $id . " - " . $id2;
    //     die;
    //     return view("home.welcome");
    // }


    public function about()
    {

        $product =
            [
                "name" => "product one",
                "price" => 3000
            ];


        return view("home.about", compact("product"));
    }

    // basic about
    ############
    // public function about()
    // {
    //     return view("home.about");
    // }


}






<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.loginPage');
    }
}





<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check())
        {
            return redirect()->route("admin.loginPage");
        }
        return $next($request);
    }
}





<?php

namespace App\Http\Requests\product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge( Product::rules() ,
        [
            "name" => "required|string|min:3|max:225|unique:products,name",
            "image" => "required|image|mimes:png,jpg,jpeg|max:2048"
        ]);
    }
}





<?php

/*

- "name" => "required|string|min:3|max:225|unique:products,name," . $this->product->id, :
 $this refer to $request of UpdateProductRequest - so this has the data


 -    dd( array_merge( Product::rules() ,
        [
            "name" => "required|string|min:3|max:225|unique:products,name," . $this->product->id,
            "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048",
        ])); 
        : dd for mixed $vars and this fn return array
 */
namespace App\Http\Requests\product;


use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return array_merge( Product::rules() ,
        [
            "name" => "required|string|min:3|max:225|unique:products,name," . $this->product->id,
            "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048",
        ]);
    }
}



<?php

/*
-namespace App\Http\traits; //traits small as u write

vs use

use App\Http\Traits\FileTrait;
use when import class : all caps - \ - namespace + class name

-   private function uploadImage($path, $image, $old_image = null)
    {
        if ($old_image) {
            $this->deleteImage($path, $old_image);
    }

 فكره upload image : 
محتاج عند الابديت احذف الصوره القديمه 
فهعمل parmeter optional عشان ده وهتشيك ب if 

 */

namespace App\Http\traits;

trait FileTrait
{
    private function uploadImage($path, $image, $old_image = null)
    {
        if ($old_image) {
            $this->deleteImage($path, $old_image);
        }

        $image_name = uuid_create() . "_" . $image->getClientOriginalName();
        $image->move(public_path($path), $image_name);
        return $image_name;
    }

    private function deleteImage($path, $old_image)
    {
        $image_path = public_path($path . $old_image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
}




<?php
namespace App\Http\traits;

use App\Models\Category;

trait ProductTrait
{
    private function getAllCategory()
    {
        return Category::get();
    }

    private function indexRedirect()
    {
        return redirect()->route("products.index");
    }

    private function alert($msg)
    {
        alert()->success($msg);
    }

}

/*

private function alert($msg)
{
alert()->success($msg);
}
//here i don't need to return just do it
فانا هناك ف الفانكشن مش بريترن يبقي هنا نفس الكلام 
لكن لو هناك بريترن يبقي هعمل كده ف الاتنين

 */





   /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
      'auth' => \App\Http\Middleware\Authenticate::class,
      "IsAdmin" => \App\Http\Middleware\IsAdmin::class,
      'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
      'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
      'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
      'can' => \Illuminate\Auth\Middleware\Authorize::class,
      'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
      'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
      'signed' => \App\Http\Middleware\ValidateSignature::class,
      'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
      'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
  ];
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // relationship - one to many 
    // يبقي عشان اعمل علاقه بين 2 tables 
    // لازم اعرف ال db 
    // والموديل بتاع لارفيل 
    // طب اعرف الموديل بتاع لارفيل ازاي : 
    // عن طريق اني بكتب في كل موديل العلاقه 
    // اللي هو 
    // // category has many products
    // // product belongs to one category

    // لازم products تبقي جمع 
    // يبقي لو بستخدم كلاس خارجي 

    // بعمل حاجتين عشان مستخدمش نيم سبيس 
    // بكتب ::class
    // وبعمل use 

    // category has many products
    public function products()
    {
        return $this->hasmany(Product::class);
    }
}





<?php

/*

-   لوعايز اشيل حاجه default حطهالي  لارفيل
مثل : timestamp
بعمل كده

public $timestamp = false;

// لازم لما استخدم
// Product::create
// اعمل ف الموديل fillable
// يعني بقوله استني مني الداتا دي
// ومتسمحش بداتا غيرها

- path : 
هعمله const جوا model لانه تبعه وبيروح ل blade 
بحيث يقلل errors ، ولو حبيت اغير،  يبقي ف مكان واحد


- regex:/^[a-zA-Z0-9\s]+$/ :
بيتشك ع الحروف وليس فاليو بس 
وبيقبل الحروف او الباترن اللي انت محدده
يعني هنا بيقبل حروف سمول وكابيتل و ارقام من 0 ل 9 بس 

- repetitive rules & ولو عايز اغير حاجه هلف  : 
so i need fn to repetative rules 
site : model 
type : static.. to access directly without class
difference in rules : 
زي مهو وهعمل array merge 

*/
##########################################

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PATH = "images/products/";

    public static function rules(){
        return [
            "description" => "required|string|min:3|max:225|regex:/^[a-zA-Z0-9\s]+$/",
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
        ];
    }

    protected $fillable = [
        "name",
        "price",
        "description",
        "image",
        "category_id",
    ];

    // product belongs to one category
    public function category()
    {
        return $this->belongsTo(category::class);
    }

}




<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}




<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // no fake for id primary key bec it autoincrement
            //model has factory so model use factory - so factory oriented with colums
            //start first with faker then seeder {طبيعي هصنع الداتا ثم هحطها ف الداتا بيز}
            // {ممكن اورث الكلاس عن طريق اني اعمله بوش في property
            //     protected $model = product::class;
            // }

             "name" => $this->faker->name
        ];
    }
}





<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {


        return [
            "name"=>$this->faker->name, // $this => when seeder call it{obj} , faker : take obj from faker class , name : property inside generator class
            "description"=>$this->faker->sentence,//or text
            "price"=>$this->faker->randomFloat(2,100,1000), 
            "image"=>"product.png", // not recommended to put image in db - just text
            // "category_id"=>$this->faker->numberBetween(1,10) // u need to make 10 cat first - with id (1,10)"يعني ميبقوش متلغبطين"
            "category_id"=>Category::all()->random()->id  //get all data from category and push random id in this cat_id colum
            //الطريقه دي امن واحسن من اللي فوق لانه بيجيب id بتاعه الكاتجوري ويختار منه عشوائي
        ];

      
    }
}





<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum("role",["admin","user"])->default("user"); //multiple values in columns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};





<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // unsigned bigint "اعداد كبيره موجبه" - primary - auto_increment
            $table->string("name");
            $table->timestamps(); // created at - updated at 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};




<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name"); // $table->datatype("colum name")
            $table->text("description"); // for long text
            $table->decimal("price");
            $table->string("image"); // string = varchar
            $table->foreignId("category_id")->constrained("categories")->onDelete("cascade");
            // $table->foreignId("category_id")->constrained("categories", bydefault = id)->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};





<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * اي فانكشن باسم كلاس يبقي بتاخد obj من كلاس
         *يبقي بقوله اعملي 10 كتاجوري من خلال كود الفاكتوري اللي انا عامله
         * لازم بعد كده تعمله call في dbseeder عشان يتنفذ الامر
         */
        Category::factory()->count(10)->create();

    }
}





<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // admin  to test authentication
        User::create([
            "name"=>"admin",
            "email"=>"admin@admin.com",
            "name"=>"admin",
            "password"=> bcrypt("12345"),
            "role"=>"admin"
        ]);

           /**
     * بنادي ع  كل السيدر هنا عشان اعملهم run مره وحده في db
     *   CategorySeeder::class : اوف كلاس + use هي بديله اني اكتب اسم الكلاس ب النيم سبيس
     *لازم اعمل call بالترتيب يعني الكاتيجوري ثم البرودكت لان البرودكت معتمد ع الكاتجوري
     */
        $this->call
        (
            [
                CategorySeeder::class,
                ProductSeeder::class
            ]
        );
    }
}




<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->count(100)->create();
    }
}



view
#############

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="  {{ asset('AdminAssets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="  {{ asset('AdminAssets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="  {{ asset('AdminAssets') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Group</b>313</a>
        </div>

        @if (session()->has('error'))
            <div class="alert alert-danger mt-3">
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="{{ route('admin.login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="  {{ asset('AdminAssets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="  {{ asset('AdminAssets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="  {{ asset('AdminAssets') }}/dist/js/adminlte.min.js"></script>
</body>

</html>








@extends('Admin.inc.master')

@section('title')
    Products
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Product</h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- form start -->
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">

                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Product Name">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="number" name="description" class="form-control" placeholder="Enter Product Description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control" placeholder="Enter Product Price">
                            </div>


                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input">
                                        <label class="custom-file-label" for="exampleInputFile">Add Image</label>
                                    </div>
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection




@extends('Admin.inc.master')

@section('title')
    Products
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Product</h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- form start -->
                    <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                        @method("put")
                        @csrf
                        <div class="card-body">
                            <div class="form-group">

                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" class="form-control"
                                    placeholder="Enter Product Name">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea type="text" name="description" class="form-control" placeholder="Enter Product Description">{{ $product->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" name="price" value="{{ $product->price }}" class="form-control"
                                    placeholder="Enter Product Price">
                            </div>


                            <div class="form-group">
                                <select class="form-control" name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($category->id == $product->category_id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>`
                            </div>


                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input">
                                        <label class="custom-file-label" for="exampleInputFile">Add Image</label>
                                    </div>

                                    {{-- <img src="{{ asset('images/products/' . $product->image) }}" width="100px"
                                        height="100px"> --}}

                                    <div class="input-group-append">
                                    </div>
                                </div>
                                <img src="{{ asset($product::PATH . $product->image) }}" width="100px" height="100px">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection


{{-- 

<option value="{{ $category->id }}" @selected($category->id == $product->category_id)> : 
يبقي @selected بتضيف ف edit  الحاجه القديمه اللي اختارتها 
    
--}}





@extends('Admin.inc.master')

@section('title')
    Products
@endsection

{{-- 
 1-<td> {{ $product->category->name }} </td>

 categry : fn as property 
 make me in category table


2-   <img src="{{ asset("images/products/".$product->image) }}" width="100px" :
any link in blade with asset

3- $product::PATH : 
obj inheret const and can access it with ::
--}}

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Products</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- table --}}
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td>
                                        <img src="{{ asset($product::PATH . $product->image) }}" width="100px"
                                            height="100px">
                                    </td>
                                    <td> {{ $product->name }} </td>
                                    <td> {{ $product->description }} </td>
                                    <td> {{ $product->price }} </td>
                                    <td> {{ $product->category->name }} </td>

                                    <td>
                                        <a href="{{ route("products.edit",$product) }}"
                                            class="btn btn-primary">Edit</a>

                                        <form method="post" action=" {{ route("products.destroy",$product) }} "
                                            class="d-inline">
                                            @csrf
                                            @method("delete")
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{ $products->links() }}

    </div>
    <!-- /.content-wrapper -->
@endsection




<?php

/*

- middleware :
هو امن واقف ف طريق request عشان يتأكده ان الدنيا تمام
واحد استخداماته هو auth وليه طريقتين :
1- manual pr custom middleware : artisan"make one" - kernal  . alias"let laravel know"
2- laravel : auth

- if auth : user : authorized to dash
 if not auth : guest : authorized to login
 

 */

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

//prefer to separate login route group from others"guest"
Route::group([
    "prefix" => "admin",
    "as" => "admin.",
    "middleware" => "guest",
], function () {
    Route::get("/loginPage", [LoginController::class, "loginPage"])->name("loginPage");
    Route::post("/login", [LoginController::class, "login"])->name("login");
});

// categories routes [suppose inside route group below]
Route::get("/categories", [CategoryController::class, "index"]);
Route::get("/categories/create", [CategoryController::class, "create"]);
Route::post("/categories", [CategoryController::class, "store"]);
Route::get("/categories/{category}/edit", [CategoryController::class, "edit"]);
Route::put("/categories/{category}", [CategoryController::class, "update"]);
Route::delete("/categories/{category}", [CategoryController::class, "destroy"]);

Route::group
    (
    [
        "prefix" => "admin",
        // "as" => "admin."
        "middleware" => "IsAdmin",
    ],
    function () {
        Route::get("/", [DashboardController::class, "index"])->name("admin.index");
        Route::post("/admin/logout", [LoginController::class, "logout"])->name("admin.logout");

        Route::group
            (
            [
                "prefix" => "products",
                "as" => "products.",
            ], function () {
                //best practice routes
                Route::get("/", [ProductController::class, "index"])->name("index");
                Route::get("/create", [ProductController::class, "create"])->name("create");
                Route::get("/{product}/edit", [ProductController::class, "edit"])->name("edit");//model in the middle
                Route::post("/", [ProductController::class, "store"])->name("store");
                Route::put("/{product}", [ProductController::class, "update"])->name("update");
                Route::delete("/{product}", [ProductController::class, "destroy"])->name("destroy");
            }
        );

    }
);

/*
formula or checklist of mvc :
- make files from artisan
- route to controller to model or view
 */

// so route formula :

// 1- verb:
// get for : index  create , show , edit (view)
// post : store
// delete : delete
// put.. patch : update

// 2- uri
// uri : module name{must}/{id} if found /action name{view except index}

// ببعت id فنص الروت لو مكون من 3 كلمات ...edit

// ف اللوجيك والاندكس مبكتبش اسم الفانكشن مثل - - بكتب اسم الموديل بس: update.. store.. delete..index

// ف الاندكس برده مبكتبش اسم الفانكشن - بكتب اسم الموديل بس...index -

// 3- [controller::class,"action"]

//all routes written small

#####################################

// //Route::get("uri",[Controller::class,"action"]);

// Route::get("/", [HomeController::class, "home"]); // paramter {name of par} - / : وجودها زي عدم وجودها بس الاحسن تكتبها
// // Route::get("/home/{id?}",[HomeController::class,"home"]); // paramter {name of par} - / : وجودها زي عدم وجودها بس الاحسن تكتبها
// Route::get("/about", [HomeController::class, "about"]); // about page

// //Dashboard and login Routes

// Route::get("/admin", [DashboardController::class, "index"]); // admin بتعلق معايا خليها dashboard
// Route::get("/admin/login", [DashboardController::class, "loginPage"]);
//يبقي فولدرات admin
// لكن route : dashboard

// // categories routes
// // المفروض /admin/categories
// Route::get("/categories", [CategoryController::class, "index"]);

// Route::get("/categories/create", [CategoryController::class, "create"]);

// Route::post("/categories", [CategoryController::class, "store"]);

// Route::get("/categories/{category}/edit", [CategoryController::class, "edit"]); // model binding - بمرر اسم موديل
// // Route::get("/categories/{id}/edit",[CategoryController::class,"edit"]);

// Route::put("/categories/{category}", [CategoryController::class, "update"]);
// // Route::put("/categories/{id}",[CategoryController::class,"update"]);

// // Route::delete("/categories/{id}",[CategoryController::class,"destroy"]);
// Route::delete("/categories/{category}", [CategoryController::class, "destroy"]);

// //products Route
// Route::get("/admin/products/", [ProductController::class, "index"])->name("products.index");
// Route::get("/admin/products/create", [ProductController::class, "create"])->name("products.create");
// Route::post("/admin/products", [ProductController::class, "store"])->name("products.store");

// route group :
// ليه : عشان لو حبيت اغير في uri
// اغير في سطر واحد يتغير في كله
// و كمان حته تنظيميه
// وبنعمل
// general or global route
// جواه sub route
// general route : admin or front
//sub route : modules like categories - products
//n : / ف uri ف الاول وف الاخر مش مهمه - اهم حاجه في النص
// syn:
// Route::group
// (
//     $attributes : [الحاجات المشتركه اللي هعملها بوش في كل الروتس من خلال الفانكشن]
//     $routes : calllback or anonumus fn (hane routes)
// )

// //general route :
// Route::group
// (
//     [
//         "prefix" => "admin" // البريفكس هو البدايه
//         // "as" => "admin.", // "الصح" - بحط . عشان route name - as for route name
//     ],
//     function ()
//     {
//         //sub route:
//         //المفروض ده الصح
//         // Route::group
//         // (
//         //     [
//         //         "prefix"=>"categories",
//         //         "as"=>"categories."
//         //     ],function()
//         //     {
//         //         Route::get("/categories", [CategoryController::class, "index"]);
//         //         Route::get("/categories/create", [CategoryController::class, "create"]);
//         //         Route::post("/categories", [CategoryController::class, "store"]);
//         //         Route::get("/categories/{category}/edit", [CategoryController::class, "edit"]);
//         //         Route::put("/categories/{category}", [CategoryController::class, "update"]);
//         //         Route::delete("/categories/{category}", [CategoryController::class, "destroy"]);
//         //     }
//         // );

//         Route::group
//         (
//             [
//                 "prefix" => "products",
//                 "as" => "products.",
//             ], function () {
//                 Route::get("/", [ProductController::class, "index"])->name("index");
//                 Route::get("/create", [ProductController::class, "create"])->name("create");
//                 Route::post("/", [ProductController::class, "store"])->name("store");
//             }
//         );

//     }
// );

// route name :
// هوعباره عن متغير بيشاور ع route بتاعه
// وبناديه لما اعوز اروح ل روت
// وميزته انه بيريحني من صداع كتابه uri
// ولو حبيت اغير حاجه في uri مضطرش اغير كل حاجه
//وكمان بكتبه ب <.> زي الفيو

// Route::get("/",[HomeController::class,"home"]); //route for empty uri without id to home

// Route::get("/home/{id?}",[HomeController::class,"home"]); // paramter {name of par} - / : وجودها زي عدم وجودها بس الاحسن تكتبها

// another tryies :
################

// Route::get("/home",[HomeController::class,"home"]); // home page - $uri - $action [controller,action] - uri can be : ["" - home]
// Route::get("",[HomeController::class,"home"]); // when empty path refer to home route

/*
 * if iwant to make paramter optional put ? after parmter name
 */
// Route::get("/home/{id?}",[HomeController::class,"home"]); // paramter {name of par}

//if have 2 parmeter
// Route::get("/home/{id}/{id2}",[HomeController::class,"home"]);

// notes :
############

// route contain controller
// and controller contain action
// and action return view page

// name convention in laravel mvc :

/*
 * if we have table in db : students
 * model file : Student {cap - single}
 * migration file : create_students_table {snake - pleural}
 * controller file : StudentController {caps studly}
 */

// every table in db ex: categories have :
/*
 * controller file : CategoryController
 * migration file : create_categories_table
 * model file : Category
 * migrate files and create db
 */




#################################################################################

// therotic - نظري 

#################################################################################

//1

mvc : 
هو stucture للفايلات 
وهو كموضح بالصور

بيتم ازاي عملي : 
اليوزر بيبعت حاجتين ف url
انظر صوره

ا ************

laravel 
********

- routes : 
بدل ماليوزر بيبعت الurl فيه controller & method 
بيبعت route مثلا اسمه : add 
وده بيشاور عندي علي
  contoller : product(module or component  logic ),
  action or mehod  (inside conyroller ) : add (عباره عن فانكشن بتعرض صفحه add )
وهكذا بعمل routes لكل الموقع 
كما موضح بالصوره 

وعندي routes ل api 
و routes لل web

syntax : route.. method
 (uri ...     url refer to contoller contain action 
  
  ، array of  : controller & method or action )
  

- طريقتين للتعامل مع db ف لارفيل الا وهو : 
- طريقه qb - وطريقه elequnt 
 query builder => db 
بيتعانل مع db مباشرةً 
زي مبتكتب ف php 
eloquent => model=> db
بيتعامل مع model و موديل بيتعامل مع db 

- model:
ex : model product
عباره عن كلاس بيشاور ع اسم تابل ف db 
فمش بجتاح اكتب اسم تابل وبستخدم ميثود جوا الكلاس عشان اعمل crud ع التابل 

- migration : 
movement of db from project or device to another 
يعني يباشا انت مش هتعمل قصه import& export 
انت هتعمل شكل التابلز عندك ف فايلات 
ex : table.. users.. id int.. name string.... 
وهيجي حد تاني يعمل migration فتنزل عنده db
 كامله يعني تابلز ب كولمز
يعني بتعمل فايلات migration ف بروجيكت 
ex : migration product 
وفايلات mig بيبقي فيها 2 فانكشن باي ديفولت : up & down 
up : بتعمل الجدول , down بتمسحه
ولذلك : 
- table in db :  
ليه فايل migration : ا structure or create 
وليه فايل model : ا crud or action 

- factories and seeders : in database folder 
بيانات وهميه مختلفه عشان تقدر اعمل داتا وهميه اتيست بيها الموقع بتاعي 

- public : 
هو start of project 
بكا فيه صفحه index بتاع بروجيكت (اول مبروجيكت بيرن ، اعتمادات بترن run وتظهر )
والفولدر ده بيبقي فيه تي حاجه ينفع يوزر يشوفها مثل : صور 
وفيه htaccess 

- tesys folder : unit test 



- vendor folder autoload file (run in index file in public folder)

- .env file : 
اختصار ل environment اة بيئه 
هي هباره عن شويه constants بتسهل شغلك

- method : 
get : to get data from url 
or to land on page : او اتحرك من حته لحته 


- كل url او path  او صفحه او لينك. عندي ف الموقع 
لازم اعمله route 

- url helper fn : بتوديني ل روت 
ويستخدمها مثلا ف لينك عشان اروح لروت معين اعرض منه صفحه 





ا ************





- composer : dependancy manager in php 
عايزين لارفيل نزلهولنا 

- artisan : command line in laravel 

- route : start of mvc 

- include = import 

- vendor file : autoload (run in index file in public folder)

-  resluotion operator ::

- any view in laravel : view. blade. php 

- home. welcome... path  in laravel instead of home/ wlcome 

- اقواس php او طباعه ف blade ا view هي دوبل كيرلي بريسس

- classess : 
when  :: access class in controller 
when -> : almost in blade - and after take obj from calss in conytroller (find in model,new in model)




#################################################################################

//2

- ممكن pivot table ميتعلمهوش model 
- {{}} : اقواس طباعه في ال blade - زي <?=  ?>

- migration : fn up to create,  down to drop 
by defaultbin up : id - timestamp 

- why string not var char ? : 
string is abstracted fn 
عشان ممكن ف db تبقي varchar ، وممكن ف غيرها حاجه مختلفه وهكذا 
وممكن تابل يبقي text او long text 

- طريقتين لانشاء db : 
ملاحظه : لارفيل عامللك ف .env ، كونيكشن مع db 
وعاملك كونستانت لحاجات الكونيكشن مثل يوزر نيم 
واسم db 

1- تاخد الاسم من .env وتووح تعمله ف php myadmin 

2- تعمل  php artisan migtare 
فينشئل db ويعمل migrate 

- معظم ال controllers or module فيهم 7 فانكشن اساسيين : 
- create (form) ,
-  store (logic and store in db )
- edit (form)
-  update (logic and updaye in db ) 
- index (display module)
- show (display details of module)
- delete = destoty

اندكس وشو : 
مثلا لو عندي كاتجوري وبرودكت 
وكل كاتجوري ف معلومات وبرودكت كتيره تحتيه 
فبعمله زرار show لعرض التفاصيل 

ف عندي index البروجيكت كله front controller 
وف index بتاعه كل موديل بعرض بيها داتا الموديول مثل : product 


- query builder : 
DB class (facade)
جواه شويه static fn بستخدمهم عشان اعمل crud بتاعتي ، بعد مااديله اسم التابل 
fn on db : 
get... get all data 


- الفرق بين use& name space 
name space :  
هو باث الملف كامل للملف الحالي 
"الباث من اول البروجيكت برا لغايه مااوصل للملف "

use : 
هو باث الملف كامل للملف اللي بستدعيه او بعمله include في الملف الحالي 
 (autoload by namespace )

- mvc in laravel : 
route send to controller 
controller have action 
action bring data from model or db 
and return or send data to view 
شكرا 

- we loop on 1 tr and echo in td (count depnd on count of data)


- route : 
ماهو الا جاجه بتبعتني ل. action او بتبص ع ال action 

- اي حاجه جايلي من فورم وبحطها ف db 
بعملها بالشكل ده : 
طب ده ايه : ده اسمه - dependency injection?  
يعني با inject كلاس request ف الميثود وباخد منه 
ا object بخزن فيه ريكويست بتاعي او اللي جايلي 
وممكن access ع كل اللي ف الريكويست بفانشكن all 

طب تزاي الريكويست هيجيلي من الفورم لغايه controller 
هو ريكويست هيروح ل route عن طريق helper fn 
ا url 
ثم من ال route هيروح ل controller طبعا عن طريق post 
"طب ليه مروحش من الفورم علطول ، لانك.مش هتعرف تروح ل controller الا من خلال route "

- csrf : 
 ف لارفيل ف اي فورم،  لازم تكتب blade csrf 
 وهو بيبقي عباره عن 
 hidden input name : token with certain value like password 
 بتتبعت مع الريكويست 
 وبتجيلي مع الريكوست بنفس الفاليو كنوع من انواع السيكورتي والفالديشن 


- redirect : 

1- url (route) :
 غالبا بستخدمها جوا blade 
 عشان توديني ل blade تاني او logical action 
 
 
2- redirect (route orl url: route) :  
غالبا جوا فانكشن اللوجيك ف controller 
عشان ترجعني ل view 
3- view : 
اول حاجه : بتوقفك عند فولدر view وانت بتكمل 
وب display view 
وغالبا مع فانكشن view ف controller 



- يبقي اي logical action عايزه تتعامل مع view 
او العكس لازم route ف النص 

ع عكس view action 
اroot بيبعت ل view action وهي بترجع ال view 


- اي url او redirect او link او path : 
ببعت ل url وهو. بيتعامل
ماعدا action of view لان اصلا ال route باعتني ليه عشان يعرض الصفحه 

- كل موديل 7 route ب 7 فانكشن 
every route land on fn 


- route : 

first : get : 

1- get data : 
get mean receive and have data 
then display 

not recommended in update,  delete (logic action )

2- view (action view ): 
برجع صفحه فيو 
وده طبيعي  لاني بتحرك بين صفحات الفيو من خلال url 
 في اي موقع 



second : post : 

1- form : لازم من خلال فورم 

recommended in : 
store, update, delete or destory 

so : crud 
r : get 
cud : post 


- انواع post ، او methods or another verbs 
معموله من method post 
لتكون اكثر تناسبيه مع update,  delete 
: 
update : put, patch verb 
delete : delete 

- route with verb : 

verb or method... url... action 
screenshots
م:  هتلاقي index زي store ف url 
ولكن مختلفين في verb فده هيخلي الكومبيلر يميز 
او 2 روتس مختلفين 

show : 
بباصي id ب get عشان اعرض : 
ف اي فورم او view محتاج داتا او id بباصيها ف get 
لان كده كده view بستخدم فيه get 

م : ف url بتاع logic action 
مش بستخدم اسم الاكشن ف url 
طب ايه اللي يميزه عن view : 
هو verb و ف الفيو بستعمل اسم الفانكشن ف url 


so route : 

1- verb: 
get for : index  create , show , edit (view)
post : store 
delete : delete 
put.. patch : update 

2- uri
uri : 
ببعت id فنص الروت لو مكون من 3 كلمات ...edit

ف اللوجيك مبكتبش اسم الفانكشن مثل : update.. store.. delete 

ف الاندكس برده مبكتبش اسم الفانكشن ...index

3- [controller::class,"action"]

- فورم edit هي هي فورم create 
بس بطبع old values عشان اسهل التعديل عليها 


ترتيب اي فانشكن logic : 
1- validate data 
2- db 
3- set session : with success pr error message 
4- redirect 


- ا delete نوع من انواع post فلازم ابعتها ف فورم 

- ا method chaining : او ان الميثود تبقي ف النص 
ف حاجات ميتفعش معاها ده ، ولازم تبقي ف الاخر،  لانها بتعمل return مثل : find 

- ا loop.. iteration 
عندي كلاس loop باخد منه obj 
و ب access or land on ...iteration 
كاني من الاخر عملت لوب مصغر 
بيعد من 1 
وده بيبقي مفيد ف طباعه items ف صفحه index 
وف عندنا loop of index : بتبدا من 0 

db : 
1- qb : بيتعامل مع db مباشره 
2- ellequent model : 
ااالكوينت بيتعامل عن طريق موديل 

من فروق بين qb vs ellquent 
qb : 
path : suuport collection
data : array 

vs 

ellquent : 
path :elquent collection 
data: obj

الفرق بينهم بالاسكرينات موضح 

- fn... route : blue print 
يعني بارميتر بالنسبالهم بنبقي abstract 
يعني بعرفهم هيجلكم حاجه 

- خطوات اي لوجيك موضح بالاسكرين 

- كتابه uri : 
module + data + action 
data if found like id 
view action only 

- delete vs destroy : 
delete : verb,  db action 
destroy : cpntroller action 


- الكومينت comment علي اضيق الحدود ممكن ف ال route لو شغال مع تيم 
ex : categories
#admin 
#endAdmin
وهكذا 
لكن لا كومنت شرح 


##################################################

//3 
###########
- كلاسات التعامل مع db : 
ماهو الا obj و obj جاي... يعني كل الدانا اللي جايلك من الدانا بيز اوبجيكت 


- dump vs dd : مع بغض لو عايز اشوف الفرق بين حاجتين وااوقف 

.ف كلاس الموديل : الداتا بتبقي موجوده ف attributes


- خلاصه namespace : لكلاس الصفحه

folders (من برا )

اuse: للكلاسات الخارجيه الللي بعملها import 

folders (من برا ) + file

- clean code : no comment for expalnantion 

- elloquebt ف الكتابه : اول مره بتعامل مع الكلاس ثم obj ف نفس الفانكشن

- يبقي ال dashboard  او ادمن - back :
ممكن تقول موقع او component منفصل عن الفرونت 
بقدر اتحكم فيه ف الموقع 
واعمل crud ع كل table
وشويه احصائيات 
authorization

يبقي الموقع : dashboard and front 

- view : 
EndUser : فرونت 
Admin : dashboard or back 

view and controller folder name : 
EndUser
Admin 

uri name :  small 3ady

- بعرف ازاي الملفات اللي محتاجها في الثيم : 
اقرا اللينكات او href بتاعه ال index

- المتصفح مش بيشوف غير فولدرات public ولذلك هحط فولدرات الفيو زي css - js فيها 
ولارفيل اتوماتيك ملفات view - اللينكات بتروح ع public 

- asset - تقطيع - dashboard - kamal:

css
_______

1- plugins href: 
href="plugins/
href="{{asset("AdminAssets/plugins/

2- dist  href:
href="dist/
href="{{asset("AdminAssets/dist/

"
خلي بالك في css من http متغيرهوش

خلي بالك vs مبيدئش من الاول فركز معاه براحه

اتاكد من دنيتك بالاوان

واتاكد من css عن طريق view page source واللينكات شغاله
"

3- css :
.css
.css")}}

_________________________________________________________________
js 
__________

4- plugins src: 
src="plugins/
src="{{asset("AdminAssets/plugins/

"
خلي بالك هنا هيجيلك صور متلعبش فيها - ليها شغل تاني
"
5- dist src :
src="dist/
src="{{asset("AdminAssets/dist/

"
خلي بالك بعد مبيخلص بيعيد تاني 
خلي بالك ف js ف النص
جرب لينكات js هتلاقيها اشتغلت
"

6- js:
.js
.js")}}


7- img :
 {
وهتبحث عنها ب src وهتعمل الباقي برا 
وخلي بالك عشان هتدخلك ع src بتاع plugins - اقف
}
src="
src="{{asset("AdminAssets")}}/



- integration of design or theme formula , checklist : 
باخد design  بحطه ف index
 بعد مظبطله asset ف index
باخده ف master 
وبقطع كل جزء لوحده ف فايلات جوا inc مثل : head - footer
واعملها include جوا master 
وهكذا لغايه مااعمل include لكل الثوابت 
والمتغيرات مثل : content بعملها yield 
بس واي صفحه هعملها مثل : index :
  ه extend master "هورثه"
وه add yield 

- تقسيم وتسميه فولدرات المشروع او باك وفرونت : structure - front - back 
controller & views : 
Admin - EndUser

public : 
AdminAssets
EndUserAssets


- integration idea or concept :
اي حاجه ثابته مثل : هيدر وفوتر وناف بار 
بقطعها لوحدها 
ثم بجمعهم ف فايل واحد بالترتيب - master
"الترتيب : header then navbar-sidebar-body-footer"
ولكن body متغير 
فب inject ال body ف النص "بترتيبه من غير ميبوظ "
بحيث يبقي عندي ديزين او ثيم او صفحه فيها كل الثوابت وتسمحلي احط المتغير 
وكله يبقي متظبط والترتيب ميبوظش 
"msater" 
واللي بيظبلي حته ان احط حاجه متغيره حسب الصفحه 
بترتيبها الصحيح هو yield 
ونقدر نقول ان هو : 
ممكن نقول عليه متغير فاضي 
وهو بيعملي حاجتين
 اول حاجه : بيحجزلي مكان مناسب للحاجه المتغيره
  مثلا : الكونتينت ف النص 
 تاني حاجه :  ممكن احجز بيه حاجه واخليها optinal او اختياريه 
 مثلا عايز لينك css or js يشتغل ف صفحات اه و ف صفحات لا،  او يعني ف صفحات معبنه 
فمن الاخر بقول ل master احجزيلي yield  او متغير باسم مثلا : content 
وانا بستدعيك ه inject او هباصي القيمه بتاعه المتغير او yield ده ليكي
عن طريق add section content 
 فتحطيه ف مكانه المناسب "ف النص "
 
 وبكده يبقي عملنا integration او دمج للثيم 
 ف لارفيل بطريقه بسيطه 
 وخليناه دينمك ممكن استخدمه في اي صفحه 
 يعني عملت اسطمباه او ثيم. ثابت اقدر استخدمه في اي صفحه وهباصي المتغير عن طريق yield 
 عن طريق ان كل الصفحات هت extends ال master 
 وتباصي yield 


ليه assets: 
لانها بتوفرلك حاجه stander توديك ع فولد public 
ومتعملكش مشاكل ف السيرفر 

- م : 
كل لينكات او فولدرات بتاع design or theme 
زي css او js 
بتتحط ف public عشان browser يقدر يشوفها 
وكل صفحات view بتحطط ف views 

paths : 
1- redirect - url :
 بيسنخدموا عشان يودوني ع route و بستخدك معاهم... / 
2- view... invlude. 
extends : 
بتوقفني ع views وبستخدم :  . 

3- asset : 
بتوقفني ع public وبستخدم : .

من الاخر اي route : بستخدم / 
واي view بستخدم : .


- model binding : 
attach route with action with blade by model
benefits : 
1- pass id as parmeter in route and function and blade 
2- make find or fail by id in action


########################################################################

4
#####
`تقطيع اي design ف theme او index : 
بتقف ع راس ال design او header 
وبتعمل inspect 
وبتاخد ال div اللي فوقيه 

- dashboatd theme : 
اي حاجه هتحتجها مثل : table,  form 
افتح index ف الثيم 
وهيجبلك كل حاجه 
اختار اللي عايزه 
واعمل ع راسه كده inspect وهتلاقي comment فوقيه 
اعمله copy 
وشكرا 

تقطيع content wrapper : 
سيب contentheader وغير الاسم 
و main content : 
سيب section + div بقفلتهم 
وحط content بتاعك جواهم 

تقطيع sidebar : 
دور ع sidebar menu 
اللي هو القوائم و
بدايتها nav جواها ul 
ونهاينها nav ul 
(قصه بدايه ونهايه امشي مع التاج فتحته وقفلته فين )
وف النص خدلك li عجبتك ف theme 
سرش عليها بالاسم 
وقطعها : 
هتلاقيها عباره عن li ...امشي مع قفله وقطعها 
"وامسح باقي li اللي مش محتاجها "
وهتلاقي جواها ul ...جواه li 
قطع كام li جوا ul حسب احتياجك 
(جرب تعمل تيست قبل متقطع واكتب وشوف النتيجه)
بس يصاحبي ويبقي كده ظبطت موديل 
وانسخ واعمل باقي modules 


- وانت بتغير اماكن فولدرات او reflector foldera : 

راجع use و namespase بتاع controller ف web,  con
وراجع view ف controller


- اسامي كل الفايلات بتاعه table 
مثل : seeder,  factor,  controller 
بطريقه capsا + مفرد
ماعدا migraton : ا snakeا + جمع 


- seeder,  factory : 
مشكله : 
عايز اtest الموقع بتاعي بداتا كتيره وبطريقه dynamic 
مش هقعد تدخل واحده واحده 
فالحل كان ف : سيدر وفكتوري 

فاكتوري : يعني مصنع و هو مصنع لصناعه fake data 
عن طريق faker 
و الفاكير : عباره عن فانكشن او اراي او لوووب يقوم بصناعه داتا رهميه بكميات حسب الطلب 
طب مين اللي بيطلب... 
سيدر : يعني الشخص الذي يضع البذور 
وهو. اللي بيطلب من السيدر العدد 
مثل : اعملي 10 بروديكت 

وهكذا بعمله في كل modules مثل : cat,  products 
ثم بنادي ع كل seeder ف مكان واحد وهو فايل 
db... seeder 
فيقوم ي seed او يبذر كل الداتا ف db 

seeder & factory checklist  : 
1- factory : بتاع كل module 
2- factpry : ....
3- database seeder



- every table have 5 files : 
contrller.. model... migration.. seeder.. factory 


- nul vs deault : 
null : بتسيب column فاضي 
deault : بتحط قيمه افتراضيه لل column انت محددها


حاجات static بتتحط setting للموقع : 
مثل عدد ساعات العمل اللي بتتحط ف footer 

لما تعوز تعمل موقع : شوف مواقع شبهه 
عشان تتخيل theme 
وتاخد insights ل erd digram 
فمثلا هتلافي navbar : 
بتديك معظم tables 
وغالبا اي موقع ليه cayegory,  product 
مثلا : زي فطار،  غدا،  عشا 
وغالبا بيبقي name اللي ظاهر 
وكل product ليه attribute ظاهره ع الموقع 
وغالبا : name  price , description , image 
وممكن تخلي img تبع ال product 
او تفصلها 
وف الحالتين ممكن تعرضها لوحدها 
وغالبا ف يوزر لل product ده 

- يبقي forien key بيبقي index او بيشاور ع p. k 

erd diagr tips : 

- price : decimal 

- chefs = employees,  name = title

- email,  password,  name of cat : unique key 

-role : enum : 
عباره عن array : فيها user و admin 
وبعملها قيمه defalult اللي هو user 

- setting in website : 
ex : screenshots (about ...working hours)
فالحاجات دي كلها بتتخزن ف db ف تابل اسمه setting 
عشان اقدر control عليها من خلال dashboard 
واغيرها dynamically 


- formula or checklist for view.. admin folders dashboard: 
1- inc (تقطيع وتجميع ex: master,head )
2- pages(or modules or tables): 
ex : login,  category,  employee,  ptoduct 

- ne convention : 
الكل camel حتي يثبت العكس 
- caps : 
controller 
model 
Admin,  EndUser folders 
الباقي camel 

- design integration formula: 
1- باخد فيو اللي محتاجه كوبي 
2- وبشوف اللينكات بتاعته وباخده احطها في public 
3- واخد الفيو ف views : 
وابدا اظبط اللينكات ب asset 
4- التقطيع وااتجميع ف master ع حسب : 
لو استخدام واحد زي login بتاعه الادمن يبقي مش محتاج 
لو multi-use : زي dashboard theme يبقي اعمل كده 

- طريقه مختصره ل asset نفعت مع login page : 

../..
  {{asset("AdminAssets")}}

ex :   <link rel="stylesheet" href="  {{asset("AdminAssets")}}/plugins/fontawesome-free/css/all.min.css">
"التركه اني بفصل asset عن باقي لينك - وبتجنب صداع ورا وقدام"


- admin login : 
مش منطقي تخليه بعمل regestration 
دي لازم من جوا هو يضيف حد

- فورمات formatt : 
افصل يطر واحد بين كل بلوك والتاني او لو حاجه منفصله عن حاجه 
وممكن تكتب comments ك healine 
مثل : فانشكن دي بتعمل كذا 
او دي rpute dadhboard 


- admin login and regestration formula or checklist : 
1- admin login 
2- admin authanication : 
التحقق موجود عندي ولا 
3- admin crud : 
add.. delete 


- design : dashboard... login 

- tables name : 
general : ex : products 
specefic : ex : menus

- migration syntax : 
table of fn named as data type of columName 
ex : table of string of name 
- relationship in laravel : 
foreignId of colum name constrained 
table name of on delete cascade 
لم احتاج بعد constrined اكتب اسم colum بتاع category...ازاي؟  
لانمي مسمي صح الا وهو category id فهو بيشاور ع id 
ولمده يبقي عملت ريلايشن ف db 
فاضل اعملها ف لارفيل،  عشان افهمها ان ف علاقه 

- ملف migration جوا فولدر migration : 
بيبقي جواه الجدوال اللي اتعملت 
بحيث لما اقوله migrate 
يبص ع الفايل ده ،  عشان ميكررش اللي اتعمل 

يبقي عندي امرين : 
make migrate 
migrate (لتنفيذ امر up او انشاء الجدول )

#########################################

تقطيع - تقسيم assets 
####################

1-css href link at first :
href="
href="{{ asset("AdminAssets") }}/


2-img,js src link at middle and end:
src="
src="{{ asset("AdminAssets") }}/


how to confirm im right : 
CTRL + U ... and all links work
f12 - consle no error


###########################################################

'admin' => [
    'driver' => 'session',
    'provider' => 'admins', //admin table
],
##################################################

Route::group
(
    [
        "namespace"=>"Admin", //بتسهل ع لارفيل حاجات كتير
        "prefix"=>"admin",
        "as"=>"admin.",
        "middleware"=>"guest:admin", // عشان تفرق بين الادمن والفرونت 
    ],
    function(){
        Route::get("/login",[LoginController::class,"loginPage"])->name("loginPage");
    }
);

##################################################
Route::post("/",[LoginController::class,"login"])->name("login"); // just write / for  security wise - attacker guess action method name and use it - متكتبش اسم فانكشن لوجيك في url

##################################################

//to oveeride  laravel message do that in custom request 
public function messages()
{
    return[
        "username.required"=>"اسم المستخدم مطلوب",
        "password.required"=>"كلمه المرور مطلوبه",
    ];
}
##################################################
// لعرض كل رسله منفرده
@error('password')
<span class="text-danger">{{ $message }}</span>
@enderror

##################################################
// rtl in all pages - arabic - css
<link rel="stylesheet" href="{{ asset('AdminAssets') }}/css/bootstrap_rtl-v4.2.1/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('AdminAssets') }}/css/bootstrap_rtl-v4.2.1/custom_rtl.css">

##################################################
// التمييز في اسم ميثود
function(){
    Route::get("/login",[LoginController::class,"loginPage"])->name("loginPage");
    Route::post("/login",[LoginController::class,"login"])->name("login");
}

##################################################

//with correct in both
return redirect()->route("admin.loginPage")->with(["error" => "بيانات الاعتماد غير صالحة. حاول مرة اخرى"]);
return redirect()->back()->with("error","بيانات الاعتماد غير صالحة. حاول مرة اخرى");

##################################################

//Illuminate\Auth\EloquentUserProvider::validateCredentials(): Argument #1 ($user) must be of type 
//admin and user must extends Authenticatable not model
class Admin extends Authenticatable
use Illuminate\Foundation\Auth\User as Authenticatable;

##################################################
//error :Route [login] not defined 
//midlleware handel redirect of guests"not authenticated" 
namespace App\Http\Middleware;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('admin.loginPage');
    }
}
##################################################

// merge between validations error and session of error "login page authincation and validation"
@if ($errors->any() || session()->has('error'))
<div class="alert alert-danger">
    <ul>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif

        @if (session()->has('error'))
            <li>{{ session()->get('error') }}</li>
        @endif
    </ul>
</div>
@endif
##################################################

//redirect if authanticated : لو auth وعايز تروح login 
   public function handle(Request $request, Closure $next, string...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                //write code for redirect both for admin or front in case login already done
                if ($request->is('admin') || $request->is('admin/*')) {
                    //redirect Backend
                    return redirect(RouteServiceProvider::ADMIN);
                }
                //redirect front end  in case there is front
                //  return redirect(RouteServiceProvider::HOME);//front
                return redirect(RouteServiceProvider::ADMIN); //bec now don't have front - admin const for route uri
            }
        }
        
        return $next($request);
    }

    ##################################################
    // authinticates : لو guest وعايز تروح index
    protected function redirectTo(Request $request):  ? string
    {

        if (!$request->expectsJson()) {

            if ($request->is('admin') || $request->is('admin/*')) {
                //redirect to admin login
                return route('admin.loginPage');
            }
            //redirect to front login in case there is front
            //return route('front.loginPage'); //example
            return route('admin.loginPage');// u cant write redirect bec it do it

        }
    }

    ##################################################
//resource controller
Route::resource("product",TestController::class);



##################################################
    //send data from controller to view
    public function index()
    {

        // return view("test.index")->with("data",2); // with : stings as variables - in blade {{ $data }}

        // return view("test.index")->with(["name"=>"ahmed","age"=>23]); // with :  array  - in blade {{ $name }}

        // $data = ["name" => "ahmed", "age" => 23];
        // return view("test.index",$data); // send array as variable - in blade <p>{{ $name }} -- {{ $age }}</p> - cant{{ $data["name] }}

        // $obj = new stdClass();
        // $obj->name = "abdo";
        // $obj->age = 23;
        // return view("test.index", compact("obj")); // in blade :     <p>{{ $obj->name }}  {{ $obj->age }}</p>

        // $data = ["name" => "ahmed", "age" => 23];
        // return view("test.index", compact("data")); // send as array or object"the only one do that" without $   - in blade :     <p>{{ $data["name"] }} </p> -   @dump($data)

    }

##################################################
    // dispay message if empty array
    @forelse ($data as $data )
        <p>{{ $data }}</p>
    @empty
        <p>{{ "empty array "}}</p>
    @endforelse

    ##################################################

    // excepty and only in roughtes : 
// except : blacklist "forbiden"
// only : whitelist "allowed"
// بستخدمها مثلا مع resource ف حاجات مش محتاجها 

Route::resource("test",TestController::class);
// Route::resource("test",TestController::class)->except("index");
// Route::resource("test",TestController::class)->only("index");

// GET|HEAD        test ..................................................................... test.index ›  
// POST            test ..................................................................... test.store › 
// GET|HEAD        test/create ............................................................ test.create ›
// GET|HEAD        test/{test} ................................................................ test.show › 
// PUT|PATCH       test/{test} ............................................................ test.update ›  
// DELETE          test/{test} .......................................................... test.destroy ›   
// GET|HEAD        test/{test}/edit ........................................................... test.edit ›   

#########################################################################

// invoke controller : 
// هو كونترولر ليه single action 
// بيتعمل ب artisan 
// و مبتكتبش اسم الميثود 

//invoke controller
Route::get("profile",UserProfileController::class);

class UserProfileController extends Controller
{
  
    public function __invoke()
    {
        return "user_profile";
    }
}


#########################################################################

// construct in controller : 
// ومن امثلتها تطييق middlewarw ع controller كله يعني مش هينفع مثلا تدخل الا وانت عامل auth 

    // public function __construct()
    // {
    //     $this->middleware("auth");
    // }
#########################################################################
   // add colum in laravel with migration : with artisan 
   // up like insert - down = rollback

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string("user_id")->after("check");
        });
    }

        /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn("user_id");
        });
    }
#########################################################################
// best practice routes
Route::group
(
    [
        "prefix" => "admin",
        // "as" => "admin."
        "middleware" => "IsAdmin",
    ],
    function () {
        Route::get("/", [DashboardController::class, "index"])->name("admin.index");
        Route::post("/admin/logout", [LoginController::class, "logout"])->name("admin.logout");
        
        Route::group
        (
            [
                "prefix" => "products",
                "as" => "products.",
                "controller"=> ProductController::class,
            ], function () {
                //best practice routes
                Route::get("/", "index")->name("index");
                Route::get("/create", "create")->name("create");
                Route::get("/{product}/edit", "edit")->name("edit"); //model in the middle
                Route::post("/", "store")->name("store");
                Route::put("/{product}", "update")->name("update");
                Route::delete("/{product}", "destroy")->name("destroy");
                //all routes = Route::resource("/", ProductController::class);
            }
        );       
    }
);
#########################################################################
delete all vs truncate in query builder : 
***************
delete all : 
هيمسح كله و لما تيجي تدخل داتا تاني ف db هيبدا من اخر id 
truncate in db : 
هيبدا من id = 1 وهيمسح كله 
DB::table('users')->delete();
DB::table('users')->truncate();
#########################################################################
// لو عايز اغير في اعدادات db - table - model 
class Post extends Model
{
    use HasFactory;
    protected $table="my_posts";
    public $timestamps = false;
    protected $primaryKey = 'post_id';
    public $incrementing = false;|
    protected $connection = 'sqlite';
}

#########################################################################
/*
soft deletes :
بيمسح الحاجه من interface 
وبيسبها ف db وبيزود حته deleted at 
بستخدم مع الحاحات المهمه والحساسه 
مثل فواتير بتتمسح عند العميل وبتفضل عندي 


*/


1- //model
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
}

2- // migration
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

// 3- controller : write delete"=soft delete"[and if u need final delete use force delete]
public function destroy(Product $product)
{
    $this->deleteImage(Product::PATH, $product->image);
    $product->delete();
    $this->alert("Product Has Been Deleted Successfully");
    return $this->indexRedirect();
}


/*
show data of soft delets like archiefs of deleted 

*/
public function show()
{
    $trashed_products = Product::onlyTrashed()->get(); 
    echo "<pre>";
    print_r($trashed_products);
}

// restore softdelets data 
#######################
// onlytrashed = withTrashed
// u can make it as button

public function show($id)
{
    $trashed_products = Product::onlyTrashed()->restore(); 
    // $trashed_products = Product::withTrashed()->where("id",$id)->restore(); //withtrashed "مع القمامه"
}
/*

forcedelete : 
after soft delete (delete from archive or db)


*/
public function show($id)
{
    $trashed_products = Product::onlyTrashed()->forceDelete(); //delete all
    // $trashed_products = Product::withTrashed()->where("id",$id)->forceDelete(); // specefic delete

}

##############################################################
/*

//import :
request = http
validator = facade

- api token access : token for login and logout like password but more complicated

-   public function __construct() // bec i cant use except in attributes of group
{
$this->middleware("auth:sanctum", ["except" => ["login", "register"]]);
}

-
$credentials = $request->only("email", "password");
if (Auth::attempt($credentials)) {
$user = Auth::user();
return response()->json([
"user" => $user,
"authorization" => [
"token" => $user->createToken("ApiToken")->plainTextToken, // u say create token named api token and return it as plain text
"type" => "bearer",
],
]);
}

    // u can do middleware here
    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum", ["except" => ["login", "register"]]);
    // }

     $token = auth()->user()->createToken($request->DeviceName ?? $request->userAgent())->plainTextToken;
     // بتاع الفرونت بيبعتلك اسم الجهاز مثل سامسونج - بوست مان - وبتحطه كنيم للتوكين 
     ولو مبعتهوش بتحط يوزر اجينت وهو بيجيب اسم الجهاز الل اتبعت منه  


     - api Tokens : 
        stateless..session..state management..mobile no session or cookie...token
        for every user when login ..hashed in db
   
 */

 ##################################################

/*

    class Categorycontroller extends Controller
    {
    public function index()
    {

    dd("hi api controller");
    return response()->json([
    "message" => "hello",
    ]);
    $categories = Category::all();
    return response()->json($categories); // return : array of objects
    }
    }

    public function store(Request $request){
    // dd("hi");
    // dd($request->all());
    $category = Category::create($request->all());
    return response()->json($category);
    }

    - in index - store : u access model itself : Model:: [no obj taken]
    update - delete : model binding - specific model - use : $obj ->

    //model binding cant with api bec find or fail .. return fail with view page 404 not found
    and i need to control that so i usr manual way

    public function update(Request $request, $id)
    {
    $category = Category::find($id);
    if (is_null($category)) { // is null = empty
    return response()->json([
    "message" => "Category Not Found", // must be key and value
    ]);
    }
    $category->update($request->all());
    return response()->json([
    "message" => "Category Updated Successfully",
    ]);
    }

    //validations :
    1- control return by validator
    2- knowing laravel im using application/json by header of request in postman

    public function update(Request $request, $id)
    {
    //findorfail
    $category = Category::find($id);
    if (is_null($category)) {
    return $this->apiResponse(404, "Category Not Found", "null", "null"); //parameter wrote in order
    }

    //errors[validation]
    $validator = Validator::make($request->all(), [
    "name" => "required|min:3|max:255|unique:categories,name," . $id,
    ]);
    if ($validator->fails()) {
    return $this->apiResponse(422, "Validation Error", $validator->errors(), "null");
    }

    //success- [db-return]
    $category->update($request->all());
    return $this->apiResponse(200, "Category Updated Successfully", "null", $category);
    }

    //Api Trait - Api design :
    u need to fix[نثبت] api design[response design] along application
    so we make ApiTrait and use it to do that
    and if i need to change something in design - change from one place

    // status code :
    404 : not found[fail]
    422 : validation error
    200 : success
    401 : Invalid Credentials or unauthorized error or unauthenticated
    201 : created successfully

 */


 <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\traits\ApiTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|string|email",
            "password" => "required|string",
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, "Validation Error", $validator->errors(), "null");
        }

        $credentials = $request->only("email","password");
        if(auth()->attempt($credentials) && auth()->user()->role == "admin") 
        {
            //create token
            $token = auth()->user()->createToken($request->DeviceName ?? $request->userAgent())->plainTextToken;
            return $this->apiResponse(201,"user login successfully","null",$token);
        }
        return $this->apiResponse(401,"Invalid Credentials");
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|min:3|max:5",
            "email" => "required|string|email",
            "password" => "required|string",
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, "Validation Error", $validator->errors(), "null");
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        return $this->apiResponse(200, "User Created Successfully", "null", $user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // current user
        return $this->apiResponse(200,"user Logout Successfully");
    }

    public function refresh()
    {
        return response()->json([
            "user" => Auth::user(),
            "authorization" => [
                "token" => Auth::refresh(),
                "type" => "bearer",
            ],
        ]);
    }
}

##############################################################
/*

//import :
request = http
validator = facade

- api token access : token for login and logout like password but more complicated

-   public function __construct() // bec i cant use except in attributes of group
{
$this->middleware("auth:sanctum", ["except" => ["login", "register"]]);
}

-
$credentials = $request->only("email", "password");
if (Auth::attempt($credentials)) {
$user = Auth::user();
return response()->json([
"user" => $user,
"authorization" => [
"token" => $user->createToken("ApiToken")->plainTextToken, // u say create token named api token and return it as plain text
"type" => "bearer",
],
]);
}

    // u can do middleware here
    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum", ["except" => ["login", "register"]]);
    // }

     $token = auth()->user()->createToken($request->DeviceName ?? $request->userAgent())->plainTextToken;
     // بتاع الفرونت بيبعتلك اسم الجهاز مثل سامسونج - بوست مان - وبتحطه كنيم للتوكين 
     ولو مبعتهوش بتحط يوزر اجينت وهو بيجيب اسم الجهاز الل اتبعت منه  


     - api Tokens : 
        stateless..session..state management..mobile no session or cookie...token
        for every user when login ..hashed in db
   
 */

 ##################################################

 <?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryRequest;
use App\Http\traits\ApiTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Categorycontroller extends Controller
{
    use ApiTrait;

    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum");
    // }

    public function index()
    {
        $categories = Category::all();
        return $this->apiResponse(200, "Data Retrieved Successfully", "null", $categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return $this->apiResponse(200, "Category Created Successfully", "null", $category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->apiResponse(404, "Category Not Found", "null", "null"); //parameter wrote in order
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|min:3|max:255|unique:categories,name," . $id,
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(422, "Validation Error", $validator->errors(), "null");
        }

        $category->update($request->all());
        return $this->apiResponse(200, "Category Updated Successfully", "null", $category);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->apiResponse(404, "Category Not Found", "null", "null");
        }

        $category->delete();
        return $this->apiResponse(200, "Category Deleted Successfully", "null", "null");
    }
}

##################################################

/*

    class Categorycontroller extends Controller
    {
    public function index()
    {

    dd("hi api controller");
    return response()->json([
    "message" => "hello",
    ]);
    $categories = Category::all();
    return response()->json($categories); // return : array of objects
    }
    }

    public function store(Request $request){
    // dd("hi");
    // dd($request->all());
    $category = Category::create($request->all());
    return response()->json($category);
    }

    - in index - store : u access model itself : Model:: [no obj taken]
    update - delete : model binding - specific model - use : $obj ->

    //model binding cant with api bec find or fail .. return fail with view page 404 not found
    and i need to control that so i usr manual way

    public function update(Request $request, $id)
    {
    $category = Category::find($id);
    if (is_null($category)) { // is null = empty
    return response()->json([
    "message" => "Category Not Found", // must be key and value
    ]);
    }
    $category->update($request->all());
    return response()->json([
    "message" => "Category Updated Successfully",
    ]);
    }

    //validations :
    1- control return by validator
    2- knowing laravel im using application/json by header of request in postman

    public function update(Request $request, $id)
    {
    //findorfail
    $category = Category::find($id);
    if (is_null($category)) {
    return $this->apiResponse(404, "Category Not Found", "null", "null"); //parameter wrote in order
    }

    //errors[validation]
    $validator = Validator::make($request->all(), [
    "name" => "required|min:3|max:255|unique:categories,name," . $id,
    ]);
    if ($validator->fails()) {
    return $this->apiResponse(422, "Validation Error", $validator->errors(), "null");
    }

    //success- [db-return]
    $category->update($request->all());
    return $this->apiResponse(200, "Category Updated Successfully", "null", $category);
    }

    //Api Trait - Api design :
    u need to fix[نثبت] api design[response design] along application
    so we make ApiTrait and use it to do that
    and if i need to change something in design - change from one place

    // status code :
    404 : not found[fail]
    422 : validation error
    200 : success
    401 : Invalid Credentials or unauthorized error or unauthenticated
    201 : created successfully

 */

#################################################################

<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreProductRequest;
use App\Http\Requests\Api\Product\UpdateProductRequest;
use App\Http\traits\FileTrait;
use Exception;

class ProductController extends Controller
{
    use ApiTrait;
    use FileTrait;

    public function index()
    {
        $products = Product::get();
        return $this->apiResponse(200, "Data Retrieved Successfully", "null", $products);
    }

    public function store(StoreProductRequest $request)
    {
        try
        {
            $image_name = $this->uploadImage(Product::PATH,$request->image);

            $products = Product::create([
                "name" => $request->name,
                "description" => $request->description, 
                "price" => $request->price,
                "category_id" => $request->category_id,
                "image" => $image_name,
            ]);

            return $this->apiResponse(200, "Product Created Successfully", "null", $products);
        }catch(Exception $e)
        {
            return $this->apiResponse(500,"Something went really wrong");
        }
     
    }

 

    public function update(UpdateProductRequest $request, Product $product)
    {
     
        if($request->hasFile("image"))
        {
            $image_name = $this->uploadImage(Product::PATH,$request->image,$product->image);
        }

        $product->update([
            "name" => $request->name,
            "description" => $request->description, 
            "price" => $request->price,
            "category_id" => $request->category_id,
            "image" => $image_name ?? $product->image,
        ]);
        return $this->apiResponse(200, "Product updated Successfully", "null", $product);
    }

    
    public function destroy(Product $product)
    {
    
        //delete img in public
        $this->deleteImage(Product::PATH , $product->image);
        //delete product from db
        $product->delete();
        return $this->apiResponse(200, "Product Deleted Successfully", "null", "null");
    }
    // public function destroy($id)
    // {
    //     $product = Product::find($id);
    //     if (is_null($product)) {
    //         return $this->apiResponse(404, "Category Not Found", "null", "null");
    //     }
    //     //delete img in public
    //     $this->deleteImage(Product::PATH , $product->image);
    //     //delete product from db
    //     $product->delete();
    //     return $this->apiResponse(200, "Product Deleted Successfully", "null", "null");
    // }

}


##################################################
/*
// difference between store and update validations : 
    image : store : required - update: nullable
    , name :  store : unique , update : unique except id

// اي use مطفيه امسحها
*/


###################################################

<?php

namespace App\Http\Requests\Api;

use App\Http\traits\ApiTrait;
use Illuminate\Foundation\Http\FormRequest as OrgFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends OrgFormRequest
{

    use ApiTrait;

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(422, "Validation Error", $validator->errors()));  
    }

}

####################################################

// use Illuminate\Contracts\Validation\Validator; //opposite controller : facade/validator


########################################################################


<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\FormRequest;

class StoreCategoryRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            "name" => "required|min:3|max:255|unique:categories,name",
        ];
    }

}

###################################################################

<?php

namespace App\Http\Requests\Api\Product;

use App\Models\Product;
use App\Http\Requests\Api\FormRequest;


class StoreProductRequest extends FormRequest
{
  
    public function rules(): array
    {
        return array_merge(Product::rules(),

        [
            "name" => "required|string|min:3|max:225|unique:products,name",
            "image" => "required|image|mimes:jpg,png,jpeg|max:2048",
        ]);
    }
}


################################################################

<?php

namespace App\Http\Requests\Api\Product;

use App\Models\Product;
use App\Http\Requests\Api\FormRequest;


class UpdateProductRequest extends FormRequest
{


    public function rules(): array
    {
        return array_merge( Product::rules() ,
        [
            "name" => "required|string|min:3|max:225|unique:products,name," . $this->id , 
            "image" => "nullable|image|mimes:png,jpg,jpeg|max:2048",
        ]);
    }

}


############################################
/*

"name" => "required|string|min:3|max:225|unique:products,name," . $this->id , 
//هنا ببعت ريكويست معاه بارميتير id 
ع عكس موديل binding ببعت ريكويست جواه موديل ب id

*/

###########################################################

<?php
namespace App\Http\traits;

use App\Models\Product;

trait ApiTrait
{
    private function apiResponse($code = 200, $message = null, $errors = "null", $data = "null")
    {
        $array = [
            "status" => $code,
            "message" => $message,
            "errors" => $errors,
            "data" => $data,
        ];
        return response()->json($array, 200);
    }

}

##################################################

//kamal : 

// trait ApiTrait
// {
//     private function apiResponse($code = 200, $message = null, $errors = null, $data = null)
//     {
//         $array = [
//             "status" => $code,
//             "message" => $message,
//         ];

//         if (is_null($data) && !is_null($errors)) {
//             $array["errors"] = $errors;
//         } elseif (!is_null($data) && is_null($errors)) {
//             $array["data"] = $data;
//         } else {
//             $array["errors"] = $errors;
//             $array["data"] = $data;
//         }

//         return response()->json($array, 200);
//     }
// }


/*
// difference between store and update validations : 
    image : store : required - update: nullable
    , name :  store : unique , update : unique except id


*/


#########################################################################

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->boolean("check")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};


#############################################################################

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string("user_id")->after("check");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn("user_id");
        });
    }
};


#####################################################################


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};



##############################################################################


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //pivot table in laravel must be alphabetic order ex: r before s ,  and single
        Schema::create('region_store', function (Blueprint $table) {
            $table->id();
            $table->foreignId("region_id")->constrained("regions")->onDelete("cascade");
            $table->foreignId("store_id")->constrained("stores")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions_stores');
    }
};



#################################################################################


<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Categorycontroller;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */



//Auth 
Route::controller(AuthController::class)->group(function () {
    Route::post("login", "login")->middleware("guest:sanctum"); //redirect if authenticated
    Route::post("register", "register");
    Route::post("logout", "logout")->middleware("auth:sanctum");
});


//category
Route::get("admin/categories/index", [Categorycontroller::class, "index"]);
Route::post("admin/categories/store", [Categorycontroller::class, "store"])->middleware("auth:sanctum");
Route::post("admin/categories/update/{id}", [Categorycontroller::class, "update"]);
Route::post("admin/categories/destroy/{id}", [Categorycontroller::class, "destroy"]);

//product
Route::controller(ProductController::class)->group(function(){
    Route::get("index","index");
    Route::post("store","store");
    Route::post("update/{product}","update");
    Route::post("destroy/{product}","destroy");
});

########################################################

// Route::controller(ProductController::class)->middleware("auth:sanctum")->group(function(){}

//    Route::post("login", "login")->middleware("guest:sanctum"); //redirect if authenticated (kernel.guest.redirect if authenticated)



############################################################################

//route service provider - seprate admin from web 
######################################

$this->routes(function () {
    Route::middleware('api')
        ->prefix('api')
        ->group(base_path('routes/api.php'));

    Route::middleware('web')
        ->name("user.")
        ->group(base_path('routes/web.php'));
        //لايفضل بريفكس هنا سيبها دايركت

    Route::middleware('web')
        ->prefix("admin")
        ->name("admin.")
        ->group(base_path('routes/admin.php'));//لازم دي ف الاخر 

});


########################################################
//redirect if authnicated
public const HOME = '/';//خلي الموقع دايركت يفتح فرونت 
public const ADMIN = 'admin';//admin/ = index
########################################################
//rename dashboard or current user
<a href="#" class="d-block">{{ auth()->user()->name }}</a>
########################################################
عود نفسك تعمل validations فرونت وباك : htmal & php ex : input rquired
<input type="text" name="name" class="form-control" placeholder="Enter Section Name" required>
########################################################
تقطيع - تقسيم assets 
___________________________ 

1-css href link :
href="
href="{{ asset("AdminAssets") }}/


2-img,js src link:
src="
src="{{ asset("AdminAssets") }}/


how to confirm im right : 
CTRL + U ... and all links work
f12 - consle no error

-sideNotes:
في تقطيع اي صفحه مفيش دي ../ لانك بترروح ع الفولدر علطول 
ولو الصفحه اللي عايزها ف سكربتات css و js خارجيه لازم تعملهم yield

########################################################
use trait - class 
##########
اي use تقدر تستخدمها من خلال فانكشن 
use trait : كانك عملت كوبي جوا الكلاس وتقدر تستخدمها ب this حتي لو برايفت 
use class : كانك عملت كوبي برا كلاس وتقدر تستخدم حاجات static 
########################################################
DEAL WITH FILES 
####################
place : config....filesystems...Filesystem Disks
"public_uploads" => [
    'driver' => 'local',
    'root' => public_path() . "/files/invoices",
],
########################################################
redirect->back 
##########
لو حاجه حركه واحده مثل هضيف وارجع او هحذف وارجع
########################################################
model binding 
##############
ف فورم مش بحتاج ا bind ف route لان كده كده ريكويست شايلها 
ف فورم مش بحتاج ابعت داتا ف route لان كده كده ريكويست شايلها 
########################################################
load - with - relations - relationship ...
###########
 model binding use load in relation - without model binding use with (جربت استخدم with مع موديل مش بتظبط - موديلب نفسه داتا بتاعته مش بتظبط فليه ؟)

$invoice->load('details', 'attachments','section');
on loop -> $invoice->attachments
########################################################
model name
#########
بلاش تعمل موديل ب _ هيقرفك ف import
########################################################
text areat : 
############
الفاليو بتبقي ف النص 

<textarea class="form-control" name="note"  id="exampleTextarea" rows="3">{{ old("note") ?? $invoice->note }}</textarea>
########################################################
load 
#######
بتجيب الفاتوره بالحاجه اللي مرتب طه بالفاتوره دي بس مش كله 
$invoice->load('details', 'attachments','section');
########################################################
index - show 
########
retrieve 1 row -> first - direct access 
retrieve >1 row -> get - foreach  
########################################################
key - form - colum 
##########
access property by key or name of variable 
so focus on name of colums and input - خليهم سعلين وثابتنين بطريقه عشان تفتكره 
واليوزر روق عليه ف الفيو 
########################################################
select : name on select - value on option 
so old be on option 
<option value="{{ old("rate_vat") ?? $invoice->rate_vat }}" >{{ $invoice->rate_vat }}</option>

########################################################
find or fail 
########
$invoice = Invoice::findOrfail($request->invoice_id);
########################################################

get vs first 
###########
first: get single model 
use cases : find 

get : get collection of models 
use cases : retrive multible models or data or rows to diplay or foreach on them 
########################################################
select with integer best than string and faster ex : where value status = 2 - unpaid 
select : name - attributes in select - just value in option 
page header : section / branch 
make colum name in details like : section name not section only 
onlytrached : all soft delets vs withtrashed : all including soft delete and others  
send data with form or route or compact 
########################################################
/*

When you install a new package, the package's files are added to the vendor directory. The composer dump-autoload command will scan the vendor directory and update the autoloader to include the classes that are in the new package.

*/

composer dump-autoload
########################################################
laravel - exel : 
##########
composer require maatwebsite/excel:^3.1 --ignore-platform-reqs
then complete the rest from here 
https://docs.laravel-excel.com/3.1/getting-started/installation.html

reason : composer require download old version ... 1 

how to export excel 
############
https://docs.laravel-excel.com/3.1/exports/

################################################
spatie 
#######

https://spatie.be/docs/laravel-permission/v5/installation-laravel

// if use spatie html : 
use composer require spatie/laravel-html
not laravel/html

################################################
laravel html - form : 
###################
{!! Form::text('name', null, array('class' => 'form-control')) !!}

<label
style="font-size: 16px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
{{ $value->name }}</label>

The first argument is the name of the input field.
The second argument is the value of the input field.
The third argument is the default value of the input field.
The fourth argument is an array of attributes for the input field.
################################################





