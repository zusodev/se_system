<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhishingWebsiteRequest;
use App\Models\PhishingWebsite;
use App\Modules\EmailLog\WebsiteTemplateResponser;
use App\Repositories\PhishingWebsiteRepository;
use App\Services\PhishingWebsiteService;
use Auth;
use Symfony\Component\HttpFoundation\Response;
use function response;
use function str_replace;
use function view;

class PhishingWebsiteController extends Controller
{
    private $repository;
    private $service;

    public function __construct(
        PhishingWebsiteRepository $repository,
        PhishingWebsiteService $service
    )
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return view("phishing-website.index", [
            "paginator" => $this->repository->paginateJoinWithProjectCount(),
        ]);
    }

    public function store(PhishingWebsiteRequest $request)
    {
        $attributes = $request->formAttributes();
        if ($this->repository->exists([["name", $attributes["name"]]])) {
            return $this->operationRedirectResponse(
                false,
                $attributes["name"] . " 樣式已存在，請修改名稱"
            );
        }

        return $this->operationRedirectResponse(
            ...($this->service->store($attributes))
        );
    }

    public function show(PhishingWebsite $phishingWebsite)
    {
        $route = route("phishing_website.test.template.form.submit", [$phishingWebsite->id]);

        $template = WebsiteTemplateResponser::setTemplateFormUrlScript(
            $phishingWebsite->template,
            $route
        );
        $template = str_replace("@email@", Auth::user()->email, $template);
        return response($template);
    }

    public function testTemplateFormSubmit(PhishingWebsite $phishingWebsite)
    {
        $postJson = request()->all();
        $phishingWebsite->setReceivedFormDataIsOk();
        return view("phishing-website.test", [
            "website" => $phishingWebsite,
            "postJson" => $postJson
        ]);
    }

    public function edit(PhishingWebsite $phishingWebsite)
    {
        $route = "/phishing_websites/{phishing_website}/upload?";

        return view("phishing-website.edit", [
            "website" => $phishingWebsite,
/*            "imageUrl" => str_replace(
                "{phishing_website}",
                $phishingWebsite->id,
                $route
            )*/
        ]);
    }

    public function update(PhishingWebsiteRequest $request, PhishingWebsite $phishingWebsite)
    {
        $attributes = $request->formAttributes();

        return $this->operationRedirectResponse(
            ...($this->service->update($phishingWebsite, $attributes))
        );
    }

    public function destroy(PhishingWebsite $phishingWebsite)
    {
        return $this->operationRedirectResponse(
            ...($this->service->destroy($phishingWebsite))
        );
    }
}
