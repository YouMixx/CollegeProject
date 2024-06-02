<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Student;
use App\Services\GenerateDocumentService;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use MoonShine\MoonShineUI;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GenerateDocumentController extends Controller
{
    public $generateDocumentService;

    public function __construct(GenerateDocumentService $generateDocumentService)
    {
        $this->generateDocumentService = $generateDocumentService;
    }

    public function generateCertificate(Student $student)
    {
        try {
            $this->generateDocumentService->generateCertificate($student);
            MoonShineUI::toast('Сертификат успешно сформирован!', 'success');
        } catch (\Throwable $th) {
            MoonShineUI::toast('Произошла ошибка при формировании сертификата!', 'error');
        }

        return back();
    }

    public function viewCertificate(Student $student): BinaryFileResponse
    {
        $file = $this->generateDocumentService->generateCertificate($student);
        return response()->file('storage/' . $file);
    }

    public function downloadCertificate(Student $student)
    {
        $file = $this->generateDocumentService->generateCertificate($student);
        return response()->download('storage/' . $file, $student->name . '.pdf');
    }

    public function generateDocumentCompany(Company $company)
    {
        try {
            $this->generateDocumentService->generateDocumentCompany($company);
            MoonShineUI::toast('Договор успешно сформирован!', 'success');
        } catch (\Throwable $th) {
            MoonShineUI::toast('Произошла ошибка при формировании Договор!', 'error');
        }

        return back();
    }

    public function viewDocumentCompany(Company $company) : BinaryFileResponse
    {
        $file = $this->generateDocumentService->generateDocumentCompany($company);
        return response()->file('storage/' . $file);
    }
}
