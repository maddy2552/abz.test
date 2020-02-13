<?php

namespace App\Observers;

use App\Position;
use Illuminate\Support\Facades\Auth;

class PositionObserver
{
    /**
     * Handle the position "created" event.
     *
     * @param  Position  $position
     * @return void
     */
    public function created(Position $position)
    {

    }

    /**
     * Handle the position "creating" event.
     *
     * @param  Position  $position
     * @return void
     */
    public function creating(Position $position)
    {
        $position->admin_created_id = Auth::user()->id;
        $position->admin_updated_id = Auth::user()->id;
    }

    /**
     * Handle the position "updated" event.
     *
     * @param  \App\Position  $position
     * @return void
     */
    public function updated(Position $position)
    {
        //
    }

    /**
     * Handle the position "updating" event.
     *
     * @param  Position  $position
     * @return void
     */
    public function updating(Position $position)
    {
        $position->admin_updated_id = Auth::user()->id;
    }

    /**
     * Handle the position "deleted" event.
     *
     * @param  \App\Position  $position
     * @return void
     */
    public function deleted(Position $position)
    {
        //
    }

    /**
     * Handle the position "restored" event.
     *
     * @param  \App\Position  $position
     * @return void
     */
    public function restored(Position $position)
    {
        //
    }

    /**
     * Handle the position "force deleted" event.
     *
     * @param  \App\Position  $position
     * @return void
     */
    public function forceDeleted(Position $position)
    {
        //
    }
}
