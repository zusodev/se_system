<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2019-05-01
 * Time: 01:21
 */

namespace App\Responses;


use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use function dd;
use function rawurlencode;
use function request;
use function sprintf;
use function strpos;

trait ControllerResponseTrait
{
    /* @var bool */
    protected $useFlashForInvalid;
    /* @var Closure */
    protected $falseResultClosure;

    protected function operationRedirectResponse(
        bool $result,
        string $message,
        string $path = ""
    ): RedirectResponse
    {
        $this->flashRequestByResult($result);

        $response = empty($path) ? back() : redirect()->to($path);

        if ($result) {
            $response->with("status", $message);
        } else {
            $response->withErrors(["operation.message" => $message]);
        }

        return $response;
    }

    protected function flashRequestByResult(bool $result): void
    {
        if (request()->getRealMethod() != Request::METHOD_POST) {
            return;
        }
        if (!$result) {
            request()->flash();
        }
    }

    protected function binaryFileResponse($binary, string $contentType, string $fileName = ""): Response
    {
        $response = Response::create($binary);

        $response->headers->set("Content-Type", $contentType);

        $disposition = $this->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );
        $response->headers->set("Content-Disposition", $disposition);

        return $response;
    }

    protected function csvResponse(string $content, string $fileName): Response
    {
        echo "\xEF\xBB\xBF";
        $response = Response::create($content);

        $disposition = $this->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName . ".csv"
        );

        $response->headers->set("Content-Type", "text/csv; charset=UTF-8");
        $response->headers->set("Content-Encoding", "UTF-8");
        /*$response->headers->set("Content-Transfer-Encoding", "binary");*/
        $response->headers->set("Content-Description", "File Transfer");
        $response->headers->set("Content-Disposition", $disposition);
        return $response;
    }

    protected function makeDisposition(string $disposition, string $filename, string $filenameFallback = '')
    {
        if (!\in_array($disposition, [HeaderUtils::DISPOSITION_ATTACHMENT, HeaderUtils::DISPOSITION_INLINE])) {
            throw new \InvalidArgumentException(sprintf('The disposition must be either "%s" or "%s".', HeaderUtils::DISPOSITION_ATTACHMENT, HeaderUtils::DISPOSITION_INLINE));
        }

        if ('' === $filenameFallback) {
            $filenameFallback = $filename;
        }

        /*// filenameFallback is not ASCII.
        if (!preg_match('/^[\x20-\x7e]*$/', $filenameFallback)) {
            throw new \InvalidArgumentException('The filename fallback must only contain ASCII characters.');
        }*/

        // percent characters aren't safe in fallback.
        if (false !== strpos($filenameFallback, '%')) {
            throw new \InvalidArgumentException('The filename fallback cannot contain the "%" character.');
        }

        // path separators aren't allowed in either.
        if (false !== strpos($filename, '/') || false !== strpos($filename, '\\') || false !== strpos($filenameFallback, '/') || false !== strpos($filenameFallback, '\\')) {
            throw new \InvalidArgumentException('The filename and the fallback cannot contain the "/" and "\\" characters.');
        }

        $params = ['filename' => $filenameFallback];
        if ($filename !== $filenameFallback) {
            $params['filename*'] = "utf-8''" . rawurlencode($filename);
        }

        return $disposition . '; ' . HeaderUtils::toString($params, ';');
    }
}
