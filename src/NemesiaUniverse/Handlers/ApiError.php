<?php

namespace NemesiaUniverse\Handlers;

use Psr\Http\Message\ ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class ApiError extends \Slim\Handlers\Error
{
    protected $logger;

    private $status_code = array("100","101","200","201","202","203","204","205","206","300","301","302","303","304","305","306","307","400","401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","500","501","502","503","504","505");

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, \Exception $exception)
    {
        $this->logger->critical($exception->getMessage());

        $status = $exception->getCode() ?: 500;
        $status = is_numeric($exception->getCode()) && in_array($exception->getCode(), $this->status_code) ? $exception->getCode() : 500;
        $data = [
            "status" => "error",
            "message" => $exception->getMessage(),
        ];

        $body = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return $response
                ->withStatus($status)
                ->withHeader("Content-type", "application/json")
                ->write($body);
    }
}
