<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Student;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\RegistrationConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    public $applicationData;
    public $studentData;
    public $files;


    /**
     * Create a new job instance.
     */
    public function __construct($userData, $applicationData, $studentData, $files)
    {
        $this->userData = $userData;
        $this->applicationData = $applicationData;
        $this->studentData = $studentData;
        $this->files = $files;
        // dd($this->userData);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Retrieve and store files from the provided paths
        $documentMedicalReportPath = $this->retrieveAndStoreFile($this->files['document_medical_report'], 'public/documents');
        $documentBirthCertificatePath = $this->retrieveAndStoreFile($this->files['document_birth_certificate'], 'public/documents');
        $documentLocalGovIdPath = $this->retrieveAndStoreFile($this->files['document_local_government_identification'], 'public/documents');
        $documentSecondarySchoolCertPath = $this->retrieveAndStoreFile($this->files['document_secondary_school_certificate_type'], 'public/documents');
        $passportPhotoPath = $this->retrieveAndStoreFile($this->files['passport_photo'], 'public/photos');

    }


    private function storeFile($file, $path)
    {
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs($path, $fileName);
            return $path . '/' . $fileName;
        }

        return null;
    }



    private function generateUniqueNumber()
    {
        $lastRegisteredPerson = Student::max('id') + 1;
        return 'SHN' . mt_rand(1000000, 9999999) . $lastRegisteredPerson;
    }

    private function retrieveAndStoreFile($filePath, $path)
    {
        if ($filePath) {
            $fileName = time() . '_' . pathinfo($filePath, PATHINFO_BASENAME);
            Storage::disk('public')->copy($filePath, $path . '/' . $fileName);
            return $path . '/' . $fileName;
        }
        return null;
    }
}
