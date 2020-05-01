<?php

namespace App\Listeners\Project;

use App\Models\Project;
use Illuminate\Support\Str;
use App\Events\Project\ProjectSavingEvent;

/**
 * Class ProjectSaving
 *
 * @package App\Listeners
 */
class ProjectSavingListener
{
    /**
     * Handle the event.
     *
     * @param ProjectSavingEvent $event
     * @return void
     */
    public function handle(ProjectSavingEvent $event)
    {
        if (empty($event->project->title)) {
            $event->project->code = Str::of(Str::random(4))->upper();
            return;
        }

        $parts = [];
        $title = trim($event->project->title);
        if (Str::contains($title, " ")) {
            $words = explode(" ", $title);
            $parts[] = $words[0][0];
            $parts[] = $words[1][0];
            empty($words[2]) ?: $parts[] = $words[2][0];
        } else {
            $parts[] = $title[0];
            $parts[] = $title[1];
        }

        $suffix = !empty($parts[2]) ? $parts[2] : "";
        $code = Str::of($parts[0] . $parts[1] . $suffix)->trim()->upper();
        if ($event->project->code == $code) {
            return;
        }

        $index = 1;
        while ($found = Project::where('code', $code)->exists()) {
            $code .= $index;
            $index++;
            if ($index > 100) {
                $code = Str::of(Str::random(4))->upper();
                break;
            }
        }

        $event->project->code = $code;
    }
}
