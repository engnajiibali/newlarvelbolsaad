<?php

namespace App\Http\Controllers;

use App\Models\Keydin;
use App\Models\Item;
use App\Models\Department;
use App\Models\Assignhub;
use App\Models\Shaqsiyaadka;
use App\Models\AssignShaqsi;
use App\Models\AssignHubToStore;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KeydinController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Load Keydin with related models
            $data = Keydin::with(['FadhiIdRelation', 'QaybtaHubkaRelation'])
                ->latest('keydin_ID')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('qaybta_hubka', function ($row) {
                    return $row->QaybtaHubkaRelation->ItemName ?? 'N/A';
                })
                ->addColumn('fadhiga', function ($row) {
                    return $row->FadhiIdRelation->name ?? 'N/A';
                })
                ->editColumn('keydin_image1', function ($row) {
                    if (empty($row->keydin_image1)) {
                        return null;
                    }
                    $images = array_map('trim', explode(',', $row->keydin_image1));
                    $firstImage = $images[0] ?? null;
                    if (!$firstImage) {
                        return null;
                    }
                    return Storage::disk('s3')->url($firstImage);
                })
                ->editColumn('keydin_Xalada', function ($row) {
                    if ($row->keydin_Xalada == 0) {
                        return '<span class="badge bg-secondary">Kaydsan</span>';
                    } elseif ($row->keydin_Xalada == 1) {
                        return '<span class="badge bg-success">La Bixiyay</span>';
                    } else {
                        return '<span class="badge bg-warning text-dark">Unknown</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    // Always show View button
                    $btn = '<a href="' . route('keydin.show', $row->keydin_ID) . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> ';
                    
                    // ROLE CHECK: Only show Edit/Delete if role_id is 1
                    if (auth()->user()->role_id == 1) {
                        $btn .= '<a href="' . route('keydin.edit', $row->keydin_ID) . '" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                        $btn .= '<button data-id="' . $row->keydin_ID . '" class="deleteKeydin btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action', 'keydin_Xalada'])
                ->make(true);
        }

        return view('pages.keydin.index');
    }

    public function searchKeydin(Request $request)
    {
        $query = Keydin::query()->with(['FadhiIdRelation', 'QaybtaHubkaRelation']);

      
        
        if ($request->filled('qaybta')) {
            $query->where('keydin_itemID', $request->qaybta);
        }

        if ($request->filled('fadhiga')) {
            $query->where('FadhiId', $request->fadhiga);
        }

        if ($request->filled('status')) {
            $query->where('keydin_Xalada', $request->status);
        }

        if ($request->filled('Qorinumber')) {
            $Qorinumber = strtoupper($request->Qorinumber);
            $query->where('keydin_lambarka1', 'like', "%{$Qorinumber}%");
        }
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('keydin_CreateDate', [$request->date_from, $request->date_to]);
        }

        $keydins = $query->paginate(10)->appends($request->except('page'));

        $pageTitle = "Keydin";
        $subTitle = "Natiijada Raadinta";
        $AllKeydin = Keydin::count();
        $ActiveKeydin = Keydin::where('keydin_Xalada', 1)->count();
        $InactiveKeydin = Keydin::where('keydin_Xalada', 0)->count();
           $shaqsiyadka = Keydin::where('keydin_Xalada', 2)->count();
        $NewThisWeek = Keydin::whereBetween('keydin_CreateDate', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        $entries = $keydins->total();
        $Item = Item::all();
        $fadhiyada = Department::all(); 
        
        return view('pages.keydin.list', compact(
            'keydins', 'pageTitle', 'subTitle', 'AllKeydin', 'ActiveKeydin',
            'InactiveKeydin', 'NewThisWeek', 'entries', 'Item', 'fadhiyada'
,'shaqsiyadka' 
        ));
    }

public function siiHubShaqsi(Request $request)
{
    // 1. Validation: Ku dar FadhiId oo loo baahan yahay
    $request->validate([
        'keydin_id' => 'required|exists:tbl_keydin,keydin_ID',
        'ShaqsiId'  => 'required',
        'FadhiId'   => 'required', // Waxaan ku darnay in fadhiga la doorto
        'date'      => 'required|date',
    ]);

    // 2. Update Keydin (Status-ka u bixi Shaqsi = 2)
    // Waxaan sidoo kale update ku sameyneynaa Fadhiga guud ee hubka ku jiro (FadhiId)
    $keydin = Keydin::find($request->keydin_id);
    $keydin->update([
        'keydin_Xalada' => 2,
        'FadhiId'       => $request->FadhiId // Hubka fadhigiisa halkan ku update garee
    ]);

    // 3. Xir shaqadii hore ee Bakhaarka (Store Assignment)
    // Note: Hubi in status-ka firfircoon uu yahay 0 ama 1 (sida nidaamkaaga qabo)
    \App\Models\AssignHubToStore::where('ashtst_keID', $keydin->keydin_ID)
        ->where('ashtst_Status', 0) 
        ->update([
            'ashtst_Status'     => 1, // 1 = Finished/Closed
            'ashtst_FinishDate' => $request->date
        ]);

    // 4. Create New Shaqsi Assignment
    // Waxaan ku darnay 'FadhiId' si loo ogaado shaqsiga fadhiga uu joogo marka hubka la siinayay
    \App\Models\AssignShaqsi::create([
        'shaqiid'     => $request->ShaqsiId,
        'FadhiId'     => $request->FadhiId, // Fadhiga shaqsiga
        'ItemId'      => $keydin->keydin_itemID,
        'QoriNumber'  => $keydin->keydin_lambarka1,
        'CreateDate'  => $request->date,
        'Status'      => 0, // 0 = Active (Gacanta ayuu ugu jiraa)
        'keydin_ID'   => $keydin->keydin_ID,
    ]);

    // Haddii aad AJAX isticmaaleyso (Professional way):
    if ($request->ajax()) {
        return response()->json([
            'status'  => 'success',
            'message' => 'Hubka si guul leh ayaa loogu wareejiyay Shaqsiga fadhigiisuna waa la diiwangeliyay.'
        ]);
    }

    return redirect()->back()->with('success', 'Hubka si guul leh ayaa loogu wareejiyay Shaqsiga.');
}

public function siiHubAskari(Request $request)
{
    $request->validate([
        'keydin_id' => 'required|exists:tbl_keydin,keydin_ID',
        'AskariId' => 'required',
        'date' => 'required|date',
    ]);

    // 1. Update Keydin (Status-ka u bixi Askari/Baxay)
    $keydin = Keydin::find($request->keydin_id);
    $keydin->update(['keydin_Xalada' => 1]);

    // 2. Finish current store assignment
    \App\Models\AssignHubToStore::where('ashtst_keID', $keydin->keydin_ID)
        ->where('ashtst_Status', 0)
        ->update([
            'ashtst_Status' => 1,
            'ashtst_FinishDate' => $request->date
        ]);

    // 3. Create New Askari Assignment (Model-kaaga Assignhub)
    \App\Models\Assignhub::create([
        'AskariId' => $request->AskariId,
        'ItemId' => $keydin->keydin_itemID,
        'QoriNumber' => $keydin->keydin_lambarka1,
        'CreateDate' => $request->date,
        'Status' => 0,
        'keydin_ID' => $keydin->keydin_ID,
    ]);

    return redirect()->back()->with('success', 'Hubka si guul leh ayaa loogu wareejiyay Askariga.');
}

    public function keydin()
    {
        $pageTitle = "Keydin";
        $subTitle = "Liiska Keydinta";

        $keydins = Keydin::with(['FadhiIdRelation', 'QaybtaHubkaRelation'])
            ->latest('keydin_ID')
            ->paginate(10);

        $AllKeydin = Keydin::count();
        $ActiveKeydin = Keydin::where('keydin_Xalada', 1)->count();
        $InactiveKeydin = Keydin::where('keydin_Xalada', 0)->count();
        $shaqsiyadka = Keydin::where('keydin_Xalada', 2)->count();
        $NewThisWeek = Keydin::whereBetween('keydin_CreateDate', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        $fadhiyada = Department::all();
        $Item = Item::where('WaaxId', 2)->orderBy('ItemName')->get();
        $entries = $keydins->total();
        
        return view('pages.keydin.list', compact(
            'keydins', 'pageTitle', 'subTitle', 'AllKeydin', 'ActiveKeydin',
            'InactiveKeydin', 'NewThisWeek', 'entries', 'fadhiyada', 'Item'
,'shaqsiyadka'        ));
    }

    public function create()
    {
        $items = Item::where('WaaxId', 2)->orderBy('ItemName')->get();
        $Department = Department::all();
        return view('pages.keydin.create', compact('items','Department'));
    }

public function store(Request $request)
{
    // Security Check
    // if (auth()->user()->role_id != 1) {
    //     return redirect()->back()->with('error', 'Action not allowed for your role.');
    // }

    $validated = $request->validate([
        'Xaalada1' => 'required|in:0,1,2',
        'Xaalada2' => 'required|in:1,2,3,4,5,6',
        'date' => 'required|date',
        'FadhiId' => 'required|integer|exists:departments,id',
        'QaybtaHubka' => 'required|integer|exists:item,ItemId',
        'sawiradaHubka' => 'nullable|array|max:12',
        'sawiradaHubka.*' => 'image|max:2048',
        'LambarkaTaxanaha' => 'required|string|max:255',
        'Calamaden' => 'required|string|max:255',
        'ShaqeynKara' => 'required|in:1,2',
        'Lahansho' => 'required|in:Dawlada,Shaqsi,Qabiil',
        'faahfaahintaHubka' => 'nullable|string',
        
        // Validation-ka cusub ee Store-ka (Haddii Xaalada1=0)
        'store_id' => [
            'nullable', 'integer', 'exists:storada,StoradaId',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->input('Xaalada1') == 0 && !$value) {
                    $fail('Fadlan dooro Bakhaarka (Store).');
                }
            },
        ],

        'ShaqsiId' => [
            'nullable', 'integer', 'exists:shaqsiyadka,ShaqsiyaadkaId',
            function ($attribute, $value, $fail) use ($request) {
                if ($request->input('Xaalada1') == 2 && !$value) {
                    $fail('Fadlan dooro Shaqsi.');
                }
            },
        ],
    ]);

    // Maareynta Sawirada
    $imagePaths = [];
    if ($request->hasFile('sawiradaHubka')) {
        foreach ($request->file('sawiradaHubka') as $image) {
            $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/keydin_images', $imageName);
            $imagePaths[] = $imageName;
        }
    }

    // 1. Create Keydin (Had iyo jeer waa la abuurayaa)
    $keydin = Keydin::create([
        'keydin_Xalada' => $validated['Xaalada1'],
        'Xalada' => $validated['Xaalada2'],
        'keydin_CreateDate' => $validated['date'],
        'FadhiId' => $validated['FadhiId'],
        'StoradaId' => $validated['store_id'] ?? null, // Ku dar store_id haddii uu jiro
        'keydin_itemID' => $validated['QaybtaHubka'],
        'keydin_image1' => count($imagePaths) ? json_encode($imagePaths) : null,
        'keydin_lambarka1' => $validated['LambarkaTaxanaha'],
        'Calamaden' => $validated['Calamaden'],
        'ShaqeynKara' => $validated['ShaqeynKara'],
        'Lahansho' => $validated['Lahansho'],
        'Describ' => $validated['faahfaahintaHubka'],
        'UserId' => auth()->id(), // Had iyo jeer xusuusnoow qofka save-gareeyay
    ]);

    if ($validated['Xaalada1'] == 0) {
    \App\Models\AssignHubToStore::create([
        'ashtst_keID'      => $keydin->keydin_ID,        // ID-ga hubka ee hadda la save-gareeyay
        'StoreID'          => $validated['store_id'],    // Bakhaarka la doortay
        'QoriNum'          => $validated['LambarkaTaxanaha'],
        'CreateDate'       => now(),
        'ashtst_Status'    => 0,                         // 1 = Active/In Store
        'ashtst_FinishDate' => null,
    ]);
}

    // 2. INSERT ONLY WHEN XALADA IS 2 (Shaqsi)
    if ($validated['Xaalada1'] == 2) {
        AssignShaqsi::create([
            'shaqiid' => $validated['ShaqsiId'],
            'ItemId' => $validated['QaybtaHubka'],
            'QoriNumber' => $validated['LambarkaTaxanaha'],
            'CreateDate' => now(),
            'UpdateDate' => now(),
            'FinishDate' => null,
            'Status' => 0,
            'keydin_ID' => $keydin->keydin_ID,
            'descrip' => $validated['faahfaahintaHubka'],
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Xogta si guul leh ayaa loo keydiyay'
    ]);
}

    public function removeImage(Request $request)
    {
        $imageName = $request->image_name;
        $keydin = Keydin::whereRaw("FIND_IN_SET(?, images)", [$imageName])->first();

        if ($keydin) {
            $images = explode(',', $keydin->images);
            if (($key = array_search($imageName, $images)) !== false) {
                unset($images[$key]);
                $keydin->images = implode(',', $images);
                $keydin->save();

                if (file_exists(public_path('images/keydin/'.$imageName))) {
                    unlink(public_path('images/keydin/'.$imageName));
                }
                return response()->json(['success'=>true]);
            }
        }
        return response()->json(['success'=>false], 404);
    }
    
    public function update(Request $request, $id)
    {
        if (auth()->user()->role_id != 1) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $keydin = Keydin::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'Xaalada1' => 'required|in:0,1',
            'Xaalada2' => 'required|in:1,2,3,4,5,6',
            'date' => 'required|date',
            'FadhiId' => 'required|integer',
            'QaybtaHubka' => 'required|integer',
            'LambarkaTaxanaha' => 'required|string|unique:tbl_keydin,keydin_lambarka1,'.$id.',keydin_ID,keydin_itemID,'.$request->QaybtaHubka,
            'Calamaden' => 'required|string',
            'ShaqeynKara' => 'required|in:1,2',
            'Lahansho' => 'required|in:Dawlada,Shaqsi,Qabiil',
            'faahfaahintaHubka' => 'required|string',
            'sawiradaHubka.*' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        $keydin->keydin_Xalada = $request->Xaalada1;
        $keydin->Xalada = $request->Xaalada2;
        $keydin->keydin_CreateDate = $request->date;
        $keydin->FadhiId = $request->FadhiId;
        $keydin->keydin_itemID = $request->QaybtaHubka;
        $keydin->keydin_lambarka1 = $request->LambarkaTaxanaha;
        $keydin->Calamaden = $request->Calamaden;
        $keydin->Lahansho = $request->Lahansho;
        $keydin->Describ = $request->faahfaahintaHubka;

        if($request->hasFile('sawiradaHubka')){
            $existingImages = $keydin->images ? explode(',', $keydin->images) : [];
            foreach($request->file('sawiradaHubka') as $file){
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('images/keydin/'), $filename);
                $existingImages[] = $filename;
            }
            $keydin->keydin_image1 = implode(',', $existingImages);
        }

        $keydin->save();
        return response()->json(['message'=>'Record updated successfully!']);
    }

    public function edit($id)
    {
        $keydin = Keydin::findOrFail($id);
        $Department = Department::all();
        $items = Item::all();
        return view('pages.keydin.edit', compact('keydin','Department','items'));
    }

    public function searchShaqsi(Request $request)
    {
        try {
            $search = $request->input('search');
            if (empty($search) || strlen($search) < 1) {
                return response()->json(['success' => true, 'data' => []]);
            }
            $results = Shaqsiyaadka::where(function ($query) use ($search) {
                    $query->where('magacaShaqsiga', 'LIKE', "%{$search}%")
                          ->orWhere('TalefanLambarka', 'LIKE', "%{$search}%");
                })
                ->select('ShaqsiyaadkaId', 'magacaShaqsiga', 'TalefanLambarka')
                ->orderBy('magacaShaqsiga')
                ->limit(50)
                ->get();

            return response()->json(['success' => true, 'data' => $results]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $data = Keydin::where('keydin_lambarka1', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->select('id', 'keydin_lambarka1 as text')
            ->limit(10)
            ->get();
        return response()->json($data);
    }

    public function Details($id)
    {
        $keydin = Keydin::with(['FadhiIdRelation', 'QaybtaHubkaRelation'])->findOrFail($id);
        return response()->json($keydin);
    }

    public function show($id)
    {
        $Department = Department::all();
        $keydin = Keydin::with(['FadhiIdRelation', 'QaybtaHubkaRelation'])->findOrFail($id);
        $isInactive = ($keydin->keydin_Xalada == 0);

        if($keydin->keydin_Xalada == 0){
            $lastRecord = AssignHubToStore::with(['store'])
                ->where('ashtst_keID', $id)
                ->where('ashtst_Status', 0)
                ->latest('ashtst_ID')
                ->first();
        } elseif($keydin->keydin_Xalada == 1){
            $lastRecord = Assignhub::with(['askari', 'item'])
                ->where('keydin_ID', $id)
                ->where('Status', 0)
                ->latest('assignhubId')
                ->first();
        } elseif($keydin->keydin_Xalada == 2){
            $lastRecord = AssignShaqsi::with(['shaqsi', 'item'])
                ->where('keydin_ID', $id)
                ->where('Status', 0)
                ->latest('id')
                ->first();
        } else {
            $lastRecord = null;
        }

        return view('pages.keydin.details', compact('keydin', 'isInactive', 'lastRecord','Department'));
    }

  public function destroy($id)
{
    if (auth()->user()->role_id != 1) {
        return redirect()->back()->with('fail', 'Uma lihid ogolaansho inaad wax tirtirto.');
    }
    
    $keydin = Keydin::findOrFail($id);
    $keydin->delete();
    
    return redirect()->route('keydin.list')->with('success', 'Xogta si guul leh ayaa loo tirtiray.');
}

public function getStoresByDepartment(Request $request)
{
 
    // Waxaan soo saaraynaa storada leh FadhiId-ka la doortay
    $stores = \App\Models\Store::where('FadhiId', $request->department_id)
                                ->where('Status', 0) // Haddii status 1 uu yahay midka furan
                                ->get();
                                
    return response()->json($stores);
}

    public function checkSerial(Request $request)
    {
        $exists = \App\Models\Keydin::where('keydin_itemID', $request->QaybtaHubka)
                    ->where('keydin_lambarka1', $request->LambarkaTaxanaha)
                    ->exists();
        return response()->json(['exists' => $exists]);
    }
}