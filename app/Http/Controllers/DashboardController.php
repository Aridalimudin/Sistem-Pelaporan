<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\ReporterCrime;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReporter = Reporter::get()->count();
        $totalRejectedReporter = Reporter::where('status', 4)->get()->count();
        $totalDoneReporter = Reporter::where('status', 3)->get()->count();
        $totalStudent = Student::get()->count();
        $totalNotAccepted = Reporter::where('status', 0)->get()->count();
        $totalWaiting = Reporter::where('status', 1)->get()->count();
        $totalNotDone = Reporter::whereIn('status', [0,1,2])->get()->count();
        $reporterLatest = Reporter::where('status', 0)->orderByDesc('created_at')->limit(3)->get();
        
        $totalCrimesReported = ReporterCrime::count();
        $categoryCounts = DB::table('reporter_crimes')
        ->join('crimes', 'reporter_crimes.crime_id', '=', 'crimes.id')
        ->select('crimes.type', DB::raw('COUNT(reporter_crimes.id) as count'))
        ->groupBy('crimes.type')
        ->get();

        $categoriesData = [];
        $colorMap = [
            'Bullying Verbal' => 'bullying-verbal',
            'Bullying Fisik' => 'bullying-physical',
            'Pelecehan Verbal' => 'harassment-verbal',
            'Pelecehan Fisik' => 'harassment-physical',
        ];

        if(!empty($categoryCounts)){
            foreach ($categoryCounts as $category) {
                $percentage = ($totalCrimesReported > 0) ? round(($category->count / $totalCrimesReported) * 100) : 0;
    
                $categoriesData[] = [
                    'name' => $category->type,
                    'count' => $category->count,
                    'percentage' => $percentage,
                    'color_class' => $colorMap[$category->type] ?? 'default-color', // Assign color class
                ];
            }
        }

         $urgencyCounts = Reporter::select('urgency', DB::raw('COUNT(*) as count'))
                               ->groupBy('urgency')
                               ->get();

        $urgenciesData = [];
        $urgencyMap = [
            1 => ['name' => 'Rendah', 'color_class' => 'low'],
            2 => ['name' => 'Sedang', 'color_class' => 'medium'],
            3 => ['name' => 'Berat', 'color_class' => 'high'],
            
        ];

        foreach ($urgencyCounts as $urgency) {
            $percentage = ($totalReporter > 0) ? round(($urgency->count / $totalReporter) * 100) : 0;

            // Get the name and color class from the map, with a fallback
            $urgencyInfo = $urgencyMap[$urgency->urgency] ?? ['name' => 'Tidak Dikenal', 'color_class' => 'urgency-unknown'];

            $urgenciesData[] = [
                'name' => $urgencyInfo['name'],
                'count' => $urgency->count,
                'percentage' => $percentage,
                'color_class' => $urgencyInfo['color_class'],
            ];
        }
        usort($urgenciesData, function($a, $b) {
            $order = ['Berat' => 1, 'Sedang' => 2, 'Rendah' => 3, 'Tidak Dikenal' => 4];
            return $order[$a['name']] <=> $order[$b['name']];
        });

        return view('dashboard_Admin.dashboardadmin', compact('totalReporter','totalRejectedReporter','totalDoneReporter','totalStudent','totalNotAccepted','totalWaiting','totalNotDone','reporterLatest','categoriesData','urgenciesData'));
    }
}
