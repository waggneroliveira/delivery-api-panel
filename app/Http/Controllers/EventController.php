<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;

class EventController extends Controller
{

    public function index()
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('agenda.visualizar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $events = Event::sorting()->get();

        return view('admin.blades.event.index', compact('events'));
    }

   public function create(){
        return view('admin.blades.event.create'); 
   }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
                event::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->route('admin.dashboard.event.index');
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function storeTheBlog(Request $request)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);

        try {
            DB::beginTransaction();
                event::create($data);
            DB::commit();
            session()->flash('success', __('dashboard.response_item_create'));
            return redirect()->route('admin.dashboard.blog.index');
        } catch (\Exception $e) {
            DB::rollback();            
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }

    public function edit(Event $event){

        return view('admin.blades.event.edit', compact('event'));
    }
    public function update(Request $request, Event $event)
    {
        $data = $request->all();
        $data['active'] = $request->active?1:0;
        $data['slug'] = Str::slug($request->title);
        try {
            DB::beginTransaction();
                $event->fill($data)->save();
            DB::commit();
            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->route('admin.dashboard.event.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $eventId) {
            $event = Event::find($eventId);
    
            if ($event) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($event)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $eventId,
                            'title' => $event->title,
                            'description' => $event->description,
                            'hours' => $event->hours,
                            'slug' => $event->slug,
                            'date' => $event->date,
                            'link' => $event->link,
                            'sorting' => $event->sorting,
                            'active' => $event->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $eventId não encontrado.");
            }
        }
    
        $deleted = Event::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $event = Event::find($id);
    
            if ($event) {
                $event->sorting = $sorting;
                $event->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($event) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($event)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $event->title,
                            'description' => $event->description,
                            'hours' => $event->hours,
                            'slug' => $event->slug,
                            'date' => $event->date,
                            'link' => $event->link,
                            'sorting' => $event->sorting,
                            'active' => $event->active,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                \Log::warning("Item com ID $id não encontrado.");
            }
        }
    
        return Response::json(['status' => 'success']);
    }
}
