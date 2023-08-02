<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Invoice\InvoiceArchiveController;
use App\Http\Controllers\Admin\Invoice\InvoiceAttachmentController;
use App\Http\Controllers\Admin\Invoice\InvoiceDetailController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\Permission\RoleController;
use App\Http\Controllers\Admin\Permission\UserController;
use App\Http\Controllers\Admin\Reports\InvoiceReportController;
use App\Http\Controllers\Admin\Reports\CustomerReportController;
use App\Http\Controllers\Admin\Settings\ProductController;
use App\Http\Controllers\Admin\Settings\SectionController;
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

//login
Route::group
    (
    [
        "prefix" => "admin",
        "as" => "admin.",
        "middleware" => "guest",
        "controller" => AuthController::class,
    ],
    function () {
        Route::get("login", "loginPage")->name("loginPage");
        Route::post("login", "login")->name("login");
    }
);

Route::group
    (
    [
        "prefix" => "admin",
        "as" => "admin.",
        "middleware" => "auth",
    ],
    function () {
        Route::get("/", [AdminController::class, "index"])->name("index");
        Route::post("logout", [AuthController::class, "logout"])->name("logout");

        //sections
        Route::group
            (
            [
                "prefix" => "sections",
                "as" => "sections.",
                "controller" => SectionController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");
                Route::get("create", "create")->name("create");
                Route::post("/", "store")->name("store");
                Route::get("{section}/edit", "edit")->name("edit");
                Route::put("{section}", "update")->name("update");
                Route::delete("{section}", "destroy")->name("destroy");
            }
        );

        //products
        Route::group
            (
            [
                "prefix" => "products",
                "as" => "products.",
                "controller" => ProductController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");
                Route::get("create", "create")->name("create");
                Route::post("/", "store")->name("store");
                Route::get("{product}/edit", "edit")->name("edit");
                Route::put("{product}", "update")->name("update");
                Route::delete("{product}", "destroy")->name("destroy");
            }
        );

        //invoices
        Route::group
            (
            [
                "prefix" => "invoices",
                "as" => "invoices.",
                "controller" => InvoiceController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");
                Route::get("{invoice}/show", "show")->name("show");
                Route::get('/section/{section}', 'getProducts'); //here correct ?
                Route::get("create", "create")->name("create");
                Route::post("/", "store")->name("store");
                Route::get("{invoice}/edit", "edit")->name("edit");
                Route::put("{invoice}", "update")->name("update");
                Route::delete("/", "destroy")->name("destroy");
                Route::get("{invoice}/print", "print")->name("print");
                Route::get('export', 'export')->name("export");
                Route::get('mark_all', 'markAll')->name("mark_all");

            }
        );

        //invoiceAttachment
        Route::group
            (
            [
                "prefix" => "attachments",
                "as" => "attachments.",
                "controller" => InvoiceAttachmentController::class,
            ],
            function () {
                Route::get("{attachment}/open_file", "openFile")->name("open_file");
                Route::get("{attachment}/download_file", "downloadFile")->name("download_file");
                Route::post("/", "store")->name("store");
                Route::delete("/", "destroy")->name("destroy");

            }
        );

        //invoiceDetails
        Route::group
            (
            [
                "prefix" => "details",
                "as" => "details.",
                "controller" => InvoiceDetailController::class,
            ],
            function () {
                Route::get("{invoice}/edit_status", "editStatus")->name("edit_status");
                Route::put("{invoice}", "updateStatus")->name("update_status");
                Route::get("paid", "paid")->name("paid");
                Route::get("unpaid", "unPaid")->name("unpaid");
                Route::get("partial_paid", "partialPaid")->name("partial_paid");
            }
        );

        //InvoiceArchive
        Route::group
            (
            [
                "prefix" => "archives",
                "as" => "archives.",
                "controller" => InvoiceArchiveController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");
                Route::put("/", "update")->name("update");
                Route::delete("/", "destroy")->name("destroy");

            }
        );

        //invoices reports
        Route::group
            (
            [
                "prefix" => "invoices_reports",
                "as" => "invoices_reports.",
                "controller" => InvoiceReportController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");         
                Route::post("search", "search")->name("search");         
            }
        );

        //customers reports
        Route::group
            (
            [
                "prefix" => "customers_reports",
                "as" => "customers_reports.",
                "controller" => CustomerReportController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");         
                Route::post("search", "search")->name("search");         
            }
        );

        //roles
        Route::group
            (
            [
                "prefix" => "roles",
                "as" => "roles.",
                "controller" => RoleController::class,
            ],
            function () {

                Route::get("/", "index")->name("index");
                Route::get("{role}/show", "show")->name("show");
                Route::get("create", "create")->name("create");
                Route::post("/", "store")->name("store");
                Route::get("{role}/edit", "edit")->name("edit");
                Route::put("{role}", "update")->name("update");
                Route::delete("/", "destroy")->name("destroy");
            }
        );

        //users
        Route::group
            (
            [
                "prefix" => "users",
                "as" => "users.",
                "controller" => UserController::class,
            ],
            function () {
                Route::get("/", "index")->name("index");
                Route::get("{user}/show", "show")->name("show");
                Route::get("create", "create")->name("create");
                Route::post("/", "store")->name("store");
                Route::get("{user}/edit", "edit")->name("edit");
                Route::put("{user}", "update")->name("update");
                Route::delete("/", "destroy")->name("destroy");

            }
        );

    }
);
