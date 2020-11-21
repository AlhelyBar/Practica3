<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CorreoMailJet;

class MailController extends Controller
{
    public function sendMail(){
        $mail=Mail::to('alhely@gmail.com')->send(new CorreoMailJet());
        return response()->json(["mail"=>$mail],200);    
    }
}
