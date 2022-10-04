<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cordinate;
use App\Models\Media;
use DB;
class MemberController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'user_id'=>'required|max:191',
            'file'=>'required'
        ]);

        if($request->hasFile('file')){
            $uniqueid=uniqid();
            $original_name=$request->file('file')->getClientOriginalName();
            $size=$request->file('file')->getSize();
            $extension=$request->file('file')->getClientOriginalExtension();
            $name=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            $imagepath=url('/storage/uploads/files/'.$name);
            $path=$request->file('file')->storeAs('public/uploads/files/',$name);

            $media=new Media;

            $media->user_id=$request->user_id;
            $media->file=$name;
            $media->type='audio';
            $media->path=$path;
            $media->save();
            return response()->json(['message'=>'Record save successfully'],200);
        }else{
            return response()->json(['message'=>'audio file required'],201);
        }
    }
    public function storeCoordinates(Request $request){
        $data= $request->validate([
            'user_id'=>'required|max:191',
            'lat'=>'required',
            'lang'=>'required',
        ]);
        $cordinates=new Cordinate;
        $cordinates->user_id=$request->user_id;
        $cordinates->lat=$request->lat;
        $cordinates->lang=$request->lang;
        $cordinates->save();
        return response()->json(['message'=>'Record save successfully'],200);
    }

    public function storeCsv(Request $request){



        $data= $request->validate([
            'user_id'=>'required|max:191',
            'file'=>'required',

        ]);


        if($request->hasFile('file')){
            $uniqueid=uniqid();
            $original_name=$request->file('file')->getClientOriginalName();
            $size=$request->file('file')->getSize();
            $extension=$request->file('file')->getClientOriginalExtension();
            $name=Carbon::now()->format('Ymd').'_'.$uniqueid.'.'.$extension;
            $imagepath=url('/storage/uploads/files/'.$name);
            $path=$request->file('file')->storeAs('public/uploads/files/',$name);

            $media=new Media;
            $media->user_id=$request->user_id;
            $media->file=$name;
            $media->type='csv';
            $media->path=$path;
            if($media->save())
            {
                return response()->json(['message'=>'Record save successfully'],200);
            }
            else{
                return response()->json(['message'=>'Record not save '],200);
            }
        }
        else{
            return response()->json(['message'=>'audio file required'],201);
        }
    }


    public function getRecordings(Request $request){
        $data=$request->all();
        if($data){
            $recList=Media::orderBy($data['sortBy'], 'DESC')->get();
            echo  json_encode($recList);
        }else{
            $recList = Media::join('users', 'media.user_id', '=', 'users.id')
                ->select('users.name','media.*')
                ->where('media.type', '=' ,'audio')
                ->get();
            echo  json_encode($recList);
        }
    }
    public function deleteRecordings(Request $request){
        $id=$request->id;
        $rec = Media::find($id);
        ;
        if($rec){
            $rec->delete();
            return  response()->json(['message'=>'Record deleted'],200);
        }else{
            return  response()->json(['message'=>'Record not deleted'],200);
        }
    }
//memberMedia
    public function memberMedia(){
        return view('media-list');
    }
    public function getAudio($id)
    {
        $find=Media::find($id);
        $pathToFile=storage_path()."/app/". $find->path;
        return response()->download($pathToFile);
    }



    public function  memberFiles(){
        return view('member-file');
    }

    public function getFilesList(Request $request){

        $recList = Media::join('users', 'media.user_id', '=', 'users.id')
            ->select('users.name','media.*')
            ->where('media.type', '=' ,'csv')
            ->get();
        echo  json_encode($recList);
    }


    //memberCoordinates
    public function  memberCoordinates(){
        return view('member-coordinates');
    }


//getCoordinateList
    public function getCoordinateList(Request $request){

        $articles = DB::table('cordinates')
            ->select('users.name','cordinates.*' )
            ->join('users', 'cordinates.user_id', '=', 'users.id')
            ->orderBy('cordinates.id','DESC')
            ->get();

        echo  json_encode($articles);
    }
}

