<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SentEmail;
use App\Mail\SendEmail;
use Webklex\IMAP\Facades\Client as ImapClient;

class AdminEmailController extends Controller
{
    //
    public function tgr_mail()
{
    // Connect to the mail server
    $client = ImapClient::account('default');
    $client->connect();

    // Select inbox
    $inbox = $client->getFolder('INBOX');

    // Fetch emails and order by date descending (newest first)
    $messages = $inbox->messages()->all()->limit(10)->get()->sortByDesc(function ($message) {
        return \Carbon\Carbon::parse($message->getDate());
    });

    return view('adminPortal.email.tgr_mail', compact('messages'));
}



    public function tgr_sent_mail(){
        $sent_emails = SentEmail::orderby('created_at','desc')->get();
        return view('adminPortal.email.tgr_sent_mail',compact('sent_emails'));
    }


    public function spamMail()
{
    try {
        // Connect to the mail server
        $client = ImapClient::account('default');
        $client->connect();

        // Fetch all available folders to check if SPAM exists
        $folders = $client->getFolders();
        $spamFolder = null;

        foreach ($folders as $folder) {
            if (strtolower($folder->name) === 'spam') {
                $spamFolder = $folder;
                break;
            }
        }

        if (!$spamFolder) {
            return back()->with('error', 'SPAM folder not found.');
        }

        // Fetch emails from SPAM
        $messages = $spamFolder->messages()->all()->limit(10)->get();

        return view('adminPortal.email.tgr_spam_mail', compact('messages'));

    } catch (\Exception $e) {
        \Log::error("IMAP Error: " . $e->getMessage());
        return back()->with('error', 'Failed to retrieve SPAM emails.');
    }
}    

   

public function trashMail()
{
    try {
        // Connect to the mail server
        $client = ImapClient::account('default');
        $client->connect();

        // Fetch all available folders to check if SPAM exists
        $folders = $client->getFolders();
        $trashFolder = null;

        foreach ($folders as $folder) {
            if (strtolower($folder->name) === 'trash') {
                $trashFolder = $folder;
                break;
            }
        }

        if (!$trashFolder) {
            return back()->with('error', 'Trash folder not found.');
        }

        // Fetch emails from SPAM
        $messages = $trashFolder->messages()->all()->limit(10)->get();

        return view('adminPortal.email.tgr_trash_mail', compact('messages'));

    } catch (\Exception $e) {
        \Log::error("IMAP Error: " . $e->getMessage());
        return back()->with('error', 'Failed to retrieve Trash emails.');
    }
}


    public function getEmailDetails($id)
{
    $email = SentEmail::find($id);

    if (!$email) {
        return response()->json(['success' => false, 'message' => 'Email not found'], 404);
    }

    return response()->json([
        'success' => true,
        'email' => [
            'recipient_email' => $email->recipient_email,
            'subject' => $email->subject,
            'message' => nl2br(e($email->message)),
            'attachment' => $email->attachment,
            'created_at' => $email->created_at->format('F j, Y, g:i a')
        ]
    ]);
}
}
