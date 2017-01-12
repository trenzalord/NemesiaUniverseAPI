<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 14/12/2016
 * Time: 13:47
 */

namespace NemesiaUniverse\Handlers;

use Psr\Http\Message\ ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;


class ApiMethodNotHandled extends \Slim\Handlers\NotAllowed
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, array $methods)
    {
        $message = "Request not allowed on " . $request->getUri()->getPath()
            . " with method " . $request->getMethod()
            . " methods available: " . implode(', ', $methods);
        $this->logger->debug($message);

        $data = [
            "status" => "error",
            "message" => $message,
        ];

        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return $response
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader("Content-type", "application/json")
            ->write($body);
    }

}