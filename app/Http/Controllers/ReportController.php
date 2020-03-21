<?php

namespace App\Http\Controllers;

use Image;
use Storage;
use App\Dailyreport;
use App\Construction;
use App\Signature;
use Illuminate\Http\Request;
use App\Http\Requests\DailyreportRequest;

class ReportController extends Controller
{
    public function newReport(){
        $dailyreport = new Dailyreport;
        $dailyreport->date = date("Y-m-d");
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function editReport(Request $request){
        $dailyreport = Dailyreport::find($request->reportid);
        if($dailyreport == null){
            return redirect('/');
        }
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function saveEditReport(DailyreportRequest $request, $reportid){
        $dailyreport = Dailyreport::find($reportid);
        if($dailyreport == null){
            return redirect('/');
        }

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // 画像保存処理
        foreach (range(1,5) as $i){
            $name = 'imagepath' . $i;
            $file = $request->file($name);
            if($file != null){
                $fileName = $file->getClientOriginalExtension();
                if($fileName == "jpg" or $fileName == "jpeg" or $fileName == "png" or $fileName == "JPEG" or $fileName == "JPG" or $fileName == "PNG"){
                    // リサイズ処理
                    $image = Image::make($file);
                    $image->resize(180, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imageResized = md5($image->__toString());
                    $image->save(public_path('images/'.$imageResized));
                    $savedImageUri = $image->dirname.'/'.$image->basename;

                    // 保存処理
                    $path = Storage::disk('s3')->putFile('/', $savedImageUri, 'public');
                    $dailyreport->$name = Storage::disk('s3')->url($path);

                    // リサイズ中のごみファイル削除
                    $image->destroy();
                    unlink($savedImageUri);
                }
            }
        }

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if($transitionPreview == 'true'){
            $redirectPath = '/pdf/' . $dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function saveReport(DailyreportRequest $request){
        $dailyreport = new Dailyreport;

        $form = $request->dailyreportAttributes();
        unset($form['_token']);

        // 画像保存処理
        foreach (range(1,5) as $i){
            $name = 'imagepath' . $i;
            $file = $request->file($name);
            if($file == null){
                $dailyreport->$name = "";
            } else {
                $fileName = $file->getClientOriginalExtension();
                if($fileName == "jpg" or $fileName == "jpeg" or $fileName == "png"){
                    // リサイズ処理
                    $image = Image::make($file);
                    $image->resize(180, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imageResized = md5($image->__toString());
                    $image->save(public_path('images/'.$imageResized));
                    $savedImageUri = $image->dirname.'/'.$image->basename;

                    // 保存処理
                    $path = Storage::disk('s3')->putFile('/', $savedImageUri, 'public');
                    $dailyreport->$name = Storage::disk('s3')->url($path);

                    // リサイズ中のごみファイル削除
                    $image->destroy();
                    unlink($savedImageUri);
                }
            }
        }

        // nullを空文字に変更
        foreach ($form as $key => $item){
            if($item == null){
                $form[$key] = "";
            }
        }

        // 遷移先を変更する。
        $transitionPreview = $form['transition-preview'];
        unset($form['transition-preview']);

        // データを詰め込む
        $dailyreport->fill($form)->save();
        $dailyreportId = $dailyreport->id;

        $redirectPath = '/';
        if($transitionPreview == 'true'){
            $redirectPath = '/pdf/' . $dailyreportId;
        }

        return redirect($redirectPath);
    }

    public function copyReport(Request $request){
        $dailyreport = Dailyreport::find($request->reportid);
        $dailyreport->date = date("Y-m-d");
        $dailyreport->imagepath1 = '';
        $dailyreport->imagepath2 = '';
        $dailyreport->imagepath3 = '';
        $dailyreport->imagepath4 = '';
        $dailyreport->imagepath5 = '';

        if($dailyreport == null){
            return redirect('/');
        }
        $constructions = Construction::all();
        return view('newreport', ['dailyreport' => $dailyreport, "constructions" => $constructions]);
    }

    public function deleteReport(Dailyreport $reportid){
        if( !(Dailyreport::find($reportid)) ){
            return redirect('/');
        }

        $reportid->delete();

        return redirect('/');
    }

    public function showReport(Request $request){
        $dailyreport = Dailyreport::find($request->reportid);
        if($dailyreport == null){
            return redirect('/');
        }

        $signatures = Signature::where('reportid', $request->reportid)->get();
        return view('showreport', ['dailyreport' => $dailyreport, 'signatures' => $signatures]);
    }

    public function index(Request $request){
        function condition($value = null){
            if($value){
                return '=';
            } else {
                return 'LIKE';
            }
        }

        function value($value = null){
            if($value){
                return $value;
            } else {
                return '%';
            }
        }

        $dailyreports = Dailyreport::where('userName', condition($request->userName), value($request->userName))
            ->where('department', condition($request->department), value($request->department))
            ->where('constructionNumber', condition($request->constructionNumber), value($request->constructionNumber));
        switch ($request->sort){
            case '日付が早い順':
                $dailyreports = $dailyreports->orderBy('date')->paginate(100);
                break;
            case '日付が遅い順':
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);
                break;
            default:
                $dailyreports = $dailyreports->orderByDesc('date')->paginate(100);
        }

        $dailyreportsPalams = array(
            'userName' => $request->userName,
            'department' => $request->department,
            'constructionNumber' => $request->constructionNumber,
            'constructionName' => $request->constructionName,
            'sort' => $request->sort,
        );

        $allDailyreports = Dailyreport::all();
        $constructions = Construction::all();
        return view('top', ["dailyreports" => $dailyreports, "dailyreportsPalams" => $dailyreportsPalams, "allDailyreports" => $allDailyreports, "constructions" => $constructions]);
    }
}
