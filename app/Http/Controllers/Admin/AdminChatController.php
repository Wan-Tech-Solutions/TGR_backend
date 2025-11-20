<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminChatController extends Controller
{
    //
    public function tgr_chat(){
        return view('adminPortal.chat.tgr_chat');
    }
}
