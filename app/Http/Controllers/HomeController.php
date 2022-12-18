<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Connection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'sentRequests' => auth()->user()->connections()->whereStatus('pending')->count(),
            'receivedRequests' => User::whereHas('connections', function ($query) {
                $query->whereStatus('pending')->where('connection_id', auth()->user()->id);
            })->count(),
            'suggestedRequests' => $this->getSuggestionQuery()->count(),
            'connections' => auth()->user()->connections()->whereStatus('accepted')->count(),
        ]);
    }

    public function suggestions()
    {
       $connections = $this->getSuggestionQuery()->paginate(request()->limit);
        
        return [
            'view' => Blade::render('<x-suggestion :users="$users"/>', ['users' => $connections]),
            'total' => $connections->total(),
        ];
    }

    public function connections()
    {
        $connections = auth()->user()->connections()->whereStatus('accepted')->paginate(request()->limit);
        return [
            'view' => Blade::render('<x-connection :users="$users"/>', ['users' => $connections]),
            'total' => $connections->total()
        ];
    }
    public function connectionsInCommon()
    {
        try{
            $connections = auth()->user()->connections()->where('status', 'accepted')->pluck('users.id');
            $connectionsInCommon = User::findOrFail(request()->connection_id)->connections()
            ->whereStatus('accepted')
            ->where('connection_id', '!=', auth()->user()->id)
            ->whereIn('user_id', $connections)->paginate(request()->limit);
            return [
                'view' => Blade::render('<x-connection_in_common :users="$users"/>', ['users' => $connectionsInCommon]),
                'total' => $connectionsInCommon->total()
            ];
        } catch(ModelNotFoundException $e){
            dd($e);
        } catch(Exception $e){

        }
        
    }
    public function request()
    {
        $connections = collect();
        switch(request()->mode){
            case 'sent':
                $connections = auth()->user()->connections()->whereStatus('pending')->latest()->paginate(request()->limit);
                break;
            case 'received':
                $connections = User::whereHas('connections', function ($query) {
                    $query->whereStatus('pending')->where('connection_id', auth()->user()->id);
                })->latest()->paginate(request()->limit);
                break;
        }

        return [
            'view' => Blade::render('<x-request mode="' . request()->mode .'" :users="$users"/>', ['users' => $connections]),
            'total' => $connections->total()
        ];
    }

    public function sendRequest(Request $request)
    {
        auth()->user()->connections()->attach($request->connection_id);
    }
    public function declineRequest(Request $request)
    {
        auth()->user()->connections()->detach($request->connection_id);
    }
    public function acceptRequest(Request $request)
    {
        try{
            DB::beginTransaction();
            Connection::
            where('connection_id', auth()->user()->id)
            ->where('user_id', $request->connection_id)
            ->update([ 'status' => 'accepted']);
    
            Connection::create([
                'connection_id' => $request->connection_id,
                'user_id' => auth()->user()->id,
                'status' => 'accepted'
            ]);
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            
        }
    }

    public function removeConnection(Request $request)
    {
        auth()->user()->connections()->detach($request->connection_id);
        auth()->user()->receivedConnections()->detach($request->connection_id);
    }

    public function getSuggestionQuery()
    {
        return User::withCount([
            'connections' => function ($query) {
                $query->where('connection_id', auth()->user()->id);
            }
        ])->withCount([
                'receivedConnections' => function ($query) {
                    $query->where('user_id', auth()->user()->id);
                }
            ])
            ->having('connections_count', 0)
            ->having('received_connections_count', 0)
            ->where('id', '!=', auth()->user()->id);
    }
}
