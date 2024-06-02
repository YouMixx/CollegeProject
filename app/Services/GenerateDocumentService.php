<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class GenerateDocumentService
{
    private $folderCertificate = "documents/certificates";
    private $folderDocument = "documents/companies";

    public function generateCertificate(Student $student): string
    {
        $filePath = $this->folderCertificate . "/{$student->id}.pdf";

        if (Storage::disk('public')->exists($filePath)) {
            return $filePath;
        }

        $pdf = Pdf::setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed' => TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        )->loadView("certificate", [
            'student' => $student,
            'group' => $student->group,
            'course' => $student->group->course,
        ]);

        // Сохраняем КП
        Storage::disk('public')->makeDirectory($this->folderCertificate);
        $pdf->save("storage/" . $filePath);

        return $filePath;
    }

    public function generateDocumentCompany(Company $company): string
    {
        $date = Carbon::now();
        $day = $date->day;
        $monthYear = $date->monthName . " " . $date->year;

        $templatePath = Storage::disk('public')->path('documentCompany.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        $templateProcessor->setValue('НомерДоговора', time() / 1000);
        $templateProcessor->setValue('Число', $day);
        $templateProcessor->setValue('МесяцГод', $monthYear);
        $templateProcessor->setValue('Директор', $company->director);
        $templateProcessor->setValue('Компания', $company->name);
        $templateProcessor->setValue('ИНН', $company->inn);
        $templateProcessor->setValue('КПП', $company->kpp);
        $templateProcessor->setValue('ОГРН', $company->orgn);
        $templateProcessor->setValue('Телефон', $company->phone);
        $templateProcessor->setValue('Email', $company->email);

        // Сохраняем договор
        Storage::disk('public')->makeDirectory($this->folderDocument);
        $filePath = $this->folderDocument . "/{$company->id}.docx";
        $templateProcessor->saveAs("storage/" . $filePath);

        return $this->folderDocument . "/{$company->id}.docx";
    }
}
