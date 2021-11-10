<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\PhishingWebsiteResource
 *
 * @property int $id
 * @property string $file_name
 * @property int $phishing_website_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PhishingWebsite $phishingWebsite
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource wherePhishingWebsiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsiteResource whereUpdatedAt($value)
 */
	class PhishingWebsiteResource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailProject
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $company_id
 * @property int $email_template_id
 * @property int|null $phishing_website_id
 * @property string $sender_name
 * @property string $sender_email
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property string|null $log_redirect_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TargetCompany $company
 * @property-read \App\Models\EmailTemplate $emailTemplate
 * @property-read \App\Models\PhishingWebsite|null $website
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereEmailTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereLogRedirectTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject wherePhishingWebsiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereSenderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailProject whereUpdatedAt($value)
 */
	class EmailProject extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PhishingWebsite
 *
 * @property int $id
 * @property string $name
 * @property string $template
 * @property int $received_form_data_is_ok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PhishingWebsiteResource[] $phishingWebsiteResources
 * @property-read int|null $phishing_website_resources_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereReceivedFormDataIsOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PhishingWebsite whereUpdatedAt($value)
 */
	class PhishingWebsite extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailTemplateResource
 *
 * @property int $id
 * @property string $file_name
 * @property int $email_template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EmailTemplate $emailTemplate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource whereEmailTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplateResource whereUpdatedAt($value)
 */
	class EmailTemplateResource extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailLog
 *
 * @property int $id
 * @property string $uuid
 * @property int $job_id
 * @property int $target_user_id
 * @property int $is_send
 * @property int $is_open
 * @property int $is_open_link
 * @property int $is_open_attachment
 * @property int $is_post_from_website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EmailJob $emailJob
 * @property-read \App\Models\TargetUser $targetUser
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereIsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereIsOpenAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereIsOpenLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereIsPostFromWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereIsSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereTargetUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailLog whereUuid($value)
 */
	class EmailLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailJob
 *
 * @property int $id
 * @property int $project_id
 * @property int $department_id
 * @property int $status
 * @property int $send_total
 * @property int $expected_send_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EmailProject $emailProject
 * @property-read \App\Models\TargetDepartment $targetDepartment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereExpectedSendTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereSendTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailJob whereUpdatedAt($value)
 */
	class EmailJob extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailTemplate
 *
 * @property int $id
 * @property string $name
 * @property string|null $subject
 * @property string $template
 * @property string|null $attachment_name
 * @property string|null $attachment_mime_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed|null $attachment
 * @property int $attachment_is_exe
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmailTemplateResource[] $resources
 * @property-read int|null $resources_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereAttachmentIsExe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereAttachmentMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereAttachmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailTemplate whereUpdatedAt($value)
 */
	class EmailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TargetDepartment
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_test
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmailJob[] $emailJobs
 * @property-read int|null $email_jobs_count
 * @property-read \App\Models\TargetCompany $targetCompany
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TargetUser[] $targetUsers
 * @property-read int|null $target_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereIsTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetDepartment whereUpdatedAt($value)
 */
	class TargetDepartment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailDetailLog
 *
 * @property int $id
 * @property int $log_id
 * @property string $ips
 * @property string $agent
 * @property string $action
 * @property string $request_body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereIps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereLogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereRequestBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailDetailLog whereUpdatedAt($value)
 */
	class EmailDetailLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TargetUser
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int $department_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\TargetDepartment $targetDepartment
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetUser whereUpdatedAt($value)
 */
	class TargetUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UploadFailedTargetUser
 *
 * @property int $id
 * @property string $company_name
 * @property string $name
 * @property string $email
 * @property string $file_name
 * @property \Illuminate\Support\Carbon $uploaded_at
 * @property string $reason
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UploadFailedTargetUser whereUploadedAt($value)
 */
	class UploadFailedTargetUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TargetCompany
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TargetDepartment[] $targetDepartments
 * @property-read int|null $target_departments_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TargetCompany whereUpdatedAt($value)
 */
	class TargetCompany extends \Eloquent {}
}

