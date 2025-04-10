<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedecinController extends Controller
{
    // app/Http/Controllers/MedecinController.php
public function patients()
{
    // الحصول على الطبيب المعتمد مع المرضى المشتركين
    $medecin = auth()->user()->medecin;
    
    // الحصول على المرضى النشطين مع التقسيم إلى صفحات
    $patients = $medecin->patients()
                ->wherePivot('is_active', true)
                ->with('user') // تحميل بيانات المستخدم مسبقًا
                ->paginate(10);
    
    return view('medecin.patients.index', compact('patients'));
}
}
