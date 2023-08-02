<?php 
namespace App\Http\Traits;

trait RedirectTrait
{
    private function redirect($message,$route)
    {
        alert()->success($message);
        return redirect()->route($route);
    }

    private function redirectBack($message)
    {
        alert()->success($message);
        return redirect()->back();
    }
}