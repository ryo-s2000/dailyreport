<?php

namespace App\Http\Controllers;

use App\Dailyreport;
use App\Signature;
use Illuminate\Http\Request;
use App\Http\Requests\SignatureRequest;

class SignatureController extends Controller
{
    public function newSignature(Request $request){
        $signature = new Signature;

        return view('newsignature', ['reportid' => $request->reportid, "signature" => $signature]);
    }

    public function saveSignature(SignatureRequest $request){
        $dailyreport = Dailyreport::find($request->reportid);
        if($dailyreport == null){
            return redirect('/');
        }

        $signature = new Signature;
        $signature->reportid = $request->reportid;

        $form = $request->signatureAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        $signature->fill($form)->save();

        return redirect("/$request->reportid");
    }

    public function editSignature(Request $request){
        $signature = Signature::find($request->signatureid);
        if($signature == null){
            return redirect('/');
        }
        return view('newsignature', ['signatureid' => $request->signatureid, "signature" => $signature]);
    }

    public function saveEditSignature(SignatureRequest $request){
        $signature = Signature::find($request->signatureid);
        if($signature == null){
            return redirect('/');
        }

        $form = $request->signatureAttributes();
        unset($form['_token']);

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        $signature->fill($form)->save();

        return redirect("/$signature->reportid");
    }

    public function deleteSignature(Signature $signatureid, $reportid){
        if( !(Signature::find($signatureid)) ){
            return redirect('/');
        }
        $signatureid->delete();

        return redirect($reportid);
    }
}
