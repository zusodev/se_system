<?php


namespace App\Services;


use App\Models\PhishingWebsite;
use App\Repositories\PhishingWebsiteRepository;
use Exception;

class PhishingWebsiteService extends BaseService
{
    private $repository;

    public function __construct(PhishingWebsiteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $attributes)
    {
        try {
            $phishingWebsite = $this->repository
                ->create($attributes);
            $this->result = (bool)$phishingWebsite;

            /*$resourceManager = ResourceManager::instance($phishingWebsite->id);
            $this->result && $resourceManager->createFolder();*/
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function update(PhishingWebsite $phishingWebsite, array $attributes)
    {
        /*$resourceManager = ResourceManager::instance($phishingWebsite->id);*/

        try {
            $this->result = $this->repository->update(
                $phishingWebsite->id,
                $attributes
            );
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $attributes["name"] . " " . $this->newResultMessage()
        ];
    }

    public function destroy(PhishingWebsite $phishingWebsite)
    {
        /*$resourceManager = ResourceManager::instance($phishingWebsite->id);*/

        try {
            $this->result = (bool)$phishingWebsite->delete();
            /*$this->result && $resourceManager->removeFolder();*/
        } catch (Exception $e) {
            $this->setFailResult($e);
        }

        return [
            $this->result,
            $phishingWebsite->name . " " . $this->newResultMessage()
        ];
    }
}
