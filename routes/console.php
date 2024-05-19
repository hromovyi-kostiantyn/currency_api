<?php


use Illuminate\Support\Facades\Schedule;

Schedule::command('app:notify-all-emails')->daily();
