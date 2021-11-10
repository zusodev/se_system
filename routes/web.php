<?php

Auth::routes(['register' => false, 'reset' => false, 'confirm' => false, 'verify' => false]);




Route::middleware(["auth"])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');


    Route::get('reports', "ReportController@index")->name("report.index");

    Route::get("reports/{email_project}/{type}/page", "ReportController@downloadPage")
        ->name('report.download.page');
    Route::get("reports/{email_project}/{type}", "ReportController@download")
        ->name('report.download');


    Route::resource("users", "UserController");


    Route::resource("target_departments", "TargetDepartmentController")->except(["show"]);


    Route::group(["prefix" => "target_companys/{target_company}/target_users"], function () {
        Route::get("upload", "TargetUserController@uploadCreate")->name("target_users.upload.create");
        Route::post("upload", "TargetUserController@uploadStore")->name("target_users.upload.store");
    });

    Route::resource("target_companys", "TargetCompanyController");


    Route::get("target_users/example_csv", "TargetUserController@downloadExampleCsv")->name("target_users.example.csv");
    Route::resource("target_users", "TargetUserController");

    Route::get("email/send", "EmailController@sendPage")->name("email.send.page");
    Route::post("email/send", "EmailController@send")->name("email.send");

    Route::post(
        "phishing_website/{phishing_website}/test",
        "PhishingWebsiteController@testTemplateFormSubmit"
    )->name("phishing_website.test.template.form.submit");

    Route::resource("phishing_websites", "PhishingWebsiteController")
        ->except(["create"]);

    Route::post(
        "email_templates/{email_template}/upload",
        "EmailTemplateController@uploadImage"
    )->name("email_templates.upload.image");

    Route::get("email_templates/{file_name}/default_attachment", "EmailTemplateController@downloadDefaultAttachment")
        ->name("email_templates.default.attachment");

    Route::group(["prefix" => "email_templates/{email_template}"], function () {
        Route::post("send_mail", "EmailTemplateController@sendEmail")
            ->name("email_templates.send.mail");

        Route::get("attachment", "EmailTemplateController@downloadAttachment")
            ->name("email_templates.show.attachment");
    });
    Route::resource("email_templates", "EmailTemplateController")
        ->except(["show"]);


    Route::resource("email_projects", "EmailProjectController")
        ->except(["edit", "update", "destroy"]);

    Route::get("email_jobs/logs_csv", "EmailJobController@logsCsv")->name("email_jobs.log.csv");
    Route::resource("email_jobs", "EmailJobController");


    Route::get("email_logs", "EmailLogController@index")
        ->name("email_logs.index");


    Route::get("email_logs/detail/{emailLog}", "EmailLogController@showDetail")
        ->name("email_logs.show.detail");
    Route::post("email_logs/resend", "EmailLogController@resend")
        ->name("email_logs.resend.log");

    Route::get("system_logs", "SystemLogController@index")
        ->name("system_logs.index");
});
