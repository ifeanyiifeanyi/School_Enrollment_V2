<?php

use App\Http\Controllers\Admin\AcademicSessionController;
use App\Http\Controllers\Admin\AcceptanceFeeManagerController;
use App\Http\Controllers\Student\BarcodeViewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\FacultyController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\AdminProfileController;
use League\CommonMark\Extension\SmartPunct\DashParser;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExamManagerController;
use App\Http\Controllers\Admin\ExamNotificationController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ManageRolePermissionController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ScholarshipController;
use App\Http\Controllers\Admin\ScholarshipQuestionController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\StudentScholarshipApplicationController;
use App\Http\Controllers\Installer\InstallerController;
use App\Http\Controllers\Student\ApplicationProcessController;
use App\Http\Controllers\Student\ScholarshipApplicationController;
use App\Http\Controllers\Student\StudentAcceptanceFeeController;
use App\Http\Controllers\Student\StudentAdmissionApplicationController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Models\AdmissionAcceptanceManager;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/run-migrations', function () {
//     Artisan::call('optimize:clear');
//     Artisan::call('migrate:fresh');

//     return "migration was successful";
// });


Route::middleware(['cors'])->group(function () {

    Route::get('/', function () {
        return view('auth.login');
    });

    // acceptance fee payment


    //barcode student route
    Route::controller(BarcodeViewController::class)->group(function () {
        Route::get('student/details/{nameSlug}', 'showDetails')->name('student.details.show');
        Route::get('acceptance/{transactionId}', 'receiptDetail')
            ->name('student.acceptancefee.verify')
            ->middleware('public.receipt.view');
    });

    // confirm student application registration mail route
    Route::get('/payment', function () {
        return view('student.application.index');
    })->name('payment.view')->middleware('');

    Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');






    // Admin Routes
    Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {

        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('dashboard', 'index')->name('admin.dashboard');
            Route::get('logout', 'logout')->name('admin.logout');

            Route::middleware(['permission:manage-site-settings'])->group(function () {
                Route::get('site-settings', 'siteSettings')->name('site.settings');
                Route::post('site-settings/store', 'siteSettingStore')->name('site.setting.store');
                Route::post('email-setup', 'emailSetup')->name('admin.email.setup');
                Route::post('flutterwave/setup', 'storeFlutterwaveSettings')->name('admin.flutterwave.setup');
                Route::post('paystack/setup', 'storePaystackSettings')->name('admin.paystack.setup');

                Route::post('send-mail', 'sendMail')->name('admin.send.mail');
            });
        });

        Route::middleware(['permission:manage-site-settings'])->group(function () {
            Route::controller(ExamNotificationController::class)->group(function () {
                Route::get('exam-notifications', 'index')->name('admin.exam.notification');
                Route::post('exam-notifications/store', 'store')->name('admin.exam.notificationStore');
                Route::get('notifications-sent', 'listNotifications')->name('admin.listNotifications');
                Route::get('notifications-replies', 'repliedNotifications')->name('admin.repliedNotifications');
                Route::get('exam-notification/{id}', 'showNotification')->name('admin.showNotification');
                Route::get('exam-notification/{id}/delete', 'destroy')->name('admin.showNotification.destroy');
            });
        });

        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('profile', 'show')->name('admin.profile');
            Route::get('profile/set-password', 'setPassword')->name('admin.profile.setPassword');
            Route::patch('profile/update-password', 'updatePassword')->name('admin.profile.updatePassword');
            Route::post('profile/update', 'update')->name('admin.profile.update');
        });

        Route::middleware(['permission:manage-faculties'])->group(function () {
            Route::controller(FacultyController::class)->group(function () {
                Route::get('faculty-management', 'index')->name('admin.manage.faculty');
                Route::get('create-faculty', 'create')->name('admin.create.faculty');
                Route::post('store-faculty', 'store')->name('admin.store.faculty');
                Route::get('delete-faculty/{slug}', 'destroy')->name('admin.destroy.faculty');
                Route::get('edit-faculty/{slug}', 'edit')->name('admin.edit.faculty');
                Route::get('view-faculty/{slug}', 'show')->name('admin.show.faculty');
                Route::patch('update-faculty/{slug}', 'update')->name('admin.update.faculty');
            });
        });

        Route::middleware(['permission:manage-departments'])->group(function () {
            Route::controller(DepartmentController::class)->group(function () {
                Route::get('department-management', 'index')->name('admin.manage.department');
                Route::get('create-department', 'create')->name('admin.create.department');
                Route::post('store-department', 'store')->name('admin.store.department');
                Route::get('delete-department/{slug}', 'destroy')->name('admin.destroy.department');
                Route::get('edit-department/{slug}', 'edit')->name('admin.edit.department');
                Route::get('view-department/{slug}', 'show')->name('admin.show.department');
                Route::patch('update-department/{slug}', 'update')->name('admin.update.department');
            });
        });

        Route::middleware(['permission:manage-departments', 'permission:manage-faculties'])->group(function () {
            Route::controller(AcademicSessionController::class)->group(function () {
                Route::get('academic-sessions', 'index')->name('admin.academicSession.view');
                Route::get('academic-sessions/create', 'create')->name('admin.academicSession.create');
                Route::post('academic-sessions/store', 'store')->name('admin.academicSession.store');
                Route::get('academic-sessions/{academicSession}', 'edit')->name('admin.academicSession.edit');
                Route::patch('academic-sessions/update/{academicSession}', 'update')->name('admin.academicSession.update');
                Route::get('delete-session/{academicSession}', 'destroy')->name('admin.academicSession.destroy');
                Route::get('/admin/academic-sessions/{academicSession}/applications', 'viewSessionApplications')->name('admin.academicSession.applications');
            });
        });

        Route::middleware(['permission:manage-exams'])->group(function () {
            Route::controller(ExamManagerController::class)->group(function () {
                Route::get('exam-management', 'index')->name('admin.exam.manager');
                Route::post('exam-management/store', 'store')->name("admin.exam.store");
                Route::get('exam-management-details', "examDetails")->name('admin.exam.details');
                Route::get('exam-management-details/{id}', "examInformation")->name('admin.exam.information');
                Route::get('exam-management-details/{id}/edit', "edit")->name('admin.exam.edit');
                Route::patch('exam-management-details/{id}/update', "update")->name('admin.exam.update');
                Route::get('exam-management-details/del/{id}', "destroy")->name('admin.exam.destroy');
                Route::get('exam-subject', 'subjects')->name("admin.subject");
                Route::post('exam-subject/store', 'subjectStore')->name("admin.subject.store");
                Route::get('exam-subject/del/{subject}', 'subjectDel')->name("admin.subject.del");
            });
        });


        Route::middleware(['permission:manage-students'])->group(function () {
            Route::controller(StudentManagementController::class)->group(function () {
                Route::get('student-management', 'index')->name('admin.student.management');
                Route::get('student-applications', 'application')->name('admin.student.application');
                Route::get('student-application-ref', 'applicationRef')->name('admin.student.applicationRef');
                Route::get('student-application-pdf', 'exportPdf')->name('admin.student.applications.exportPDF');
                Route::post('/import-applications', 'import')->name('admin.student.applications.import');
                Route::get('student-applications/export', 'exportApplications')->name('admin.student.applications.export');
                Route::get('view-student/{slug}', 'show')->name('admin.show.student');
                Route::post('/delete-multiple-students', 'deleteMultipleStudents')->name('admin.students.deleteMultiple');
                Route::get('delete-student/{slug}', 'destroy')->name('admin.destroy.student');
                Route::get('edit-student/{slug}', 'edit')->name('admin.edit.student');
                Route::patch('update-student/{slug}', 'update')->name('admin.update.student');

                // export all student data
                Route::get('export-all-students', 'exportAllStudents')->name('admin.export.allStudent');

                //search for student
                Route::get('students/search', 'search')->name('admin.students.search');
                Route::get('applications/search', 'ApplicationSearch')->name('admin.student.applications.search');

                //fetch all unverified student details
                Route::get('unverified-students', 'unverifiedStudents')->name('admin.unverified.student');
                Route::get('verify-student/{slug}', 'verifyStudent')->name('admin.verify.student');

                // this portion is for manually managing application status
                Route::get('pending-approvals', 'pendingApprovals')->name('admin.pending.approvals');
                Route::post('approve-application/{application}',  'approveApplication')->name('admin.approve.application');
                Route::post('reject-application/{application}',  'rejectApplication')->name('admin.reject.application');
                Route::get('search-pending-approvals',  'searchPendingApprovals')->name('admin.search.pending.approvals');

                Route::post('deny-application/{application}/deny', 'denyApplication')->name('admin.deny.application');
                Route::post('applications/bulk-action', 'bulkAction')->name('admin.bulk.action');
                Route::post('applications/{application}/approve', 'approveApplicationSingle')->name('admin.approve.admission');


                Route::get('pending-applications', 'pendingAdmissions')->name('admin.pendingAdmissions.manual');
                Route::post('approve-admission-manual/{application}', 'approveAdmissionManual')->name('admin.approve.manual');
            });

            Route::controller(AcceptanceFeeManagerController::class)->group(function () {
                Route::get('manage-acceptance-fees', 'index')->name('admin.acceptance_fees.index');
                Route::get('/acceptance-fees/{acceptanceFee}', 'show')->name('admin.acceptance_fee.show');

                Route::post('/acceptance-fees/export', 'export')->name('admin.acceptance_fees.export');


                Route::put('/acceptance-fees/{acceptanceFee}/approve', 'approvedManually')->name('admin.acceptance_fee.approved_manually');
                Route::delete('/acceptance-fees/{acceptanceFee}', 'destroy')->name('admin.acceptance_fee.destroy');
            });
        });


        Route::middleware(['permission:manage-payments', 'permission:manage-payment-methods'])->group(function () {
            Route::controller(PaymentMethodController::class)->group(function () {
                Route::get('payment-method-management/{id?}', 'index')->name('admin.payment.manage');
                Route::post('payment-method-manager', 'store')->name('admin.payment.store');
                Route::patch('payment-method-manage/{id}', 'update')->name('admin.payment.update');
                Route::get('payment-method-del/{id}', 'destroy')->name('admin.payment.destroy');

                Route::get('student-application-payment', 'studentApplicationPayment')->name('admin.studentApplication.payment');

                Route::post('/student-application-payment', 'studentApplicationPayment')->name('admin.studentApplicationPayment');
                Route::get('export-payments', 'exportPayments')->name('admin.export.payments');
            });
        });

        Route::middleware(['permission:manage-admins'])->group(function () {
            Route::controller(ManageAdminController::class)->group(function () {
                Route::get('manage-admin', 'index')->name('admin.manage.admin');
                Route::get('manage-admin/create', 'create')->name('admin.manage.create');
                Route::post('manage-admin/store', 'store')->name('admin.manage.store');
                Route::get('manage-admin/edit/{slug}', 'edit')->name('admin.manage.edit');
                Route::patch('manage-admin/update/{slug}', 'update')->name('admin.manage.update');
                Route::get('manage-admin/details/{user:nameSlug}', 'show')->name('admin.manage.show');
                Route::get('delete-user/{user:nameSlug}', 'delete')->name('admin.manage.delete');
            });

            Route::controller(ManageRolePermissionController::class)->group(function () {
                Route::get('assign-role', 'index')->name('admin.assign.role');
                Route::post('assign-role/store', 'store')->name('admin.attach.roleStore');
                Route::get('create-permissions', 'createPermission')->name('admin.create.permission');
                Route::post('create-permissions/store', 'storePermission')->name('admin.permissions.store');
                Route::get('permission', 'viewPermission')->name('admin.permissions.view');
                Route::get('create-roles', 'createRole')->name('admin.create.role');
                Route::post('create-roles/store', 'storeRole')->name('admin.store.role');
                Route::get('roles', 'viewRoles')->name('admin.view.role');
            });
        });

        Route::middleware(['permission:manage-scholarship'])->group(function () {
            Route::controller(ScholarshipController::class)->group(function () {
                Route::get('scholarships', 'index')->name('admin.manage.scholarship');
                Route::get('scholarships/view/{slug}', 'show')->name('admin.view.scholarship');
                Route::post('scholarships/store', 'store')->name('admin.store.scholarship');
                Route::get('scholarships/edit/{slug}', 'edit')->name('admin.edit.scholarship');
                Route::put('scholarships/update/{slug}', 'update')->name('admin.update.scholarship');
                Route::get('scholarships/delete/{slug}', 'destroy')->name('admin.delete.scholarship');
            });

            Route::controller(ScholarshipQuestionController::class)->group(function () {
                Route::get('scholarship-questions', 'index')->name('admin.scholarship.question.view');
                Route::post('scholarship-questions/store', 'store')->name('admin.scholarship.question.store');
                Route::get('scholarship-questions/show', 'show')->name('admin.scholarship.question.show');
                Route::get('edit-scholarship-question/{id}/edit', 'edit')->name('admin.scholarshipQuestion.edit');
                Route::get('delete-scholarship-question/{id}', 'destroy')->name('admin.scholarshipQuestion.destroy');
                Route::put('edit-scholarship-question/{question}/update', 'update')->name('admin.scholarshipQuestion.update');
            });

            Route::controller(StudentScholarshipApplicationController::class)->group(function () {
                Route::get('scholarship-applications', 'index')->name('admin.scholarship.applicants');
                Route::get('scholarship-applications/{id}/details', 'show')->name('admin.scholarship.applicantShow');
                Route::get('admin/scholarships/applications/export', 'export')->name('admin.scholarship.applications.export');
                Route::post('admin/scholarships/applications/import', 'import')->name('admin.scholarship.applications.import');
            });
        });
    });






    Route::prefix('student')->middleware(['auth', 'verified', 'role:student'])->group(function () {
        Route::controller(StudentDashboardController::class)->group(function () {

            Route::get('dashboard', 'dashboard')->name('student.dashboard');

            Route::get('logout', 'logout')->name('student.logout');

            Route::get('faculty-user/{slug}', 'facultyDetail')->name('student.faculty.show');
            Route::get('department-user/{id}', 'departmentDetail')->name('student.department.show');
        });

        Route::controller(StudentProfileController::class)->middleware('check.payment.status')->group(function () {
            Route::get('profile', 'profile')->name('student.profile');
            Route::get('profile/set-password', 'setPassword')->name('student.profile.setPassword');
            Route::patch('profile/update-password', 'updatePassword')->name('student.profile.updatePassword');
            Route::patch('profile/update', 'update')->name('student.profile.update');
        });

        // // NEW ADMISSION APPLICATION ROUTE ********
        Route::controller(StudentAdmissionApplicationController::class)->group(function () {

            Route::get('application-center', 'index')->name('student.admission.application')
                ->middleware('check.application.status');

            Route::post('application-center/apply', 'submitAdmissionApplication')->name('student.admission.application.apply');

            //     Route::get('congratulations', 'confirmAcceptanceOffer')->name('student.confirm.admissionStatus');
            //     Route::post('congratulations', 'admissionResponse')->name('student.admission.response');
        });















        // //NOTE: remember there is a task to delete application not paid after 20days(DeleteUnpaidApplications)
        Route::controller(ApplicationProcessController::class)->group(function () {
            // Route::get('application-process', 'index')->name('student.application.process');
            Route::get('/payment/{userSlug}', 'finalApplicationStep')->name('payment.view.finalStep')
                ->middleware('check.application.started');

            Route::post('application-process/store', 'processPayment')->name('student.payment.process');
            Route::get('handle/flutter-payment-call', 'handlePaymentCallBack')->name('student.payment.callbackFlutter');
            Route::get('handle/paystack-payment-call', 'handlePaymentCallBackPayStack')->name('student.payment.callbackPaystack');


            Route::get('/payment/success', 'showSuccess')->name('student.payment.success')
                ->middleware('check.application.payment.status');

            Route::get('/payment-slip', 'viewPaymentSlip')->name('student.payment.slip');
        });


        // // student will apply for scholarship section
        Route::controller(ScholarshipApplicationController::class)->group(function () {
            Route::get('scholarship', 'index')->name('student.scholarship.view');
            Route::post('scholarship/apply', 'apply')->name('student.scholarship.apply');
            Route::get('/scholarships/{id}', 'showDetail')->name('scholarships.show.detail');
            Route::get('scholarships/{id}/questions', 'getQuestions')->name('student.getQuestions');

            //     // application success route
            Route::get('scholarship-status', 'scholarshipStatus')->name('student.scholarships.status')->middleware('scholarship.submitted');
        });

        Route::controller(StudentAcceptanceFeeController::class)->group(function () {
            Route::get('pay-acceptance-fee', 'create')->name('student.pay_acceptance_fee.create');
            Route::post('pay-acceptance-fee/store', 'processPayments')->name('student.pay.acceptance.fee');
            Route::get('student/acceptance-fee/callback', 'handleCallback')->name('student.acceptance_fee.callback');

            Route::get('pay-acceptance-fee/success', 'success')->name('student.acceptance_fee.success')
                ->middleware('success.receipt');
            Route::get('pay-acceptance-fee/receipt', 'viewReceipt')->name('student.acceptance_fee.viewReceipt');
        });
    });
});
require __DIR__ . '/auth.php';
