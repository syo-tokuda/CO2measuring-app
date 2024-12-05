<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MeasuringController extends Controller
{
    public function index()
    {
        $date = date('Y-m-d', strtotime('today'));
        $datecount = 0;
        $timewidth = "day";
        $fromtime = 0;
        $totime = 24;
        $pythonPath =  "../app/Python/";
        $command = "python " . $pythonPath . "data_count.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $labels);
        $command = "python " . $pythonPath . "temperature.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $temperature);
        $command = "python " . $pythonPath . "humidity.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $humidity);
        $command = "python " . $pythonPath . "height.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $height);
        $command = "python " . $pythonPath . "CO2_lifting.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_lifting);
        $command = "python " . $pythonPath . "CO2_bottom.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_bottom);
        $command = "python " . $pythonPath . "CO2_top.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_top);
        $command = "python " . $pythonPath . "CdS.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CdS);
        
        return view('view', compact('labels', 'temperature', 'humidity', 'height', 'CO2_lifting', 'CO2_bottom', 'CO2_top', 'CdS', 'datecount', 'date', 'timewidth', 'fromtime', 'totime'));
    }

    public function store(Request $request)
    {
        $datecount = $request->datecount;
        $timewidth = $request->timewidth;
        $fromtime = $request->fromtime;
        $totime = $request->totime;
        if ($request->has('oneday_before')) {
            $datecount -= 1;
        } else if ($request->has('oneday_after')){
            $datecount += 1;
        } else if ($request->has('oneweek_before')){
            $datecount -= 7;
        } else if ($request->has('oneweek_after')){
            $datecount += 7;
        } else if ($request->has('onemonth_before')){
            $datecount -= 30;
        } else if ($request->has('onemonth_after')){
            $datecount += 30;
        } else if ($request->has('day')){
            $timewidth = "day";
            $fromtime = 0;
            $totime = 24;
        } else if ($request->has('hour')){
            $timewidth = "hour";
            $fromtime = 0;
            $totime = 24;
        } else if ($request->has('update')){
            if ($timewidth=="day"){
                $fromtime = 0;
                $totime = $_POST['totime'];
                if ($totime!=null) 
                    $totime *= 24;
            }
            else {
                $fromtime = $_POST['fromtime'];
                $totime = $_POST['totime'];
            }
            if ($fromtime==null) 
                $fromtime = 0;
            if ($totime==null) 
                $totime = 0;
        }
        $pythonPath =  "../app/Python/";
        $command = "python " . $pythonPath . "data_count.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $labels);
        $command = "python " . $pythonPath . "temperature.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $temperature);
        $command = "python " . $pythonPath . "humidity.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $humidity);
        $command = "python " . $pythonPath . "height.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $height);
        $command = "python " . $pythonPath . "CO2_lifting.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_lifting);
        $command = "python " . $pythonPath . "CO2_bottom.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_bottom);
        $command = "python " . $pythonPath . "CO2_top.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CO2_top);
        $command = "python " . $pythonPath . "CdS.py " . $datecount . " " . $fromtime . " " . $totime;
        exec($command , $CdS);
        $date_plusday = $datecount . " day";
        $date = date('Y-m-d', strtotime($date_plusday));
        
        return view('view', compact('labels', 'temperature', 'humidity', 'height', 'CO2_lifting', 'CO2_bottom', 'CO2_top', 'CdS', 'datecount', 'date', 'timewidth', 'fromtime', 'totime'));
    }
}
