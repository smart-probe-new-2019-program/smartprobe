<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use File;
use App\FileEntry;

class FileEntriesController extends Controller
{
	private $status;
	private $data;

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FileEntry::all();
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllFiles(Request $request)
    { 
		$organization_id = $request['organization_id'];

		$files = FileEntry::with('organization');

		if($organization_id){
			$files = $files->where('organization_id', $organization_id);
		}
		
		$files = $files->orderBy('created_at','desc')->paginate(5);

		return $files;
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
		$organization_id = $request['organization_id'];
		$created_by = $request['created_by'];
		$updated_by = $request['updated_by'];
        $file = Input::file('file');
        $filename = $file->getClientOriginalName();

        $path = hash( 'sha256', time());

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {
            $input['filename'] = $filename;
            $input['mime'] = $file->getClientMimeType();
            $input['path'] = $path;
			$input['size'] = $file->getClientSize();
			$input['organization_id'] = $organization_id;
			$input['created_by'] = $created_by;
			$input['updated_by'] = $updated_by;
            $file = FileEntry::create($input);

            return response()->json([
                'status' => 'success',
            ], 200);
        }
        return response()->json([
            'status' => 'error'
        ], 500);
	}
	
	/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
			//get file details
			$file = FileEntry::findOrFail($id);
			$path = $file['path'];
			$filename = $file['filename']; 
			
			if($path && $filename){
				//delete file first then folder
				$super_path = storage_path().'/files/uploads/'.$path.'/'.$filename;
				if(file_exists($super_path)) {
					unlink($super_path);
					rmdir(storage_path().'/files/uploads/'.$path);
				}
			}

			FileEntry::find($id)->delete();
			$this->status = 'success';
		}
		catch(\Illuminate\Database\QueryException $ex){
			$this->status = 'error';
			$this->data = $ex->getMessage();
		}

		return response()->json(['status' => $this->status, 'data' => $this->data]);
    }
}
